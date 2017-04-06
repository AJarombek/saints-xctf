<?php

// Author: Andrew Jarombek
// Date: 12/8/2016 - 2/20/2017
// Controller for Getting the details necessary for the group page
// Version 0.4 (BETA) - 12/24/2016
// Version 0.6 (GROUPS UPDATE) - 2/20/2017

$LOG_TAG = "[WEB](groupdetails.php): ";

require_once('models/groupclient.php');

if (isset($_GET['viewedmessages'])) {
    session_start();

    // Manual Session Timeout Handling
    require_once('session_utils.php');
    SessionUtils::lastActivityTime();
    SessionUtils::createdTime();

    $groupname = $_GET['viewedmessages'];
    $_SESSION['notifications'][$groupname]['messages'] = false;

    echo "true";
    exit();

} else if (isset($_GET['accept_user'])) {

    require_once('models/userclient.php');

    $info = $_GET['accept_user'];
    $username = $info[0];
    $groupname = $info[1];

    error_log($LOG_TAG . "Accepting User: " . $username . " To Group: " . $groupname);

    $userclient = new UserClient();

    // Update the user JSON objects groups
    $userJSON = $userclient->get($username);
    $userobject = json_decode($userJSON, true);

    $groups = $userobject['groups'];

    error_log($LOG_TAG . "Original Groups: " . print_r($groups, true));

    foreach ($groups as $group => $groupinfo) {
        if ($groups[$group]['group_name'] == $groupname) {
            $userobject['groups'][$group]['status'] = 'accepted';
        }
    }

    $groups = $userobject['groups'];
    error_log($LOG_TAG . "New Groups: " . print_r($groups, true));

    $userJSON = json_encode($userobject);

    $userJSON = $userclient->put($username, $userJSON);
    
    echo "true";
    exit();

} else if (isset($_GET['reject_user'])) {

    require_once('models/userclient.php');

    $info = $_GET['accept_user'];
    $username = $info[0];
    $groupname = $info[1];

    error_log($LOG_TAG . "Rejecting User: " . $username . " To Group: " . $groupname);

    $userclient = new UserClient();

    // Update the user JSON objects groups
    $userJSON = $userclient->get($username);
    $userobject = json_decode($userJSON, true);

    $groups = $userobject['groups'];

    error_log($LOG_TAG . "Original Groups: " . print_r($groups, true));

    foreach ($groups as $group) {
        if ($group['group_name'] == $groupname) {
            // Remove this group for the user
            unset($groups[$group]);
        }
    }

    $userobject['groups'] = $groups;

    error_log($LOG_TAG . "New Groups: " . print_r($groups, true));

    $userJSON = json_encode($userobject);

    $userJSON = $userclient->put($username, $userJSON);
    
    echo "true";
    exit();

} else if (isset($_GET['send_email'])) {

    require_once('models/activationcodeclient.php');
    require_once('controller_utils.php');

    $email = $_GET['send_email'];
    error_log($LOG_TAG . "Sending email to: " . $email);

    $activationcodeclient = new ActivationCodeClient();

    // Update the user JSON objects groups
    $activationcodeJSON = $activationcodeclient->post(null);
    $code = $activationcodeJSON['activation_code'];

    error_log($LOG_TAG . "Activation Code Received: " . $code);

    $send_email = ControllerUtils::sendActivationCodeEmail($email, $code);

    echo "true";
    exit();

} else {

    $groupname = $_GET['name'];
    $username = $_SESSION['username'];
    $admin = false;
    $valid = true;
    $mygroup = false;

    // Check to see if the user is a member of this group
    $user = $_SESSION['user'];
    $groups = $user['groups'];
    foreach ($groups as $group) {
        if ($group['group_name'] == $groupname && $group['status'] == 'accepted') {
            $mygroup = true;

            // Now check to see if we are an admin
            if ($group['user'] == 'admin') {
                $admin = true;
            }

            break;
        }
    }

    $groupclient = new GroupClient();

    $groupJSON = $groupclient->get($groupname);
    $groupobject = json_decode($groupJSON, true);

    if ($groupobject != null && $groupname === $groupobject['group_name']) {
        error_log($LOG_TAG . "Viewing " . $groupname . "'s Group Page.");
        $group_title = $groupobject['group_title'];
        $members = $groupobject['members'];
        $membercount = 0;

        foreach ($members as $member) {
            if ($member['status'] == 'accepted') {
                $membercount++;
            }
        }

        $statistics = $groupobject['statistics'];
        $description = $groupobject['description'];
        $grouppic = $groupobject['grouppic'];

        // Decide whether to display any notifications
        if (isset($_SESSION['notifications'][$groupname])) {
            if ($_SESSION['notifications'][$groupname]['messages'] == true) {
                $newmessage = "true";
            }

            // The user has now seen the new logs
            $_SESSION['notifications'][$groupname]['logs'] = false;
        }

    } else {
        error_log($LOG_TAG . "Invalid Group Page");
    }
}