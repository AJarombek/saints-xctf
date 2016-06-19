<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 
// Controller for Getting the details necessary for the main logged in page

// Connect to database
require_once('models/database.php');
$db = databaseConnection();

if (!isset($db)) {
    $_SESSION['message'] = "Could not connect to the database.";
} else {
    
    require_once('models/queries.php');
    $queries = new Queries($db);

    // If pickgroups.js is checking to see if the user is already a group member
    if (isset($_GET['alreadypicked'])) {
    	session_start();

    	// Pick Groups Error Check and Get Teams
    	$_SESSION['grouperror'] = "Getting Team Data";
    	$teams = $queries->getTeams($_SESSION['username']);
    	$_SESSION['grouperror'] = "Successfully Got Team Data";

    	echo json_encode($teams);
    	exit();

    // Otherwise this call is from index.php
    } else {
    	$teams = $queries->getTeams($_SESSION['username']);
    	$logs = $queries->getLogs(); 	
    }
}
