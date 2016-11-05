<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 
// Controller for Subscribing groups to a user

session_start();

$LOG_TAG = "[WEB](addgroups.php): ";

if (isset($_POST['groups'])) {

    require_once('models/userclient.php');

    $groups = $_POST['groups'];
    $groupsobject = json_decode($groups, true);

    $username = $_SESSION['username'];
    $user = $_SESSION['user'];

    error_log($LOG_TAG . "The New Groups: " . $groups);

    $userclient = new UserClient();

    // Update the user JSON objects groups
    $user[$username]['groups'] = $groupsobject;
    $userJSON = json_encode($user);

    $userJSON = $userclient->put($username, $userJSON);
    $userobject = json_decode($userJSON, true);

    if ($userJSON != null && $userobject[$username]['username'] === $username) {
        error_log($LOG_TAG . "Groups were successfully added!");
        $_SESSION['user'] = $userobject;
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