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
        // Avoid zero division
        if ($miles == 0) {
            return '00:00:00';
        }

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

    // Function to send an email when a user submits feedback
    public static function sendFeedback($name, $content)
    {
        $to = "abjaro13@stlawu.edu";
        $subject = $name . " - Feedback";
        $txt = $content;
        $headers = "From: andy@saintsxctf.com";

        mail($to,$subject,$txt,$headers);
    }

    // Function to send an email when a user forgets their password
    public static function sendForgotPasswordEmail($email)
    {
        $activation_code = self::createCode(8);

        $to = $email;
        $subject = "Saintsxctf.com Forgot Password";
        $txt = "<h3>Forgot Password</h3>" + 
               "<br><p>You Forgot Your Password!  Your password is one-way encrypted and salted in our database" +
               "(AKA There is currently no known way for anyone to hack it).  So make it simple!</p>" +
               "<br><br><p>Use the following confirmation code to reset your password:</p><br>" +
               "<p><b>Code: </b> " + $activation_code + "</p>";
        $headers = "From: no_reply@saintsxctf.com";

        mail($to,$subject,$txt,$headers);

        // Return the activation code so it can be added to the database
        return $activation_code;
    }

    public static function createCode($length) 
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 
            ceil($length/strlen($x)) )),1,$length);
    }
}