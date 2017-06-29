<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 6/2/2017
// Controller for Subscribing groups to a user
// Version 0.4 (BETA) - 12/24/2016
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

session_start();

const DEBUG = false;

// Manual Session Timeout Handling
require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

$LOG_TAG = "[WEB](addgroups.php): ";

if (isset($_POST['groups'])) {

    require_once('models/userclient.php');
    require_once('models/notificationclient.php');
    require_once('models/groupclient.php');

    $groups = $_POST['groups'];
    $groupsobject = json_decode($groups, true);

    $username = $_SESSION['username'];
    $user = $_SESSION['user'];

    error_log($LOG_TAG . "Signed In As: " . $username);
    error_log($LOG_TAG . "The New Groups: " . $groups);

    // Build up an array of the group information
    $grouparray = array();

    foreach ($groupsobject as $groupname => $grouptitle) {
        array_push($grouparray, array("group_name"=>$groupname, "group_title"=>$grouptitle, "user"=>"user", "status"=>"pending"));
    }

    $userclient = new UserClient();

    // Update the user JSON objects groups
    $user['groups'] = $grouparray;
    $userJSON = json_encode($user);

    $userJSON = $userclient->put($username, $userJSON);
    $userobject = json_decode($userJSON, true);

    if ($userJSON != null && $userobject['username'] === $username) {
        error_log($LOG_TAG . "Groups were successfully added!");
        $_SESSION['user'] = $userobject;
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
                        $notificationclient = new NotificationClient();

                        $notificationJSON = $notificationclient->post($notificationJSON);
                        $notificationobject = json_decode($notificationJSON, true);
                        error_log($LOG_TAG . "The New Notification Sent: " . print_r($notificationobject, true));
                    }
                }
            }
        }

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