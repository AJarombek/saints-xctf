<?php

// Author: Andrew Jarombek
// Date: 8/31/2016 - 12/24/2016
// Controller for a users profile
// Version 0.4 (BETA) - 12/24/2016

session_start();

// Manual Session Timeout Handling
require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

require('views/header.php');
require('sendfeedback.php');
require('views/feedback.php');
require('profiledetails.php');
require('views/profileview.php');
require('views/footer.php');