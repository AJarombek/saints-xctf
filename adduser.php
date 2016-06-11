<?php

// Author: Andrew Jarombek
// Date: 5/31/2016 - 
// Controller for Adding a Singed Up User

session_start();

if (isset($_POST['userDetails'])) {
    
    // Connect to database
    require_once('models/database.php');
    $db = databaseConnection();
    
    if (!isset($db)) {
        $_SESSION['message'] = "Could not connect to the database.";
    } else {
        
        require_once('models/queries.php');
        $queries = new Queries($db);
        
        // Get all the user details from the post data
        $details = $_POST['userDetails'];
        $username = $details[0];
        $first = $details[1];
        $last = $details[2];
        $password = $details[3];
        
        $added = $queries->addUser($username, $first, $last, $password);
        
        // Return true if insert into database is successful
        if ($added) {
            // Create some session data for the user
            session_unset();
            $_SESSION['message'] = '_';
            $_SESSION['username'] = $username;
            $_SESSION['first'] = $first;
            $_SESSION['last'] = $last;
            echo 'true';
            exit();
        } else {
            echo 'false';
            exit();
        }
    }
}