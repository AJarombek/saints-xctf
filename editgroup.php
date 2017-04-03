<?php

// Author: Andrew Jarombek
// Date: 4/2/2017
// Controller for the edit group details page

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