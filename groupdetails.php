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

} else {

    $groupname = $_GET['name'];
    $username = $_SESSION['username'];
    $admin = false;
    $valid = true;

    $groupclient = new GroupClient();

    $groupJSON = $groupclient->get($groupname);
    $groupobject = json_decode($groupJSON, true);

    if ($groupobject != null && $groupname === $groupobject['group_name']) {
        error_log($LOG_TAG . "Viewing " . $groupname . "'s Group Page.");
        $group_title = $groupobject['group_title'];
        $members = $groupobject['members'];
        $membercount = count($members);
        $statistics = $groupobject['statistics'];
        $description = $groupobject['description'];
        $grouppic = $groupobject['grouppic'];

        // Decide whether to display any notifications
        if ($_SESSION['notifications'][$groupname]['messages'] == true) {
            $newmessage = "true";
        }

        // The user has now seen the new logs
        $_SESSION['notifications'][$groupname]['logs'] = false;

    } else {
        error_log($LOG_TAG . "Invalid Group Page");
    }
}