<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 
// Controller for logging a user out

session_start();
unset($_SESSION['username']);
unset($_SESSION['first']);
unset($_SESSION['last']);

exit();