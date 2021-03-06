<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 6/2/2017
// Convert arrays from database queries to JSON objects for the API
// Version 0.4 (BETA) - 12/24/2016
// Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

require_once('queries.php');

class ToJSON
{
	private $queries;
	private $db;

	// When in DEBUG mode, the JSON will be printed out in pretty fomatting
	const DEBUG = false;

	public function __construct($db)
	{
		$this->db = $db;
		$this->queries = new Queries($db);
	}

	// Function that returns the users in the database in JSON format
	public function usersToJSON() 
	{
		$users = $this->queries->getUsers();

		if ($users != null) {

			// JSON string to build
			$usersJSON = "[";

			// Convert each individual user to a JSON string
			foreach ($users as $user) {
				$username = $user['username'];
				$week_start = $user['week_start'];
				$userJSON = $this->userJSONConverter($user, $username, $week_start);
				$usersJSON .= $userJSON . ",";
			}

			// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
			$usersJSON = substr($usersJSON, 0, -1) . "]";

			if (self::DEBUG) {
				return $this->prettyPrintJSON($usersJSON);
			} else {
				return $usersJSON;
			}

		} else {
			return 409;
		}
	}

	// Function that returns a specific user in the database in JSON format
	public function userToJSON($user)
	{
		// Search for user by username first
		$user_info = $this->queries->getUserDetails($user);

		// If no username matches, search by email
		if ($user_info == null) {
			$user_info = $this->queries->getUserDetailsEmail($user);
		}

		// If there is still no match, search fails
		if ($user_info != null) {

			$username = $user_info['username'];
			$week_start = $user_info['week_start'];

			$userJSON = $this->userJSONConverter($user_info, $username, $week_start);

			if (self::DEBUG) {
				return $this->prettyPrintJSON($userJSON);
			} else {
				return $userJSON;
			}

		} else {
			return 409;
		}
	}

	// Helper function that does the heavy lifting of creating the JSON object
	// Takes an array of user information from the database and a username as parameters
	private function userJSONConverter($user_info, $username, $week_start) 
	{

		// Add data from user table to JSON object
		$userJSON = json_encode($user_info);
		$userJSON = $userJSON;

		// Add data from groupmembers table to JSON object
		$userJSON = substr($userJSON, 0, -1) . ", \"groups\": ";
		$userJSON .= $this->groupMemberToJSON($username) . ",";

		// Add data for the forgot password codes
		$pwcodes = $this->queries->getForgotPassword($username);
		$userJSON .= "\"forgotpassword\": [ ";
		foreach ($pwcodes as $code) {
			$userJSON .= "\"" . $code['forgot_code'] . "\",";
		}

		$userJSON = substr($userJSON, 0, -1) . "],";

		$flairs = $this->queries->getUserFlair($username);
		$userJSON .= "\"flair\": [ ";
		foreach ($flairs as $flair) {
			$userJSON .= "\"" . $flair['flair'] . "\",";
		}

		$userJSON = substr($userJSON, 0, -1) . "],";

		$userJSON .= " \"notifications\": ";

		$notifications = $this->queries->getUserNotifications($username);
		$userJSON .= json_encode($notifications) . ",";

		// Add user statistics to JSON object
		$userJSON .= 
			"\"statistics\": { " . 
			"\"miles\": " . $this->queries->getUserMiles($username) .
			", \"milespastyear\": " . $this->queries->getUserMilesInterval($username, 'year') .
			", \"milespastmonth\": " . $this->queries->getUserMilesInterval($username, 'month') .
			", \"milespastweek\": " . $this->queries->getUserMilesInterval($username, 'week', $week_start) .
			", \"runmiles\": " . $this->queries->getUserMilesExercise($username, 'run') .
			", \"runmilespastyear\": " . $this->queries->getUserMilesExerciseInterval($username, 'year', 'run') .
			", \"runmilespastmonth\": " . $this->queries->getUserMilesExerciseInterval($username, 'month', 'run') .
			", \"runmilespastweek\": " . $this->queries->getUserMilesExerciseInterval($username, 'week', 'run', $week_start) .
			", \"alltimefeel\": " . $this->queries->getUserAvgFeel($username) .
			", \"yearfeel\": " . $this->queries->getUserAvgFeelInterval($username, 'year') .
			", \"monthfeel\": " . $this->queries->getUserAvgFeelInterval($username, 'month') .
			", \"weekfeel\": " . $this->queries->getUserAvgFeelInterval($username, 'week', $week_start) .
			"} }";

		return $userJSON;
	}

	// Helper function for the user(s) JSON objects to get the users group info
	private function groupMemberToJSON($user)
	{
		$groups = $this->queries->getUserTeams($user);

		$groupJSON = "[ ";
		foreach ($groups as $group) {

			$groupJSON .= json_encode($group);

			$newestlog = $this->queries->getTeamNewestLogDate($group['group_name']);
			$groupJSON = substr($groupJSON, 0, -1) . ", \"newest_log\": \"" . $newestlog . "\"";
			$newestmessage = $this->queries->getTeamNewestMessageDate($group['group_name']);
			$groupJSON .= ", \"newest_message\": \"" . $newestmessage . "\"},";
		}

		$groupJSON = substr($groupJSON, 0, -1) . "]";
		return $groupJSON;
	}

	// Function that returns the logs in the database in JSON format
	public function logsToJSON() 
	{
		$logs = $this->queries->getLogs();

		// JSON string to build
		$logsJSON = "[";

		// Convert each individual user to a JSON string
		foreach ($logs as $log) {
			$logno = $log['log_id'];
			$logsJSON .= json_encode($log) . ",";

			$comments = $this->queries->getComments($logno);

			$logsJSON = substr($logsJSON, 0, -2) . ",\"comments\": [ ";
			foreach ($comments as $comment) {
				$commentno = $comment['comment_id'];
			 	$logsJSON .= json_encode($comment) . ",";
			}
			$logsJSON = substr($logsJSON, 0, -1) . " ] },";
		}

		// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
		$logsJSON = substr($logsJSON, 0, -1) . "]";

		if (self::DEBUG) {
			return $this->prettyPrintJSON($logsJSON);
		} else {
			return $logsJSON;
		}
	}

	// Function that returns a specific log in the database in JSON format
	public function logToJSON($logno) 
	{
		$log = $this->queries->getLogById($logno);

		if ($log != null) {
			$logJSON = json_encode($log);

			$comments = $this->queries->getComments($logno);

			$logJSON = substr($logJSON, 0, -1) . ",\"comments\": [ ";
			foreach ($comments as $comment) {
				$commentno = $comment['comment_id'];
			 	$logJSON .= json_encode($comment) . ",";
			}
			$logJSON = substr($logJSON, 0, -1) . " ] }";

			if (self::DEBUG) {
				return $this->prettyPrintJSON($logJSON);
			} else {
				return $logJSON;
			}

		} else {
			return 409;
		}
	}

	// Function that returns the groups in the database in JSON format
	public function groupsToJSON() 
	{
		$groups = $this->queries->getTeams();

		// JSON string to build
		$groupsJSON = "[";

		// Convert each individual user to a JSON string
		foreach ($groups as $group) {
			$groupname = $group['group_name'];
			$week_start = $group['week_start'];
			$groupJSON = $this->groupJSONConverter($group, $groupname, $week_start);
			$groupsJSON .= $groupJSON . ",";
		}

		// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
		$groupsJSON = substr($groupsJSON, 0, -1) . "]";

		if (self::DEBUG) {
			return $this->prettyPrintJSON($groupsJSON);
		} else {
			return $groupsJSON;
		}
	}

	// Function that returns a specific group in the database in JSON format
	public function groupToJSON($groupname) 
	{
		$group = $this->queries->getTeam($groupname);

		if ($group != null) {
			$week_start = $group['week_start'];

			$groupJSON = $this->groupJSONConverter($group, $groupname, $week_start);

			if (self::DEBUG) {
				return $this->prettyPrintJSON($groupJSON);
			} else {
				return $groupJSON;
			}
		} else {
			return 409;
		}
	}

	// Helper function that does the heavy lifting of creating the JSON object
	// Takes an array of group information and a groupname as parameters
	private function groupJSONConverter($group, $groupname, $week_start)
	{
		$groupJSON = json_encode($group);
		$groupJSON = substr($groupJSON, 0, -1) . ",";

		$members = $this->queries->getTeamMembers($groupname);

		$groupJSON .= "\"members\":" . json_encode($members) . ",";

		// Add group statistics to JSON object
		$groupJSON .= 
			"\"statistics\": { " . 
			"\"miles\": " . $this->queries->getTeamMiles($groupname) .
			", \"milespastyear\": " . $this->queries->getTeamMilesInterval($groupname, 'year') .
			", \"milespastmonth\": " . $this->queries->getTeamMilesInterval($groupname, 'month') .
			", \"milespastweek\": " . $this->queries->getTeamMilesInterval($groupname, 'week', $week_start) .
			", \"runmiles\": " . $this->queries->getTeamMilesExercise($groupname, 'run') .
			", \"runmilespastyear\": " . $this->queries->getTeamMilesExerciseInterval($groupname, 'run', 'year') .
			", \"runmilespastmonth\": " . $this->queries->getTeamMilesExerciseInterval($groupname, 'run', 'month') .
			", \"runmilespastweek\": " . $this->queries->getTeamMilesExerciseInterval($groupname, 'run', 'week', $week_start) .
			", \"alltimefeel\": " . $this->queries->getTeamAvgFeel($groupname) .
			", \"yearfeel\": " . $this->queries->getTeamAvgFeelInterval($groupname, 'year') .
			", \"monthfeel\": " . $this->queries->getTeamAvgFeelInterval($groupname, 'month') .
			", \"weekfeel\": " . $this->queries->getTeamAvgFeelInterval($groupname, 'week', $week_start) .
			"},";

		$groupJSON .=
			"\"leaderboards\": { " .
			"\"miles\": " . json_encode($this->queries->getTeamLeadersMiles($groupname)) .
			", \"milespastyear\": " . json_encode($this->queries->getTeamLeadersMilesInterval($groupname, 'year')) .
			", \"milespastmonth\": " . json_encode($this->queries->getTeamLeadersMilesInterval($groupname, 'month')) .
			", \"milespastweek\": " . json_encode($this->queries->getTeamLeadersMilesInterval($groupname, 'week', $week_start)) .
			"} }";

		return $groupJSON;
	}

	// Function that returns a feed of logs in the database in JSON format
	public function logFeedToJSON($paramtype, $sortparam, $limit, $offset) 
	{
		// Return either a feed of users logs or group member logs (or a feed of all logs)
		if ($paramtype === 'groups' || $paramtype === 'group') {
			$logs = $this->queries->getGroupLogFeed($sortparam, $limit, $offset);
		} else if ($paramtype === 'users' || $paramtype === 'user') {
			$logs = $this->queries->getUserLogFeed($sortparam, $limit, $offset);
		} else if ($paramtype === 'all') {
			$logs = $this->queries->getLogFeed($limit, $offset);
		}

		if ($logs != null) {

			// JSON string to build
			$logsJSON = "[";

			// Convert each individual user to a JSON string
			foreach ($logs as $log) {
				$logno = $log['log_id'];
				$logsJSON .= json_encode($log) . ",";

				$comments = $this->queries->getComments($logno);

				$logsJSON = substr($logsJSON, 0, -2) . ",\"comments\": [ ";
				foreach ($comments as $comment) {
					$commentno = $comment['comment_id'];
				 	$logsJSON .= json_encode($comment) . ",";
				}
				$logsJSON = substr($logsJSON, 0, -1) . " ] },";
			}

			// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
			$logsJSON = substr($logsJSON, 0, -1) . "]";

			if (self::DEBUG) {
				return $this->prettyPrintJSON($logsJSON);
			} else {
				return $logsJSON;
			}

		} else {
			return 409;
		}
	}

	// Function that returns the comments in the database in JSON format
	public function commentsToJSON() 
	{
		// JSON string to build
		$commentsJSON = "[";

		$comments = $this->queries->getAllComments();

		foreach ($comments as $comment) {
			$commentno = $comment['comment_id'];
		 	$commentsJSON .= json_encode($comment) . ",";
		}

		// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
		$commentsJSON = substr($commentsJSON, 0, -1) . "]";

		if (self::DEBUG) {
			return $this->prettyPrintJSON($commentsJSON);
		} else {
			return $commentsJSON;
		}
	}

	// Function that returns a specific comment in the database in JSON format
	public function commentToJSON($commentid) 
	{
		$comment = $this->queries->getComment($commentid);

		if ($comment != null) {
			$commentJSON = json_encode($comment);

			if (self::DEBUG) {
				return $this->prettyPrintJSON($commentJSON);
			} else {
				return $commentJSON;
			}

		} else {
			return 409;
		}
	}

	// Function that returns the messages in the database in JSON format
	public function messagesToJSON() 
	{
		$messages = $this->queries->getMessages();

		// JSON string to build
		$messagesJSON = "[";

		// Convert each individual message to a JSON string
		foreach ($messages as $message) {
			$messageno = $message['message_id'];
			$messagesJSON .= json_encode($message) . ",";
		}

		// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
		$messagesJSON = substr($messagesJSON, 0, -1) . "]";

		if (self::DEBUG) {
			return $this->prettyPrintJSON($messagesJSON);
		} else {
			return $messagesJSON;
		}
	}

	// Function that returns a specific message in the database in JSON format
	public function messageToJSON($messageno) 
	{
		$message = $this->queries->getMessageById($messageno);

		if ($message != null) {
			$messageJSON = json_encode($message);

			if (self::DEBUG) {
				return $this->prettyPrintJSON($messageJSON);
			} else {
				return $messageJSON;
			}

		} else {
			return 409;
		}
	}

	// Function that returns a feed of messages in the database in JSON format
	public function messageFeedToJSON($paramtype, $sortparam, $limit, $offset) 
	{
		// Return either a feed of users messages or group member messages
		if ($paramtype === 'groups' || $paramtype === 'group') {
			$messages = $this->queries->getGroupMessageFeed($sortparam, $limit, $offset);
		} else if ($paramtype === 'users' || $paramtype === 'user') {
			$messages = $this->queries->getUserMessageFeed($sortparam, $limit, $offset);
		}

		if ($messages != null) {

			// JSON string to build
			$messagesJSON = "[";

			// Convert each individual message to a JSON string
			foreach ($messages as $message) {
				$messageno = $message['message_id'];
				$messagesJSON .= json_encode($message) . ",";
			}

			// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
			$messagesJSON = substr($messagesJSON, 0, -1) . "]";

			if (self::DEBUG) {
				return $this->prettyPrintJSON($messagesJSON);
			} else {
				return $messagesJSON;
			}

		} else {
			return 409;
		}
	}

	// Function that returns a range view in the database in JSON format
	public function rangeViewToJSON($paramtype, $sortparam, $filter, $start, $end) 
	{
		// Return either a users range view or groups range view (or a full site range view)
		if ($paramtype === 'groups' || $paramtype === 'group') {
			$rangeview = $this->queries->getGroupRangeView($sortparam, $filter, $start, $end);
		} else if ($paramtype === 'users' || $paramtype === 'user') {
			$rangeview = $this->queries->getUserRangeView($sortparam, $filter, $start, $end);
		} else if ($paramtype === 'all') {
			$rangeview = $this->queries->getRangeView($filter, $start, $end);
		}

		if ($rangeview != null) {

			// JSON string to build
			$rangeviewJSON = json_encode($rangeview);

			if (self::DEBUG) {
				return $this->prettyPrintJSON($rangeviewJSON);
			} else {
				return $rangeviewJSON;
			}

		} else {
			return 409;
		}
	}

	// Function that returns a specific message in the database in JSON format
	public function activationCodeToJSON($activation_code) 
	{
		$exists = $this->queries->codeExists($activation_code);

		error_log($activation_code);

		if ($exists) {
			$codeJSON = '{ "activation_code": "' . $activation_code . '" }';

			if (self::DEBUG) {
				return $this->prettyPrintJSON($codeJSON);
			} else {
				return $codeJSON;
			}

		} else {
			return 409;
		}
	}

	// Function that converts all the notifications in the database to JSON format
	public function notificationsToJSON()
	{
		$notifications = $this->queries->getNotifications();

		// JSON string to build
		$notificationsJSON = "[";

		// Convert each individual message to a JSON string
		foreach ($notifications as $notification) {
			$notificationno = $notification['notification_id'];
			$notificationsJSON .= json_encode($notification) . ",";
		}

		// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
		$notificationsJSON = substr($notificationsJSON, 0, -1) . "]";

		if (self::DEBUG) {
			return $this->prettyPrintJSON($notificationsJSON);
		} else {
			return $notificationsJSON;
		}
	}

	// Function that returns a specific notification in the database in JSON format
	public function notificationToJSON($notificationno) 
	{
		$notification = $this->queries->getNotification($notificationno);

		if ($notification != null) {
			$notificationJSON = json_encode($notification);

			if (self::DEBUG) {
				return $this->prettyPrintJSON($notificationJSON);
			} else {
				return $notificationJSON;
			}

		} else {
			return 409;
		}
	}

	// Helper function to print out JSON in an indented format
	// http://stackoverflow.com/questions/6054033/pretty-printing-json-with-php
	// USE THIS FOR DEBUGGING JSON FOMATTING
	private function prettyPrintJSON($JSON)
	{
		$result = '';
		$level = 0;
		$in_quotes = false;
		$in_escape = false;
		$ends_line_level = NULL;
		$json_length = strlen($JSON);

		// Go through the string one character at a time
		for ($i = 0; $i < $json_length; $i++) {
			$char = $JSON[$i];
			$new_line_level = NULL;
			$post = "";
			if ($ends_line_level !== NULL) {
				$new_line_level = $ends_line_level;
				$ends_line_level = NULL;
			}
			if ($in_escape) {
				$in_escape = false;
			} else if ($char === '"') {
				$in_quotes = !$in_quotes;
			} else if (!$in_quotes) {
				switch ($char) {
					case '}': case ']':
						$level--;
						$ends_line_level = NULL;
						$new_line_level = $level;
						break;

					case '{': case '[':
						$level++;

					case ',':
						$ends_line_level = $level;
						break;

					case ':':
						$post = " ";
						break;

					case " ": case "\t": case "\n": case "\r":
						$char = "";
						$ends_line_level = $new_line_level;
						$new_line_level = NULL;
						break;
				}
			} else if ($char === '\\') {
				$in_escape = true;
			}
			if ($new_line_level !== NULL) {
				$result .= "\n".str_repeat("\t", $new_line_level);
			} 
			$result .= $char.$post;
		}
		return $result;
	}
}