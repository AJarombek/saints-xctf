<?php 

// Author: Andrew Jarombek
// Date: 10/30/2016 -
// A display page for testing the api

require_once('models\userclient.php');

$userclient = new UserClient();

$get_response = $userclient->get('jarbek');
$response = json_decode($get_response);

echo 'User GET Response: ' . print_r($get_response, true);
echo "Response Object: " . print_r($response);
