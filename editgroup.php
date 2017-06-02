<?php

// Author: Andrew Jarombek
// Date: 4/2/2017 - 6/2/2017
// Controller for the edit group details page
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

session_start();

require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

require('editgroupdetails.php');
require('views/header.php');
require('sendfeedback.php');
require('views/feedback.php');
require('views/editgroupview.php');
require('views/footer.php');