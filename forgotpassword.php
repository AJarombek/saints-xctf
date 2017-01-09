<?php

// Author: Andrew Jarombek
// Date: 1/9/2017
// Controller for when the user forgets their password

session_start();

require('views/header.php');
require('resetpassword.php');
require('views/forgotpasswordview.php');
require('views/footer.php');