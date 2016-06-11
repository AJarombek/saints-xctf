<?php 

// Author: Andrew Jarombek
// Date: 6/11/2016
// Just an error display page for debugging

session_start();

echo 'Error Message: ' . $_SESSION['message'];
echo 'Current Session Username: ' . $_SESSION['username'];
echo 'Current Session Name: ' . $_SESSION['first'] . ' ' . $_SESSION['last'];

session_unset();