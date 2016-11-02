<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 
// Controller for Subscribing teams to a user

session_start();

if (isset($_POST['teams'])) {

	// Decode the JSON object sent in the AJAX request to get the array
    $teams = json_decode(stripslashes($_POST['teams']));
    $size = sizeof($teams);
    $username = $_SESSION['username'];

    // Loop through all requested subscriptions and join the user to those teams
    foreach ($teams as $team) {
    	$joined = $queries->addTeams($username, $team);
    	if (!$joined) {
            echo 'false';
    		exit();
    	}
    }
    
    echo 'true';
    exit();
}