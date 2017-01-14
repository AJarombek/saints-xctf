<?php

// Author: Andrew Jarombek
// Date: 1/13/2017
// Controller for the forgot password feature

$LOG_TAG = "[WEB](resetpassword.php): ";

// If we are requesting a search for a username associated with an email in the database
if (isset($_GET['email_request'])) {

    require_once('models/userclient.php');
    require_once('controller_utils.php');

    $email = $_GET['email_request'];
    
    $userclient = new UserClient();

    $userJSON = $userclient->get($email);
    $userobject = json_decode($userJSON, true);

    error_log($LOG_TAG . "The Matching User object received: " . print_r($userobject, true));

    if ($userobject != null) {
        // If there is a user associated with this email, we want to send them an email with
        // their confirmation code.  This will be used at step 2 of reset password
        ControllerUtils::sendForgotPasswordEmail($email);

        echo 'true';
        exit();
    } else {
        echo 'false';
        exit();
    }
}