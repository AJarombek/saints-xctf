<?php

// Author: Andrew Jarombek
// Date: 11/8/2016 - 12/24/2016
// Controller for Getting the details necessary for the edit profile page
// Version 0.4 (BETA) - 12/24/2016

session_start();

$LOG_TAG = "[WEB](editprofiledetails.php): ";

require_once('models/userclient.php');

if (isset($_GET['getprofileinfo'])) {

    // Reply to the AJAX call with the user object
    error_log($LOG_TAG . "AJAX request to get profile info.");
    $user = $_SESSION['user'];
    $user['username'] = $_SESSION['username'];
    echo json_encode($user);
    exit();

} else if (isset($_POST['updateprofileinfo'])) {

    // Reply to the AJAX call with the user object
    error_log($LOG_TAG . "AJAX request to update profile info.");
    $userobject = json_decode($_POST['updateprofileinfo'], true);
    $user = $_SESSION['user'];
    $username = $_SESSION['username'];

    error_log($LOG_TAG . "The Pre-Edited User: " . print_r($user, true));

    $user[$username]['first'] = $userobject['first'];
    $user[$username]['last'] = $userobject['last'];

    if (isset($userobject['year']))
        $user[$username]['class_year'] = $userobject['year'];
    if (isset($userobject['location']))
        $user[$username]['location'] = $userobject['location'];
    if (isset($userobject['event']))
        $user[$username]['favorite_event'] = $userobject['event'];
    if (isset($userobject['description']))
        $user[$username]['description'] = $userobject['description'];

    if (isset($userobject['profilepic']))
        $user[$username]['profilepic'] = $userobject['profilepic'];
    if (isset($userobject['profilepic_name']))
        $user[$username]['profilepic_name'] = $userobject['profilepic_name'];

    $groupsobject = $userobject['groups'];
    $user[$username]['groups'] = $groupsobject;

    error_log($LOG_TAG . "The Post-Edited User: " . print_r($user, true));

    $userJSON = json_encode($user);

    $userclient = new UserClient();

    $userJSON = $userclient->put($username, $userJSON);
    $userobject = json_decode($userJSON, true);
    error_log($LOG_TAG . "The Edited User Received: " . print_r($userobject, true));

    if ($userobject != null) {
        echo 'true';
        $_SESSION['user'] = $userobject;
        $_SESSION['first'] = $userobject[$username]['first'];
        $_SESSION['last'] = $userobject[$username]['last'];
        $_SESSION['groups'] = $userobject[$username]['groups'];
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
