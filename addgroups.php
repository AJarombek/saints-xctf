<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 2/20/2017
// Controller for Subscribing groups to a user
// Version 0.4 (BETA) - 12/24/2016
// Version 0.6 (GROUPS UPDATE) - 2/20/2017

session_start();

// Manual Session Timeout Handling
require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

$LOG_TAG = "[WEB](addgroups.php): ";

if (isset($_POST['groups'])) {

    require_once('models/userclient.php');

    $groups = $_POST['groups'];
    $groupsobject = json_decode($groups, true);

    $username = $_SESSION['username'];
    $user = $_SESSION['user'];

    error_log($LOG_TAG . "Signed In As: " . $username);
    error_log($LOG_TAG . "The New Groups: " . $groups);

    $grouparray = array();

    foreach ($groups as $groupname => $grouptitle) {
        array_push($grouparray, array("group_name"=>$groupname, "group_title"=>$grouptitle, "user"=>"user", "status"=>"pending"));
    }

    $userclient = new UserClient();

    // Update the user JSON objects groups
    $user['groups'] = $grouparray;
    $userJSON = json_encode($user);

    $userJSON = $userclient->put($username, $userJSON);
    $userobject = json_decode($userJSON, true);

    if ($userJSON != null && $userobject['username'] === $username) {
        error_log($LOG_TAG . "Groups were successfully added!");
        $_SESSION['user'] = $userobject;
        $_SESSION['groups'] = $userobject['groups'];
        echo 'true';
        exit();
    } else {
        error_log($LOG_TAG . "Groups addition FAILED!");
        echo 'false';
        exit();
    }
} else {
    error_log($LOG_TAG . "NO GROUP INFO SENT!");
    echo 'false';
    exit();
}