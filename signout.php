<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 6/2/2017
// Controller for logging a user out
// Version 0.4 (BETA) - 12/24/2016
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

session_start();
session_destroy();

exit();