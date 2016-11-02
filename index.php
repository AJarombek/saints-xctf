<?php

// Author: Andrew Jarombek
// Date: 5/23/2016 - 
// Controller for Signed Out Home Page

session_start();

require('views/header.php');
if (isset($_SESSION['username'])) {
	//require('getmaindetails.php');
	require('views/main.php');
} else {
	require('views/home.php');
}
require('views/footer.php');