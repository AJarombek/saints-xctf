<?php

// Author: Andrew Jarombek
// Date: 4/2/2017 - 6/2/2017
// Controller for Getting the details necessary for the edit group page
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

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
    $groupobject = json_decode($_POST['updategroupinfo'], true);
    $groupname = $groupobject['group_name'];

    error_log($LOG_TAG . "The Pre-Edited Group: " . print_r($groupobject, true));

    $groupJSON = json_encode($groupobject);

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