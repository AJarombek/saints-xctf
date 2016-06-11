<?php

// Author: Andrew Jarombek
// Date: 5/28/2016 - 
// Controller for Authenticating a unique Username

session_start();

if (isset($_POST['un'])) {
    
    // Connect to database
    require_once('models/database.php');
    $db = databaseConnection();
    
    if (!isset($db)) {
        $_SESSION['message'] = "Could not connect to the database.";
    } else {
        
        require_once('models/queries.php');
        $queries = new Queries($db);
        
        $exists = $queries->usernameExists($_POST['un']);
        // Make Sure that the query is completed successfully
        //$_SESSION['message'] = "Result Equals: " . $exists;
        
        // Reply to the AJAX request with either the username exists or not
        if ($exists) {
            echo 'true';
        } else {
            echo 'false';
        }
        exit();
    }
}