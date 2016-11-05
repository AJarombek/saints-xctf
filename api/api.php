<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// The Base of the API to get values from the database in JSON format

require_once('database.php');
require_once('rest_utils.php');
require_once('user_rest_controller.php');
require_once('log_rest_controller.php');
require_once('group_rest_controller.php');
require_once('logfeed_rest_controller.php');

// Connect to database
$db = databaseConnection();

if (!isset($db)) {
    RestUtils::sendResponse(404);
} else {
	$LOG_TAG = "[API](api.php): ";

	$contentType = 'application/json';
	$request_util = RestUtils::processRequest();

	error_log($LOG_TAG . "The Request Object: " . print_r($request_util, true));

	// get the HTTP method, path and body of the request
	$request_method = $request_util->getRequestMethod();
	$request = $request_util->getRequest();
	$data = $request_util->getData();

	// retrieve the parameters from the URI path
	$param1 = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
	$param2 = array_shift($request);
	$param3 = array_shift($request);
	$param4 = array_shift($request);
	$param5 = array_shift($request);

	// There are three different URI's that are available in the api:
	// saints-xctf/api/api.php/users/{username}
	// saints-xctf/api/api.php/logs/{log_number}
	// saints-xctf/api/api.php/groups/{groupname}
	// saints-xctf/api/api.php/logfeed/{paramtype}/{team || username}/{limit}/{offset}

	if ($param1 === "users" || $param1 === "user") {
		error_log($LOG_TAG . "User API Request");

		// The REST Call has been made searching for user data
		$user_controller = new UserRestController($db);
		$userJSON = '';

		if ($param2 == null) {
			// The call is looking for a list of all users
			// Only GET & POST verbs are allowed
			switch ($request_method) {
			    case 'get':
			    	error_log($LOG_TAG . "GET (All) Verb");
			    	$userJSON = $user_controller->get();
			    	if ($userJSON == 409) {
			    		RestUtils::sendResponse(409);
			    	} else {
			    		RestUtils::sendResponse(200, $userJSON, $contentType);
			    	}
			    	break;
			    case 'post':
			    	error_log($LOG_TAG . "POST Verb");
			    	$userJSON = $user_controller->post($data);
			    	if ($userJSON == 400) {
			    		RestUtils::sendResponse(400);
			    	} else {
			    		RestUtils::sendResponse(201, $userJSON, $contentType);
			    	}
			    	break;
			    default:
			    	RestUtils::sendResponse(401);
			    	break;
			}
		} else {
			// The call is looking for a specific user
			// GET, PUT & DELETE verbs are allowed
			switch ($request_method) {
			    case 'get':
			    	error_log($LOG_TAG . "GET Verb");
			    	$userJSON = $user_controller->get($param2);
			    	if ($userJSON == 409) {
			    		RestUtils::sendResponse(409);
			    	} else {
			    		RestUtils::sendResponse(200, $userJSON, $contentType);
			    	}
			    	break;
			    case 'put':
			    	error_log($LOG_TAG . "PUT Verb");
			    	$userJSON = $user_controller->put($param2, $data);
			    	if ($userJSON == 409) {
			    		RestUtils::sendResponse(409);
			    	} else {
			    		RestUtils::sendResponse(200, $userJSON, $contentType);
			    	}
			    	break;
			    case 'delete':
			    	error_log($LOG_TAG . "DELETE Verb");
			    	$userJSON = $user_controller->delete($param2); 
			    	if ($userJSON == 405) {
			    		RestUtils::sendResponse(405);
			    	} else if ($userJSON == 404) {
			    		RestUtils::sendResponse(404);
			    	} else {
			    		RestUtils::sendResponse(204);
			    	}
			    	break;
			    default:
			    	RestUtils::sendResponse(401);
			    	break;
			}
		}
	} else if ($param1 === "logs" || $param1 === "log") {
		error_log($LOG_TAG . "Logs API Request");

		// The REST Call has been made searching for log data
		$log_controller = new LogRestController($db);
		$logJSON = '';

		if ($param2 == null) {
			// The call is looking for a list of all logs
			// Only GET & POST verbs are allowed
			switch ($request_method) {
			    case 'get':
			    	error_log($LOG_TAG . "GET (All) Verb");
			    	$logJSON = $log_controller->get();
			    	if ($logJSON == 409) {
			    		RestUtils::sendResponse(409);
			    	} else {
			    		RestUtils::sendResponse(200, $logJSON, $contentType);
			    	}
			    	break;
			    case 'post':
			    	error_log($LOG_TAG . "POST Verb");
			    	$logJSON = $log_controller->post($data);
			    	if ($logJSON == 400) {
			    		RestUtils::sendResponse(400);
			    	} else {
			    		RestUtils::sendResponse(201, $logJSON, $contentType);
			    	}
			    	break;
			    default:
			    	RestUtils::sendResponse(401);
			    	break;
			}
		} else {
			// The call is looking for a specific log
			// GET, PUT & DELETE verbs are allowed
			switch ($request_method) {
			    case 'get':
			    	error_log($LOG_TAG . "GET Verb");
			    	$logJSON = $log_controller->get($param2);
			    	if ($logJSON == 409) {
			    		RestUtils::sendResponse(409);
			    	} else {
			    		RestUtils::sendResponse(200, $logJSON, $contentType);
			    	}
			    	break;
			    case 'put':
			    	error_log($LOG_TAG . "PUT Verb");
			    	$logJSON = $log_controller->put($param2, $data);
			    	if ($logJSON == 409) {
			    		RestUtils::sendResponse(409);
			    	} else {
			    		RestUtils::sendResponse(200, $logJSON, $contentType);
			    	}
			    	break;
			    case 'delete':
			    	error_log($LOG_TAG . "DELETE Verb");
			    	$logJSON = $log_controller->delete($param2); 
			    	if ($logJSON == 405) {
			    		RestUtils::sendResponse(405);
			    	} else if ($logJSON == 404) {
			    		RestUtils::sendResponse(404);
			    	} else {
			    		RestUtils::sendResponse(204);
			    	}
			    	break;
			    default:
			    	RestUtils::sendResponse(401);
			    	break;
			}
		}
	} else if ($param1 === "groups" || $param1 === "group") {
		error_log($LOG_TAG . "Groups API Request");

		// The REST Call has been made searching for group data
		$group_controller = new GroupRestController($db);
		$groupJSON = '';

		if ($param2 == null) {
			// The call is looking for a list of all groups
			// Only GET verb is allowed
			switch ($request_method) {
			    case 'get':
			    	error_log($LOG_TAG . "GET (All) Verb");
			    	$groupJSON = $group_controller->get();
			    	if ($groupJSON == 409) {
			    		RestUtils::sendResponse(409);
			    	} else {
			    		RestUtils::sendResponse(200, $groupJSON, $contentType);
			    	}
			    	break;
			    default:
			    	RestUtils::sendResponse(401);
			    	break;
			}
		} else {
			// The call is looking for a specific group
			// GET & PUT verbs are allowed
			switch ($request_method) {
			    case 'get':
			    	error_log($LOG_TAG . "GET Verb");
			    	$groupJSON = $group_controller->get($param2);
			    	if ($groupJSON == 409) {
			    		RestUtils::sendResponse(409);
			    	} else {
			    		RestUtils::sendResponse(200, $groupJSON, $contentType);
			    	}
			    	break;
			    case 'put':
			    	error_log($LOG_TAG . "PUT Verb");
			    	$groupJSON = $group_controller->put($param2, $data);
			    	if ($groupJSON == 409) {
			    		RestUtils::sendResponse(409);
			    	} else {
			    		RestUtils::sendResponse(200, $groupJSON, $contentType);
			    	}
			    	break;
			    default:
			    	RestUtils::sendResponse(401);
			    	break;
			}
		} 
	} else if ($param1 === "logfeeds" || $param1 === "logfeed") {
		error_log($LOG_TAG . "LogFeed API Request");

		// The REST Call has been made searching for log data
		$logfeed_controller = new LogFeedRestController($db);
		$logfeedJSON = '';

		// Param2 => paramtype
		// Param3 => team || username
		// Param4 => limit
		// Param5 => offset
		if ($param2 != null && $param3 != null && $param4 != null && $param5 != null) {
			// The call is looking for a list of logs with certain constraints
			// Pass the get() method an array of query parameters
			$parameters = array('paramtype' => $param2, 'sortparam' => $param3, 
								'limit' => $param4, 'offset' => $param5);
			switch ($request_method) {
			    case 'get':
			    	$logfeedJSON = $logfeed_controller->get($parameters);

			    	if ($logfeedJSON == 409) {
			    		RestUtils::sendResponse(409);
			    	} else {
			    		RestUtils::sendResponse(200, $logfeedJSON, $contentType);
			    	}
			    	break;
			    default:
			    	RestUtils::sendResponse(401);
			    	break;
			}
		} 
	} else {
		RestUtils::sendResponse(404);
	}
}