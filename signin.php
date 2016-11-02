<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 
// Controller for Authenticating a sign in attempt

session_start();

if (isset($_GET['cred'])) {

    // Get credentials from the GET data
    $credentials = $_GET['cred'];
    $username = $credentials[0];
    $password = $credentials[1];
    
    $authenticated = $queries->signIn($username, $password);
    
    // Reply to the AJAX request with either the username exists or not
    if ($authenticated) {
    	$details = $queries->getUserDetails($username);
        session_unset();
    	$_SESSION['username'] = $username;
    	$_SESSION['first'] = $details['first'];
    	$_SESSION['last'] = $details['last'];
        echo 'true';
    } else {
        echo 'false';
    }
    exit();
}