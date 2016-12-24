<?php

// Author: Andrew Jarombek
// Date: 12/8/2016 - 12/24/2016
// Controller for Getting the details necessary for the group page
// Version 0.4 (BETA) - 12/24/2016

$LOG_TAG = "[WEB](groupdetails.php): ";

require_once('models/groupclient.php');

$groupname = $_GET['name'];
$username = $_SESSION['username'];
$admin = false;
$valid = true;

$groupclient = new GroupClient();

$groupJSON = $groupclient->get($groupname);
$groupobject = json_decode($groupJSON, true);

if ($groupobject != null && $groupname === $groupobject[$groupname]['group_name']) {
    error_log($LOG_TAG . "Viewing " . $groupname . "'s Group Page.");
    $group_title = $groupobject[$groupname]['group_title'];
    $members = $groupobject[$groupname]['members'];
    $membercount = count($members);
    $statistics = $groupobject[$groupname]['statistics'];
    $description = $groupobject[$groupname]['description'];
    $grouppic = $groupobject[$groupname]['grouppic'];
} else {
    error_log($LOG_TAG . "Invalid Group Page");
}