<?php 

// Author: Andrew Jarombek
// Date: 6/11/2016 -
// Just an error display page for debugging

session_start();

echo "<p>ERROR LOG <br> _________ <br><br>";
echo 'USER SESSION ERRORS:<br><br>';
echo 'Error Message: ' . $_SESSION['message'] . '<br>';
echo 'Current Session Username: ' . $_SESSION['username'] . '<br>';
echo 'Current Session Name: ' . $_SESSION['first'] . ' ' . $_SESSION['last'] . '<br><br>';
//echo 'ADD TEAM ERRORS: <br>';
//echo 'Teams Added in Array: ' . $_SESSION['teamscontent'] . '<br>';
//echo '# Of Teams Added: ' . $_SESSION['teamslength'] . '<br><br>';
echo 'LOGIN ERRORS:' . '<br>';
echo 'Usernames Match: ' . $_SESSION['unmatch'] . '<br>';
echo 'Passwords Match: ' . $_SESSION['pmatch'] . '<br><br>';
echo 'New Salt: ' . $_SESSION['salt'] . '<br>';
echo 'Fully Ready to be Hashed: ' . $_SESSION['passalt'] . '<br><br>';
echo 'PICK GROUPS ERRORS:' . '<br>';
echo 'Point Reached: ' . $_SESSION['grouperror'] . '<br>';
//echo 'Usernames Match: ' . $_SESSION['unmatch'] . '<br>';
echo '</p>';

echo '<h4>';

echo '</h4>';

session_unset();