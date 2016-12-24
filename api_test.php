<?php 

// Author: Andrew Jarombek
// Date: 10/30/2016 - 12/24/2016
// A display page for testing the api
// Version 0.4 (BETA) - 12/24/2016

require_once('models\userclient.php');

$userclient = new UserClient();

$get_response = $userclient->get('jarbek');
$response = json_decode($get_response);

echo 'User GET Response: ' . print_r($get_response, true);
echo "Response Object: " . print_r($response);
