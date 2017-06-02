<?php

// Author: Andrew Jarombek
// Date: 8/31/2016 - 6/2/2017
// Controller for Getting the details necessary for the profile page
// Version 0.4 (BETA) - 12/24/2016
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

$LOG_TAG = "[WEB](profiledetails.php): ";

$username = $_GET['user'];
$myprofile = false;
$valid = false;

// The Users Running Logs
$logs = null;

// The Users Account Information
$users_username = $_SESSION['username'];

// Populate Profile Details based on if this is the signed in users profile or someone elses
if ($users_username === $username) {

    $myprofile = true;
    $valid = true;

    $name = $_SESSION['first'] . " " . $_SESSION['last'];
    $user = $_SESSION['user'];

    $favorite_event = $user['favorite_event'];
    $class_year = $user['class_year'];
    $location = $user['location'];
    $description = $user['description'];
    $member_since = $user['member_since'];

    $profpic = $user['profilepic'];
    $groups = $user['groups'];
    $flairs = $user['flair'];
    $statistics = $user['statistics'];
    $weekstart = $user['week_start'];
} else {

    $myprofile = false;

    require_once('models/userclient.php');

    $userclient = new UserClient();

    $userJSON = $userclient->get($username);
    $userobject = json_decode($userJSON, true);

    // Make sure the profile page is for a valid user
    if ($userJSON != null && $userobject['username'] === $username) {

        $valid = true;
        error_log($LOG_TAG . "Viewing " . $username . "'s Profile.");

        $user = $userobject;
        $name = $user['first'] . " " . $user['last'];

        $favorite_event = $user['favorite_event'];
        $class_year = $user['class_year'];
        $location = $user['location'];
        $description = $user['description'];
        $member_since = $user['member_since'];

        $profpic = $user['profilepic'];
        $groups = $user['groups'];
        $flairs = $user['flair'];
        $statistics = $user['statistics'];
        $weekstart = $user['week_start'];
    } else {
        $valid = false;
        error_log($LOG_TAG . "Invalid Profile Page");
    }
}

