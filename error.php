<?php 

// Author: Andrew Jarombek
// Date: 6/11/2016 -
// Just an error display page for debugging

session_start();

echo "<p>ERROR LOG <br> _________ <br><br>";
echo 'USER SESSION ERRORS:<br>';
echo 'Error Message: ' . $_SESSION['message'] . '<br>';
echo 'Current Session Username: ' . $_SESSION['username'] . '<br>';
echo 'Current Session Name: ' . $_SESSION['first'] . ' ' . $_SESSION['last'] . '<br>';
echo '<br>';
echo 'LOGIN ERRORS:' . '<br>';
echo 'Usernames Match: ' . $_SESSION['unmatch'] . '<br>';
echo 'Passwords Match: ' . $_SESSION['pmatch'] . '<br>';
echo '<p>';

session_unset();