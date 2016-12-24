<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 12/24/2016
// Controller for logging a user out
// Version 0.4 (BETA) - 12/24/2016

session_start();
unset($_SESSION['username']);
unset($_SESSION['first']);
unset($_SESSION['last']);

exit();