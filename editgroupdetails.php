<?php

// Author: Andrew Jarombek
// Date: 4/2/2017
// Controller for Getting the details necessary for the edit group page

$LOG_TAG = "[WEB](editgroupdetails.php): ";

require_once('models/groupclient.php');

if (isset($_GET['getgroupinfo'])) {

    // Reply to the AJAX call with the group object
    error_log($LOG_TAG . "AJAX request to get group info.");
    $groupname = $_GET['getgroupinfo'];
    
    $groupclient = new GroupClient();

    $groupJSON = $groupclient->get($groupname);
    $group = json_decode($groupJSON, true);

    echo json_encode($group);
    exit();

} else if (isset($_POST['updategroupinfo'])) {

    // Reply to the AJAX call with the group object
    error_log($LOG_TAG . "AJAX request to update group info.");
    $groupobject = json_decode($_POST['updateprofileinfo'], true);

    error_log($LOG_TAG . "The Pre-Edited Group: " . print_r($group, true));

    if (isset($groupobject['description']))
        $group['description'] = $groupobject['description'];
    if (isset($groupobject['week_start']))
        $group['week_start'] = $groupobject['week_start'];

    if (isset($groupobject['profilepic']))
        $group['profilepic'] = $groupobject['profilepic'];
    if (isset($groupobject['profilepic_name']))
        $group['profilepic_name'] = $groupobject['profilepic_name'];

    $groupJSON = json_encode($group);

    $groupclient = new GroupClient();

    $groupJSON = $groupclient->put($groupname, $groupJSON);
    $groupobject = json_decode($groupJSON, true);
    error_log($LOG_TAG . "The Edited User Received: " . print_r($groupobject, true));

    if ($groupobject != null) {
        echo 'true';
        error_log($LOG_TAG . "The Group was Successfully Edited.");
    } else {
        echo 'false';
        error_log($LOG_TAG . "The Group was UNSUCCESSFULLY Edited.");
    }
    exit();

}