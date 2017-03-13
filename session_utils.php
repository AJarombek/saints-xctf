<?php

// Author: Andrew Jarombek
// Date: 3/12/2017
// A class of utility functions for the sessions
// http://stackoverflow.com/questions/520237/how-do-i-expire-a-php-session-after-30-minutes

class SessionUtils
{

    // Set the last activity time and if expired, unset and destroy the session
	public static function lastActivityTime() 
    {
        if (isset($_SESSION['LastActivity']) && (time() - $_SESSION['LastActivity'] > 2592000)) {

            // last request was more than 1 month ago
            session_unset();
            session_destroy();
        }

        // Update the last activity timestamp
        $_SESSION['LastActivity'] = time();
    }

    // Set the session created time and if expired, regenerate the session id
    // This prevents attacks based on session fixation
    public static function createdTime() 
    {
        if (!isset($_SESSION['Created'])) {
            $_SESSION['Created'] = time();
        } else if (time() - $_SESSION['Created'] > 1800) {

            // Session was started more than 30 minutes ago
            session_regenerate_id(true);
            $_SESSION['Created'] = time();
        }
    }   	
}