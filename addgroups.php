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

		// Decode the JSON object sent in the AJAX request to get the array
        $teams = json_decode(stripslashes($_POST['teams']));
        $size = sizeof($teams);
        $username = $_SESSION['username'];

		// Error Check
        $_SESSION['grouperror'] .= "About to add teams. ";
        $_SESSION['grouperror'] .= $size . " ";
        $_SESSION['grouperror'] = $teams;

        // Loop through all requested subscriptions and join the user to those teams
        foreach ($teams as $team) {
        	$joined = $queries->addTeams($username, $team);
        	$_SESSION['message'] .= "Added Team (" . $team . ") ";
        	if (!$joined) {
                echo 'false';
        		exit();
        	}
        }
        
        echo 'true';
        exit();
    }
}