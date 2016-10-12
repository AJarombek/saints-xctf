<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// The Base of the API to get values from the database in JSON format

namespace Rest;
require_once('rest_request.php');
require_once('rest_controller.php');
require_once('user_rest_controller.php');
require_once('log_rest_controller.php');

$data = RestUtils::processRequest();

// get the HTTP method, path and body of the request
$method = $data->getMethod();
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

// retrieve the table and key from the path
$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$key = array_shift($request)+0;

$url = $_SERVER['REQUEST_URI'];