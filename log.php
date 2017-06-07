<?php

// Author: Andrew Jarombek
// Date: 6/6/2017
// Controller for the log page

session_start();

// Manual Session Timeout Handling
require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

require('logdetails.php');
require('views/header.php');
require('sendfeedback.php');
require('views/feedback.php');
require('views/logview.php');
require('views/footer.php');