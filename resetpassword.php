<?php

// Author: Andrew Jarombek
// Date: 1/13/2017
// Controller for the forgot password feature

$LOG_TAG = "[WEB](resetpassword.php): ";

require_once('models/userclient.php');
require_once('controller_utils.php');

$userclient = new UserClient();

// If we are requesting a search for a username associated with an email in the database
if (isset($_GET['email_request'])) {

    session_start();

    $email = $_GET['email_request'];

    $userJSON = $userclient->get($email);
    $userobject = json_decode($userJSON, true);

    error_log($LOG_TAG . "The Matching User object received: " . print_r($userobject, true));

    if (isset($userobject)) {

        // If there is a user associated with this email, we want to send them an email with
        // their confirmation code.  This will be used at step 2 of reset password
        $code = ControllerUtils::sendForgotPasswordEmail($email);

        $keys = array_keys($userobject);
        $user = $userobject[$keys[0]];
        $username = $user['username'];

        // Add the forgot password code to the user object
        $userobject[$username]['fpw_code'] = $code;
        $userJSON = json_encode($userobject);

        error_log($LOG_TAG . "Forgot Password User: " . $username);
        $userJSON = $userclient->put($username, $userJSON);
        $userobject = json_decode($userJSON, true);
        error_log($LOG_TAG . "The Edited User Forgot Password Received: " . print_r($userobject, true));

        // Cache the users email for future use
        $_SESSION['fpw_email'] = $email;

        if ($userobject != null) {
            error_log($LOG_TAG . "The User Forgot Password was Successfully Edited.");
            echo 'true';
            exit();
        } else {
            error_log($LOG_TAG . "The User Forgot Password was UNSUCCESSFULLY Edited.");
            echo 'false';
            exit();
        }
    } else {
        echo 'false';
        exit();
    }

// If we are resetting a users password
} else if (isset($_GET['new_password'])) {

    session_start();

    $new_password = $_GET['new_password'];
    error_log($LOG_TAG . "The New Password Info: " . print_r($new_password, true));
    $forgot_code = $new_password[1];
    $password = $new_password[0];

    $userJSON = $userclient->get($_SESSION['fpw_email']);
    $userobject = json_decode($userJSON, true);

    error_log($LOG_TAG . "The Matching User object received: " . print_r($userobject, true));

    // Retrieve the username again.  Dont want to store username in session for a non signed in user
    // This does half the work for a hacker trying to access an account
    $keys = array_keys($userobject);
    $user = $userobject[$keys[0]];
    $username = $user['username'];

    $codes = $userobject[$username]['forgotpassword'];
    error_log($LOG_TAG . "The Users Forgot Password Codes: " . print_r($codes, true));

    if (in_array($forgot_code, $codes)) {

        // Create the salt and hash
        $salt = ControllerUtils::getSalt();
        $hash = crypt($password, '$2y$12$' . $salt);

        // Set new values in the user object for changing the password and deleting the forgot code
        $userobject[$username]['fpw_delete_code'] = $forgot_code;
        $userobject[$username]['fpw_password'] = $hash;
        $userJSON = json_encode($userobject);

        $userJSON = $userclient->put($username, $userJSON);
        $userobject = json_decode($userJSON, true);
        error_log($LOG_TAG . "The Edited User Forgot Password Received: " . print_r($userobject, true));

        if ($userobject != null) {
            error_log($LOG_TAG . "The User Password Was Reset.");
            echo 'true';
            exit();
        } else {
            error_log($LOG_TAG . "The User Password Was NOT Reset.");
            echo 'false';
            exit();
        }

    } else {
        echo 'false';
        exit();
    }
}