<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 
// Controller for Getting the details necessary for the main logged in page

// If pickgroups.js is checking to see if the user is already a group member
if (isset($_GET['alreadypicked'])) {
	session_start();

	// Pick Groups Error Check and Get Teams
	$teams = $queries->getTeams($_SESSION['username']);

	echo json_encode($teams);
	exit();

// Otherwise this call is from index.php
} else {
	$teams = $queries->getTeams($_SESSION['username']);
	$logs = $queries->getLogs(); 	
}
