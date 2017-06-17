<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 6/2/2017
// Controller for Getting the details necessary for the main logged in page
// Version 0.4 (BETA) - 12/24/2016
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

$LOG_TAG = "[WEB](getmaindetails.php): ";

$allgroups = array("mensxc"=>array("group_name"=>"mensxc", "group_title"=>"Men's Cross Country"), 
                    "wmensxc"=>array("group_name"=>"wmensxc", "group_title"=>"Women's Cross Country"), 
                    "menstf"=>array("group_name"=>"menstf", "group_title"=>"Men's Track & Field"),
                    "wmenstf"=>array("group_name"=>"wmenstf", "group_title"=>"Women's Track & Field"),
                    "alumni"=>array("group_name"=>"alumni", "group_title"=>"Alumni"));

// If pickgroups.js is checking to see if the user is already a group member
if (isset($_GET['alreadypicked'])) {
	session_start();

    // Manual Session Timeout Handling
    require_once('session_utils.php');
    SessionUtils::lastActivityTime();
    SessionUtils::createdTime();

	$username = $_SESSION['username'];
    $user = $_SESSION['user'];

    $groups = $user['groups'];

	echo json_encode($groups);
	exit();

// Otherwise this call is from index.php
} else {
    require_once('models/userclient.php');

    $username = $_SESSION['username'];

    $userclient = new UserClient();

    $userJSON = $userclient->get($_SESSION['user']);
    $userobject = json_decode($userJSON, true);
    $user = $userobject;

    $groups = $user['groups'];
    $notifications = $user['notifications'];

    // We want to see if there are any new logs or messages for each group
    $index = 0;
    foreach ($groups as $group) {
        $groupname = $group['group_name'];

        error_log($LOG_TAG . "Last SignIn: " . $_SESSION['last_signin']);
        error_log($LOG_TAG . "Newest Log: " . $group['newest_log']);
        error_log($LOG_TAG . "Newest Message: " . $group['newest_message']);

        // If a message in this group is newer than the last signin
        if (strtotime($group['newest_message']) > strtotime($_SESSION['last_signin'])) {

            // If a message in this group is newer than the last time the user checked their messages
            if (isset($_SESSION['groupview_' . $groupname])) {

                if (strtotime($group['newest_message']) > strtotime($_SESSION['groupview_' . $groupname])) {
                    $_SESSION['notifications'][$groupname]['messages'] = true;
                    error_log($LOG_TAG . "NEW Notifications for Group " . $groupname);
                } else {
                    $_SESSION['notifications'][$groupname]['messages'] = false;
                    error_log($LOG_TAG . "NO Notifications for Group " . $groupname . ", But new messages since sign on");
                }

            } else {
                $_SESSION['notifications'][$groupname]['messages'] = true;
                error_log($LOG_TAG . "NEW Notifications for Group " . $groupname);
            }
        } else {
            $_SESSION['notifications'][$groupname]['messages'] = false;
            error_log($LOG_TAG . "NO Notifications for Group " . $groupname);
        }

        $index++;
    }

    error_log($LOG_TAG . "User's Groups: " . print_r($groups, true));
}
