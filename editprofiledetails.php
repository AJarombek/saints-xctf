<?php

// Author: Andrew Jarombek
// Date: 11/8/2016 - 
// Controller for Getting the details necessary for the edit profile page

session_start();

$LOG_TAG = "[WEB](editprofiledetails.php): ";

if (isset($_GET['updateprofileinfo'])) {

    error_log($LOG_TAG . "AJAX request to update profile info.");

} else if (isset($_GET['getprofileinfo'])) {

    // Reply to the AJAX call with the user object
    error_log($LOG_TAG . "AJAX request to get profile info.");
    $user = $_SESSION['user'];
    $user['username'] = $_SESSION['username'];
    echo json_encode($user);
    exit();

} else if (isset($_GET['updateprofileinfo'])) {

    // Reply to the AJAX call with the user object
    error_log($LOG_TAG . "AJAX request to update profile info.");
    $userobject = json_decode($_GET['updateprofileinfo'], true);
    $user = $_SESSION['user'];
    $username = $_SESSION['username'];

    $user['first'] = $userobject['first'];
    $user['last'] = $userobject['last'];
    $user['year'] = $userobject['year'];
    $user['location'] = $userobject['location'];
    $user['favorite_event'] = $userobject['favorite_event'];
    $user['description'] = $userobject['description'];

    $user['profilepic'] = $userobject['profilepic'];
    $user['profilepic_name'] = $userobject['profilepic_name'];

    $groupsobject = $user['groups'];
    $user[$username]['groups'] = $groupsobject;

    $userJSON = json_encode($user);

    $userJSON = $userclient->put($username, $userJSON);
    $userobject = json_decode($userJSON, true);
    error_log($LOG_TAG . "The Edited User Received: " . print_r($userobject, true));

    if ($userobject != null && $userobject === $user) {
        echo 'true';
        error_log($LOG_TAG . "The User was Successfully Edited.");
    } else {
        echo 'false';
        error_log($LOG_TAG . "The User was UNSUCCESSFULLY Edited.");
    }
    exit();

} else {

    $username = $_SESSION['username'];
    $first = $_SESSION['first'];
    $last = $_SESSION['last'];
    $user = $_SESSION['user'];
    $groups = $user[$username]['groups'];
    $profpic = $user[$username]['profilepic'];
}
