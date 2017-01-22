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

if ($groupobject != null && $groupname === $groupobject['group_name']) {
    error_log($LOG_TAG . "Viewing " . $groupname . "'s Group Page.");
    $group_title = $groupobject['group_title'];
    $members = $groupobject['members'];
    $membercount = count($members);
    $statistics = $groupobject['statistics'];
    $description = $groupobject['description'];
    $grouppic = $groupobject['grouppic'];
} else {
    error_log($LOG_TAG . "Invalid Group Page");
}