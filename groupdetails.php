<?php

// Author: Andrew Jarombek
// Date: 12/8/2016 - 
// Controller for Getting the details necessary for the group page

$LOG_TAG = "[WEB](groupdetails.php): ";

$groupname = $_GET['name'];
$username = $_SESSION['username'];
$admin = false;
$valid = false;

$groupclient = new GroupClient();

$groupJSON = $groupclient->get($groupname);
$groupobject = json_decode($groupJSON, true);

