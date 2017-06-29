<?php

// Author: Andrew Jarombek
// Date: 11/8/2016 - 6/2/2017
// Controller for Getting the details necessary for the edit profile page
// Version 0.4 (BETA) - 12/24/2016
// Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

const DEBUG = false;

session_start();

// Manual Session Timeout Handling
require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

$LOG_TAG = "[WEB](editprofiledetails.php): ";

require_once('models/userclient.php');

if (isset($_GET['getprofileinfo'])) {

    // Reply to the AJAX call with the user object
    error_log($LOG_TAG . "AJAX request to get profile info.");
    $user = $_SESSION['user'];
    echo json_encode($user);
    exit();

} else if (isset($_POST['updateprofileinfo'])) {

    require_once('models/notificationclient.php');
    require_once('models/groupclient.php');

    // Reply to the AJAX call with the user object
    error_log($LOG_TAG . "AJAX request to update profile info.");
    $userobject = json_decode($_POST['updateprofileinfo'], true);
    $user = $_SESSION['user'];
    $username = $_SESSION['username'];

    error_log($LOG_TAG . "The Pre-Edited User: " . print_r($user, true));

    $user['first'] = $userobject['first'];
    $user['last'] = $userobject['last'];

    if (isset($userobject['email']))
        $user['email'] = $userobject['email'];
    if (isset($userobject['year']))
        $user['class_year'] = $userobject['year'];
    if (isset($userobject['location']))
        $user['location'] = $userobject['location'];
    if (isset($userobject['event']))
        $user['favorite_event'] = $userobject['event'];
    if (isset($userobject['description']))
        $user['description'] = $userobject['description'];
    if (isset($userobject['week_start']))
        $user['week_start'] = $userobject['week_start'];

    if (isset($userobject['profilepic']))
        $user['profilepic'] = $userobject['profilepic'];
    if (isset($userobject['profilepic_name']))
        $user['profilepic_name'] = $userobject['profilepic_name'];

    $groupsobject = $userobject['groups'];
    $user['groups'] = $groupsobject;

    error_log($LOG_TAG . "The Post-Edited User: " . print_r($user, true));

    $userJSON = json_encode($user);

    $userclient = new UserClient();

    $userJSON = $userclient->put($username, $userJSON);
    $userobject = json_decode($userJSON, true);
    error_log($LOG_TAG . "The Edited User Received: " . print_r($userobject, true));

    if ($userobject != null) {
        echo 'true';
        $_SESSION['user'] = $userobject;
        $_SESSION['first'] = $userobject['first'];
        $_SESSION['last'] = $userobject['last'];
        $_SESSION['groups'] = $userobject['groups'];

        // Next we want to send notifications about each of the pending group joins to the
        // appropriate group admins
        foreach ($userobject['groups'] as $group) {
            if ($group['status'] === "pending") {

                $groupclient = new GroupClient();
                $groupJSON = $groupclient->get($group["group_name"]);
                $groupobject = json_decode($groupJSON, true);

                // Send the notification only to admin
                foreach ($groupobject["members"] as $member => $memberobject) {
                    if ($memberobject['user'] === "admin") {
                        error_log($LOG_TAG . "The Admin User: " . print_r($member["username"]));

                        if (DEBUG === true) {
                            $notificationLink = "http://localhost/saints-xctf/group.php?name=" . $group["group_name"];
                        } else {
                            $notificationLink = "https://www.saintsxctf.com/group.php?name=" . $group["group_name"];
                        }

                        // Build the notification object
                        $notification['username'] = $memberobject["username"];
                        $notification['link'] = $notificationLink;
                        $notification['viewed'] = "N";
                        $notification['description'] = $_SESSION['first'] . " " . $_SESSION['last'] . " Has Requested to Join " . $group["group_title"];

                        $notificationJSON = json_encode($notification);
                        error_log($LOG_TAG . "The Notification: " . print_r($notification, true));
                        $notificationclient = new NotificationClient();

                        $notificationJSON = $notificationclient->post($notificationJSON);
                        $notificationobject = json_decode($notificationJSON, true);
                        error_log($LOG_TAG . "The New Notification Sent: " . print_r($notificationobject, true));
                    }
                }
            }
        }

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
    $groups = $user['groups'];
    $profpic = $user['profilepic'];
}
