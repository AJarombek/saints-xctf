<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 12/24/2016
// Controller for Getting the details necessary for the main logged in page
// Version 0.4 (BETA) - 12/24/2016

$LOG_TAG = "[WEB](getmaindetails.php): ";

// If pickgroups.js is checking to see if the user is already a group member
if (isset($_GET['alreadypicked'])) {
	session_start();

	$username = $_SESSION['username'];
    $user = $_SESSION['user'];

    $groups = $user['groups'];

	echo json_encode($groups);
	exit();

// Otherwise this call is from index.php
} else {
    $username = $_SESSION['username'];
    $user = $_SESSION['user'];

    $groups = $user['groups'];

    // We want to see if there are any new logs or messages for each group
    $index = 0;
    foreach ($groups as $group) {
        $groupname = $group['group_name'];

        error_log($LOG_TAG . "Last SignIn: " . $_SESSION['last_signin']);
        error_log($LOG_TAG . "Newest Log: " . $group['newest_log']);
        error_log($LOG_TAG . "Newest Message: " . $group['newest_message']);

        if (strtotime($group['newest_log']) > strtotime($_SESSION['last_signin'])) {
            $_SESSION['notifications'][$groupname]['logs'] = true;
        } else {
            $_SESSION['notifications'][$groupname]['logs'] = false;
        }

        if (strtotime($group['newest_message']) > strtotime($_SESSION['last_signin'])) {
            $_SESSION['notifications'][$groupname]['messages'] = true;
        } else {
            $_SESSION['notifications'][$groupname]['messages'] = false;
        }

        $index++;
    }

    error_log($LOG_TAG . "User's Groups: " . print_r($groups, true));
}
