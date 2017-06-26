<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 6/2/2017
// The Base of the API to get values from the database in JSON format
// Version 0.4 (BETA) - 12/24/2016
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

require_once('database.php');
require_once('rest_utils.php');
require_once('user_rest_controller.php');
require_once('log_rest_controller.php');
require_once('group_rest_controller.php');
require_once('logfeed_rest_controller.php');
require_once('comment_rest_controller.php');
require_once('message_rest_controller.php');
require_once('messagefeed_rest_controller.php');
require_once('rangeview_rest_controller.php');
require_once('activation_code_rest_controller.php');
require_once('notification_rest_controller.php');

// Connect to database
$db = databaseConnection();

if (!isset($db)) {
    RestUtils::sendResponse(404);
} else {
	$LOG_TAG = "[API](api.php): ";

	$contentType = 'application/json';
	$request_util = RestUtils::processRequest();

	// If the client is not authorized to view the API
	if ($request_util == null) {
		RestUtils::sendResponse(401);
	} else {

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
		$param6 = array_shift($request);

		// There are three different URI's that are available in the api:
		// saints-xctf/api/api.php/users/{username}
		// saints-xctf/api/api.php/logs/{log_number}
		// saints-xctf/api/api.php/groups/{groupname}
		// saints-xctf/api/api.php/logfeed/{paramtype}/{team || username}/{limit}/{offset}
		// saints-xctf/api/api.php/comments/{comment_number}
		// saints-xctf/api/api.php/message/{message_number}
		// saints-xctf/api/api.php/messagefeed/{paramtype}/{team || username}/{limit}/{offset}
		// saints-xctf/api/api.php/rangeview/{paramtype}/{team || username}/{start}/{end}
		// saints-xctf/api/api.php/activationcode/{code}
		// saints-xctf/api/api.php/notification/{notification_number}

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
		} else if ($param1 === "comments" || $param1 === "comment") {
			error_log($LOG_TAG . "Comments API Request");

			// The REST Call has been made searching for group data
			$comment_controller = new CommentRestController($db);
			$commentJSON = '';

			if ($param2 == null) {
				// The call is looking for a list of all groups
				// Only GET verb is allowed
				switch ($request_method) {
				    case 'get':
				    	error_log($LOG_TAG . "GET (All) Verb");
				    	$commentJSON = $comment_controller->get();
				    	if ($commentJSON == 409) {
				    		RestUtils::sendResponse(409);
				    	} else {
				    		RestUtils::sendResponse(200, $commentJSON, $contentType);
				    	}
				    	break;
				    case 'post':
				    	error_log($LOG_TAG . "POST Verb");
				    	$commentJSON = $comment_controller->post($data);
				    	if ($commentJSON == 400) {
				    		RestUtils::sendResponse(400);
				    	} else {
				    		RestUtils::sendResponse(201, $commentJSON, $contentType);
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
				    	$commentJSON = $comment_controller->get($param2);
				    	if ($commentJSON == 409) {
				    		RestUtils::sendResponse(409);
				    	} else {
				    		RestUtils::sendResponse(200, $commentJSON, $contentType);
				    	}
				    	break;
				    case 'put':
				    	error_log($LOG_TAG . "PUT Verb");
				    	$commentJSON = $comment_controller->put($param2, $data);
				    	if ($commentJSON == 409) {
				    		RestUtils::sendResponse(409);
				    	} else {
				    		RestUtils::sendResponse(200, $commentJSON, $contentType);
				    	}
				    	break;
				    case 'delete':
				    	error_log($LOG_TAG . "DELETE Verb");
				    	$commentJSON = $comment_controller->delete($param2); 
				    	if ($commentJSON == 405) {
				    		RestUtils::sendResponse(405);
				    	} else if ($commentJSON == 404) {
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
		} else if ($param1 === "messages" || $param1 === "message") {
			error_log($LOG_TAG . "Messages API Request");

			// The REST Call has been made searching for message data
			$message_controller = new MessageRestController($db);
			$messageJSON = '';

			if ($param2 == null) {
				// The call is looking for a list of all messages
				// Only GET & POST verbs are allowed
				switch ($request_method) {
				    case 'get':
				    	error_log($LOG_TAG . "GET (All) Verb");
				    	$messageJSON = $message_controller->get();
				    	if ($messageJSON == 409) {
				    		RestUtils::sendResponse(409);
				    	} else {
				    		RestUtils::sendResponse(200, $messageJSON, $contentType);
				    	}
				    	break;
				    case 'post':
				    	error_log($LOG_TAG . "POST Verb");
				    	$messageJSON = $message_controller->post($data);
				    	if ($messageJSON == 400) {
				    		RestUtils::sendResponse(400);
				    	} else {
				    		RestUtils::sendResponse(201, $messageJSON, $contentType);
				    	}
				    	break;
				    default:
				    	RestUtils::sendResponse(401);
				    	break;
				}
			} else {
				// The call is looking for a specific message
				// GET, PUT & DELETE verbs are allowed
				switch ($request_method) {
				    case 'get':
				    	error_log($LOG_TAG . "GET Verb");
				    	$messageJSON = $message_controller->get($param2);
				    	if ($messageJSON == 409) {
				    		RestUtils::sendResponse(409);
				    	} else {
				    		RestUtils::sendResponse(200, $messageJSON, $contentType);
				    	}
				    	break;
				    case 'put':
				    	error_log($LOG_TAG . "PUT Verb");
				    	$messageJSON = $message_controller->put($param2, $data);
				    	if ($messageJSON == 409) {
				    		RestUtils::sendResponse(409);
				    	} else {
				    		RestUtils::sendResponse(200, $messageJSON, $contentType);
				    	}
				    	break;
				    case 'delete':
				    	error_log($LOG_TAG . "DELETE Verb");
				    	$messageJSON = $message_controller->delete($param2); 
				    	if ($messageJSON == 405) {
				    		RestUtils::sendResponse(405);
				    	} else if ($messageJSON == 404) {
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
		} else if ($param1 === "messagefeeds" || $param1 === "messagefeed") {
			error_log($LOG_TAG . "MessageFeed API Request");

			// The REST Call has been made searching for log data
			$messagefeed_controller = new MessageFeedRestController($db);
			$messagefeedJSON = '';

			// Param2 => paramtype
			// Param3 => team || username
			// Param4 => limit
			// Param5 => offset
			if ($param2 != null && $param3 != null && $param4 != null && $param5 != null) {
				// The call is looking for a list of messages with certain constraints
				// Pass the get() method an array of query parameters
				$parameters = array('paramtype' => $param2, 'sortparam' => $param3, 
									'limit' => $param4, 'offset' => $param5);
				switch ($request_method) {
				    case 'get':
				    	$messagefeedJSON = $messagefeed_controller->get($parameters);

				    	if ($messagefeedJSON == 409) {
				    		RestUtils::sendResponse(409);
				    	} else {
				    		RestUtils::sendResponse(200, $messagefeedJSON, $contentType);
				    	}
				    	break;
				    default:
				    	RestUtils::sendResponse(401);
				    	break;
				}
			} 
		} else if ($param1 === "rangeview" || $param1 === "rangeviews") {
			error_log($LOG_TAG . "RangeView API Request");

			// The REST Call has been made searching for log range data
			$rangeview_controller = new RangeViewRestController($db);
			$rangeViewJSON = '';

			// Param2 => paramtype
			// Param3 => team || username
			// Param4 -> filter [rbso]
			// Param5 => start
			// Param6 => end
			if ($param2 != null && $param3 != null && $param4 != null && $param5 != null && $param6 != null) {
				// The call is looking for a user data with certain constraints
				// Pass the get() method an array of query parameters
				$parameters = array('paramtype' => $param2, 'sortparam' => $param3, 
									'filter' => $param4, 'start' => $param5, 'end' => $param6);
				switch ($request_method) {
				    case 'get':
				    	$rangeViewJSON = $rangeview_controller->get($parameters);

				    	if ($rangeViewJSON == 409) {
				    		RestUtils::sendResponse(409);
				    	} else {
				    		RestUtils::sendResponse(200, $rangeViewJSON, $contentType);
				    	}
				    	break;
				    default:
				    	RestUtils::sendResponse(401);
				    	break;
				}
			} 
		} else if ($param1 === "activationcode" || $param1 === "activationcodes") {
			error_log($LOG_TAG . "Activation Code API Request");

			// The REST Call has been made searching for activation code data
			$activationcode_controller = new ActivationCodeRestController($db);
			$activationcodeJSON = '';

			if ($param2 == null) {
				// Only POST verb is allowed
				switch ($request_method) {
				    case 'post':
				    	error_log($LOG_TAG . "POST Verb");
				    	$activationcodeJSON = $activationcode_controller->post($data);
				    	if ($activationcodeJSON == 400) {
				    		RestUtils::sendResponse(400);
				    	} else {
				    		RestUtils::sendResponse(201, $activationcodeJSON, $contentType);
				    	}
				    	break;
				    default:
				    	RestUtils::sendResponse(401);
				    	break;
				}
			} else {
				// GET & DELETE verbs are allowed
				switch ($request_method) {
				    case 'get':
				    	error_log($LOG_TAG . "GET Verb");
				    	$activationcodeJSON = $activationcode_controller->get($param2);
				    	if ($activationcodeJSON == 409) {
				    		RestUtils::sendResponse(409);
				    	} else {
				    		RestUtils::sendResponse(200, $activationcodeJSON, $contentType);
				    	}
				    	break;
				    case 'delete':
				    	error_log($LOG_TAG . "DELETE Verb");
				    	$activationcodeJSON = $activationcode_controller->delete($param2); 
				    	if ($activationcodeJSON == 405) {
				    		RestUtils::sendResponse(405);
				    	} else if ($activationcodeJSON == 404) {
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
		} else if ($param1 === "notification" || $param1 === "notifications") {
			error_log($LOG_TAG . "Notification API Request");

			// The REST Call has been made searching for activation code data
			$notification_controller = new NotificationRestController($db);
			$notificationJSON = '';

			if ($param2 == null) {
				// Only POST verb is allowed
				switch ($request_method) {
					case 'get':
				    	error_log($LOG_TAG . "GET Verb");
				    	$notificationJSON = $notification_controller->get();
				    	if ($notificationJSON == 409) {
				    		RestUtils::sendResponse(409);
				    	} else {
				    		RestUtils::sendResponse(200, $notificationJSON, $contentType);
				    	}
				    	break;
				    case 'post':
				    	error_log($LOG_TAG . "POST Verb");
				    	$notificationJSON = $notification_controller->post($data);
				    	if ($notificationJSON == 400) {
				    		RestUtils::sendResponse(400);
				    	} else {
				    		RestUtils::sendResponse(201, $notificationJSON, $contentType);
				    	}
				    	break;
				    default:
				    	RestUtils::sendResponse(401);
				    	break;
				}
			} else {
				// GET & DELETE verbs are allowed
				switch ($request_method) {
					case 'put':
				    	error_log($LOG_TAG . "PUT Verb");
				    	$notificationJSON = $notification_controller->put($param2, $data);
				    	if ($notificationJSON == 409) {
				    		RestUtils::sendResponse(409);
				    	} else {
				    		RestUtils::sendResponse(200, $notificationJSON, $contentType);
				    	}
				    	break;
				    case 'delete':
				    	error_log($LOG_TAG . "DELETE Verb");
				    	$notificationJSON = $notification_controller->delete($param2); 
				    	if ($notificationJSON == 405) {
				    		RestUtils::sendResponse(405);
				    	} else if ($notificationJSON == 404) {
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
		} else {
			RestUtils::sendResponse(404);
		}
	}
}