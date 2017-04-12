<?php

// Author: Andrew Jarombek
// Date: 10/31/2016 - 2/20/2017
// A class of utility functions for the website controllers
// Version 0.4 (BETA) - 12/24/2016
// Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
// Version 0.6 (GROUPS UPDATE) - 2/20/2017

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
            return '00:00';
        }

        // Convert the time to seconds
        $str_time = preg_replace("/^([\d]{2})\:([\d]{2})\:([\d]{2})$/", "$1:$2:$3", $time);
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;

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
    public static function sendForgotPasswordEmail($email, $username)
    {
        $activation_code = self::createCode(8);

        $to = $email;
        $subject = "Saintsxctf.com Forgot Password";
        $txt = "<html>
                    <head>
                        <title>HTML email</title>
                    </head>
                    <body>
                        <h3>Forgot Password</h3>
                        <br><p>You Forgot Your Password!  Your password is one-way encrypted and salted in our database" .
                          " (AKA There is currently no known way for anyone to hack it).  So make it simple!</p>" .
                          "<br><br><p>Use the following confirmation code to reset your password:</p><br>" .
                        "<p><b>Code: </b> " . $activation_code . "</p>" .
                        "<p><b>Username: </b> " . $username . "</p>" .
                    "</body>
                </html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: admin@saintsxctf.com\r\n";
        $headers .= "Reply-To: admin@saintsxctf.com \r\n";
        $headers .= "Return-Path: admin@saintsxctf.com\r\n";
        $headers .= "X-Mailer: PHP \r\n";

        mail($to,$subject,$txt,$headers);

        // Return the activation code so it can be added to the database
        return $activation_code;
    }

    public static function sendActivationCodeEmail($email, $activation_code)
    {

        $to = $email;
        $subject = "SaintsXCTF.com Invite";
        $txt = "<html>
                    <head>
                        <title>HTML email</title>
                    </head>
                    <body>
                        <h3>SaintsXCTF.com Invite</h3>
                        <br><p>You Have Been Invited to SaintsXCTF.com!</p>" .
                          "<br><br><p>Use the following confirmation code to sign up:</p><br>" .
                        "<p><b>Code: </b> " . $activation_code . "</p>" .
                    "</body>
                </html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: admin@saintsxctf.com\r\n";
        $headers .= "Reply-To: admin@saintsxctf.com \r\n";
        $headers .= "Return-Path: admin@saintsxctf.com\r\n";
        $headers .= "X-Mailer: PHP \r\n";

        mail($to,$subject,$txt,$headers);

        // Return the activation code
        return $activation_code;
    }

    public static function createCode($length) 
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 
            ceil($length/strlen($x)) )),1,$length);
    }
}