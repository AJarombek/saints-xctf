<?php

// Author: Andrew Jarombek
// Date: 5/28/2016 - 12/24/2016
// Controller for Picking Groups When First Signed In
// Version 0.4 (BETA) - 12/24/2016

session_start();

// Manual Session Timeout Handling
require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

require('views/header.php');
require('views/groupselect.php');
require('views/footer.php');