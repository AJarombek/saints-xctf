<?php

// Author: Andrew Jarombek
// Date: 5/23/2016 - 12/24/2016
// Controller for Signed Out Home Page
// Version 0.4 (BETA) - 12/24/2016

session_start();

require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

require('views/header.php');

if (isset($_SESSION['username'])) {
	require('sendfeedback.php');
	require('views/feedback.php');
	require('getmaindetails.php');
	require('views/main.php');
} else {
	require('views/home.php');
}
require('views/footer.php');