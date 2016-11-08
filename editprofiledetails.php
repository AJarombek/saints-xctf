<?php

// Author: Andrew Jarombek
// Date: 11/8/2016 - 
// Controller for Getting the details necessary for the edit profile page

$LOG_TAG = "[WEB](editprofiledetails.php): ";

$username = $_SESSION['username'];
$first = $_SESSION['first'];
$last = $_SESSION['last'];
$user = $_SESSION['user'];
$groups = $user[$username]['groups'];
$profpic = $user[$username]['profilepic'];