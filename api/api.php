<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// The Base of the API to get values from the database in JSON format

namespace Rest;
require_once('rest_utils.php');
require_once('rest_request.php');
require_once('rest_controller.php');
require_once('user_rest_controller.php');
require_once('log_rest_controller.php');
require_once('database.php');

// Connect to database
$db = databaseConnection();

if (!isset($db)) {
    RestUtils::sendResponse(404);
} else {

	$request_util = RestUtils::processRequest();

	// get the HTTP method, path and body of the request
	$request_method = $request_util->getRequestMethod();
	$request = $request_util->getRequest();
	$data = $request_util->getData();

	// retrieve the parameters from the URI path
	$param1 = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
	$param2 = array_shift($request);

	if ($param1 === "users") {
		// The REST Call has been made searching for user data
		$user_controller = new UserRestController($db);
		$userJSON = '';

		if ($param2 == null) {
			// The call is looking for a list of all users
			switch ($request_method) {
			    case 'get':
			    	$userJSON = $user_controller->get();
			    	RestUtils::sendResponse(200, $userJSON, 'application/json');
			    	break;
			    case 'post':
			    	$userJSON = $user_controller->post();
			    	break;
			    default:
			    	RestUtils::sendResponse(401);
			    	break;
			}
		} else {
			// The call is looking for a specific user
			switch ($request_method) {
			    case 'get':
			    	$userJSON = $user_controller->get($param2);
			    	break;
			    case 'put':
			    	$userJSON = $user_controller->put($param2);
			    	break;
			    case 'delete':
			    	$userJSON = $user_controller->delete($param2); 
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
}