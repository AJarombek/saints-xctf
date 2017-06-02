<?php

// Author: Andrew Jarombek
// Date: 8/31/2016 - 6/2/2017
// Controller for a users profile
// Version 0.4 (BETA) - 12/24/2016
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

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