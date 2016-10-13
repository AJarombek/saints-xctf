<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// The Base of the API to get values from the database in JSON format

namespace Rest;
require_once('rest_request.php');
require_once('rest_controller.php');
require_once('user_rest_controller.php');
require_once('log_rest_controller.php');

$request_util = RestUtils::processRequest();

// get the HTTP method, path and body of the request
$request_method = $request_util->getRequestMethod();
$request = $request_util->getRequest();
$data = $request_util->getData();

// retrieve the parameters from the URI path
$param1 = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$param2 = array_shift($request)+0;

if ($param1 === "users") {
	// The REST Call has been made searching for user data
	$user_controller = new UserRestController();
	if ($param2 == null) {
		// The call is looking for a list of all users
		switch ($request_method) {
		    case 'get':
		    	$user_controller->get();
		    	break;
		    case 'post':
		    	$user_controller->post();
		    	break;
		    default:
		    	RestUtils::sendResponse(401);
		    	break;
		}
	} else {
		// The call is looking for a specific user
		switch ($request_method) {
		    case 'get':
		    	$user_controller->get($param2);
		    	break;
		    case 'put':
		    	$user_controller->put($param2);
		    	break;
		    case 'delete':
		    	$user_controller->delete($param2); 
		    	break;
		    default:
		    	RestUtils::sendResponse(401);
		    	break;
		}
	}
} else if ($param1 === "logs") {

} else {
	RestUtils::sendResponse(404);
}