<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 
// Controller for Authenticating a sign in attempt

session_start();

if (isset($_GET['cred'])) {
    
    // Connect to database
    require_once('models/database.php');
    $db = databaseConnection();
    
    if (!isset($db)) {
        $_SESSION['message'] = "Could not connect to the database.";
    } else {
        
        require_once('models/queries.php');
        $queries = new Queries($db);

        // Get credentials from the GET data
        $credentials = $_GET['cred'];
        $username = $credentials[0];
        $password = $credentials[1];
        
        $authenticated = $queries->signIn($username, $password);
        
        // Reply to the AJAX request with either the username exists or not
        if ($authenticated) {
        	$details = $queries->getUserDetails($username);
            session_unset();
            $_SESSION['message'] = 'Sign In Success!';
        	$_SESSION['username'] = $username;
        	$_SESSION['first'] = $details['first'];
        	$_SESSION['last'] = $details['last'];
            echo 'true';
        } else {
            $_SESSION['message'] = 'Sign In Failed!';
            echo 'false';
        }
        exit();
    }
}