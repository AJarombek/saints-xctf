<?php

// Author: Andrew Jarombek
// Date: 11/8/2016 - 
// Controller for Getting the details necessary for the edit profile page

$LOG_TAG = "[WEB](editprofiledetails.php): ";

if (isset($_GET['updateprofileinfo'])) {

    error_log($LOG_TAG . "AJAX request to update profile info.");

} else if (isset($_GET['getprofileinfo'])) {

    // Reply to the AJAX call with the user object
    error_log($LOG_TAG . "AJAX request to get profile info.");
    echo json_encode($_SESSION['user']);
    exit();

} else if (isset($_GET['getusername'])) {

    // Reply to the AJAX call with the user object
    error_log($LOG_TAG . "AJAX request to get the username.");
    $username = $_SESSION['username'];
    echo $username;
    exit();

} else {

    $username = $_SESSION['username'];
    $first = $_SESSION['first'];
    $last = $_SESSION['last'];
    $user = $_SESSION['user'];
    $groups = $user[$username]['groups'];
    $profpic = $user[$username]['profilepic'];
}
