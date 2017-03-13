<?php

// Author: Andrew Jarombek
// Date: 1/9/2017 - 1/18/2017
// Controller for when the user forgets their password
// Version 0.5 (FEEDBACK UPDATE) - 1/18/2017

session_start();

// Manual Session Timeout Handling
require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

require('views/header.php');
require('resetpassword.php');
require('views/forgotpasswordview.php');
require('views/footer.php');