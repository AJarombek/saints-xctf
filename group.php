<?php

// Author: Andrew Jarombek
// Date: 12/8/2016 - 12/24/2016
// Controller for a group profile
// Version 0.4 (BETA) - 12/24/2016

session_start();

// Manual Session Timeout Handling
require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

require('views/header.php');
require('sendfeedback.php');
require('views/feedback.php');
require('groupdetails.php');
require('views/groupview.php');
require('views/footer.php');