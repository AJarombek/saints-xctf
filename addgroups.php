<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 
// Controller for Subscribing teams to a user

session_start();

if (isset($_POST['teams'])) {
    
    // Connect to database
    require_once('models/database.php');
    $db = databaseConnection();
    
    if (!isset($db)) {
        $_SESSION['message'] = "Could not connect to the database.";
    } else {
        
        require_once('models/queries.php');
        $queries = new Queries($db);

        // Loop through all requested subscriptions and join the user to those teams
        foreach ($_POST['teams'] as $team) {
        	$joined = $queries->addTeams($_SESSION['username'], $team);
        	if (!$joined) {
        		echo 'false';
        		exit();
        	}
        }
        
        echo 'true';
        exit();
    }
}