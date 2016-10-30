<?php 

// Author: Andrew Jarombek
// Date: 10/30/2016 -
// A display page for testing the api

require_once('models\userclient.php');

$userclient = new UserClient();

$get_response = $userclient->get('jarbek');

echo 'User GET Response: ' . print_r($get_response, true);
