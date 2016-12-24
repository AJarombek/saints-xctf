<?php

// Author: Andrew Jarombek
// Date: 10/31/2016 - 12/24/2016
// A class of utility functions for the website controllers
// Version 0.4 (BETA) - 12/24/2016

class ControllerUtils
{
	public static function getSalt() 
    {
        // Salt used for the BCrypt hashing algorithm
        $salt = substr(strtr(base64_encode(openssl_random_pseudo_bytes(22)), '+', '.'), 0, 22);
        return $salt;
    }	

    // Function to convert a given distance and metric to its mileage equivalent
    public static function convertToMiles($distance, $metric)
    {
        switch ($metric) {
            case 'miles':
                return $distance;
                break;
            case 'meters':
                return ControllerUtils::convertFromMeters($distance);
                break;
            case 'kilometers':
                return ControllerUtils::convertFromKilometers($distance);
                break;
            
            default:
                return $distance;
                break;
        }
    }

    // Helper funtion to convert Meters to Miles
    private static function convertFromMeters($distance)
    {
        return ($distance / 1609.344); 
    }

    // Helper function to convert Kilometers to Miles
    private static function convertFromKilometers($distance)
    {
        return ($distance * 0.621317);
    }

    // Function for taking the miles and time and finding the pace
    public static function milePace($miles, $time)
    {
        // Convert the time to seconds
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time);
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

        // Find the pace in seconds
        $milePaceSeconds = $time_seconds / $miles;

        // Convert back into hh:mm:ss
        $s = round($milePaceSeconds);
        return sprintf('%02d:%02d:%02d', ($s/3600), ($s/60%60), $s%60);
    }

    public static function sendFeedback($name, $content)
    {
        $to = "abjaro13@stlawu.edu";
        $subject = $name . " - Feedback";
        $txt = $content;
        $headers = "From: andy@saintsxctf.com";

        mail($to,$subject,$txt,$headers);
    }
}