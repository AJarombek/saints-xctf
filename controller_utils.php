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
}