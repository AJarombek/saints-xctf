<?php

// Author: Andrew Jarombek
// Date: 10/31/2016 - 
// A class of utility functions for the website controllers

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
}