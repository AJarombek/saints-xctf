<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 
// Controller for Getting the details necessary for the main logged in page

$LOG_TAG = "[WEB](getmaindetails.php): ";

// If pickgroups.js is checking to see if the user is already a group member
if (isset($_GET['alreadypicked'])) {
	session_start();

	$username = $_SESSION['username'];
    $user = $_SESSION['user'];

    $groups = $user[$username]['groups'];

	echo json_encode($groups);
	exit();

// Otherwise this call is from index.php
} else {
    $username = $_SESSION['username'];
    $user = $_SESSION['user'];

    $groups = $user[$username]['groups'];
}
