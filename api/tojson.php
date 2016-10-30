<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Convert arrays from database queries to JSON objects for the API

require_once('queries.php');

class ToJSON
{
	private $queries;
	private $db;

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
			$usersJSON = "{ \"users\": { ";

			// Convert each individual user to a JSON string
			foreach ($users as $user) {
				$username = $user['username'];
				$userJSON = $this->userJSONConverter($user, $username);
				$usersJSON .= $userJSON . ",";
			}

			// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
			$usersJSON = substr($usersJSON, 0, -1) . " } }";

			return $usersJSON;

		} else {
			return 409;
		}
	}

	// Function that returns a specific user in the database in JSON format
	public function userToJSON($user)
	{
		$user_info = $this->queries->getUserDetails($user);

		if ($user_info != null) {

			$username = $user_info['username'];

			$userJSON = $this->userJSONConverter($user_info, $username);

			return $userJSON;

		} else {
			return 409;
		}
	}

	// Helper function that does the heavy lifting of creating the JSON object
	// Takes an array of user information from the database and a username as parameters
	private function userJSONConverter($user_info, $username) 
	{

		// Add data from user table to JSON object
		$userJSON = json_encode($user_info);
		$userJSON = "\"" . $username . "\":" . $userJSON;

		// Add data from groupmembers table to JSON object
		$userJSON = substr($userJSON, 0, -1) . ", \"groups\": ";
		$userJSON .= $this->groupMemberToJSON($username) . ",";

		// Add user statistics to JSON object
		$userJSON .= 
			"\"statistics\": { " . 
			"\"miles\": " . $this->queries->getUserMiles($username) .
			", \"milespastyear\": " . $this->queries->getUserMilesInterval($username, 'year') .
			", \"milespastmonth\": " . $this->queries->getUserMilesInterval($username, 'month') .
			", \"milespastweek\": " . $this->queries->getUserMilesInterval($username, 'week') .
			", \"runmiles\": " . $this->queries->getUserMilesExercise($username, 'run') .
			", \"runmilespastyear\": " . $this->queries->getUserMilesExerciseInterval($username, 'run', 'year') .
			", \"runmilespastmonth\": " . $this->queries->getUserMilesExerciseInterval($username, 'run', 'month') .
			", \"runmilespastweek\": " . $this->queries->getUserMilesExerciseInterval($username, 'run', 'week') .
			"} }";

		return $userJSON;
	}

	// Helper function for the user(s) JSON objects to get the users group info
	private function groupMemberToJSON($user)
	{
		$groups = $this->queries->getTeams($user);
		$groupsJSON = json_encode($groups);
		return $groupsJSON;
	}

	// Function that returns the logs in the database in JSON format
	public function logsToJSON() 
	{
		$logs = $this->queries->getLogs();

		// JSON string to build
		$logsJSON = "{ \"logs\": { ";

		// Convert each individual user to a JSON string
		foreach ($logs as $log) {
			$logno = $log['log_id'];
			$logsJSON .= "\"" . $logno . "\":" . json_encode($log) . ",";
		}

		// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
		$logsJSON = substr($logsJSON, 0, -1) . " } }";

		return $logsJSON;
	}

	// Function that returns a specific log in the database in JSON format
	public function logToJSON($logno) 
	{
		$log = $this->queries->getLogById($logno);

		if ($log != null) {
			$logJSON = "\"" . $logno . "\":" . json_encode($log);

			return $logJSON;

		} else {
			return 409;
		}
	}

	// Function that returns the groups in the database in JSON format
	public function groupsToJSON() 
	{
		$groups = $this->queries->getTeams();

		// JSON string to build
		$groupsJSON = "{ \"groups\": { ";

		// Convert each individual user to a JSON string
		foreach ($groups as $group) {
			$groupname = $group['group_name'];
			$groupJSON = $this->groupJSONConverter($group, $groupname);
			$groupsJSON .= $groupJSON . ",";
		}

		// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
		$groupsJSON = substr($groupsJSON, 0, -1) . " } }";

		return $groupsJSON;
	}

	// Function that returns a specific group in the database in JSON format
	public function groupToJSON($groupname) 
	{
		$group = $this->queries->getTeam($groupname);

		if ($group != null) {
			$groupJSON = $this->groupJSONConverter($group, $groupname);

			return $groupJSON;
		} else {
			return 409;
		}
	}

	// Helper function that does the heavy lifting of creating the JSON object
	// Takes an array of group information and a groupname as parameters
	private function groupJSONConverter($group, $groupname)
	{
		$groupJSON = "\"" . $groupname . "\":" . json_encode($group);
		$groupJSON = substr($groupJSON, 0, -1) . ",";

		$members = $this->queries->getTeamMembers($groupname);

		// Convert members from array of objects to array of usernames in the group
		$memberarray = array();
		foreach ($members as $member) {
			$memberarray[] = $member['username'];
		}

		$groupJSON .= "\"members\":" . json_encode($memberarray) . ",";

		// Add group statistics to JSON object
		$groupJSON .= 
			"\"statistics\": { " . 
			"\"miles\": " . $this->queries->getTeamMiles($groupname) .
			", \"milespastyear\": " . $this->queries->getTeamMilesInterval($groupname, 'year') .
			", \"milespastmonth\": " . $this->queries->getTeamMilesInterval($groupname, 'month') .
			", \"milespastweek\": " . $this->queries->getTeamMilesInterval($groupname, 'week') .
			", \"runmiles\": " . $this->queries->getTeamMilesExercise($groupname, 'run') .
			", \"runmilespastyear\": " . $this->queries->getTeamMilesExerciseInterval($groupname, 'run', 'year') .
			", \"runmilespastmonth\": " . $this->queries->getTeamMilesExerciseInterval($groupname, 'run', 'month') .
			", \"runmilespastweek\": " . $this->queries->getTeamMilesExerciseInterval($groupname, 'run', 'week') .
			"} }";

		return $groupJSON;
	}

	// Function that returns a feed of logs in the database in JSON format
	public function logFeedToJSON($paramtype, $sortparam, $limit, $offset) 
	{
		// Return either a feed of users logs or group member logs
		if ($paramtype === 'groups' || $paramtype === 'group') {
			$logs = $this->queries->getGroupLogFeed($sortparam, $limit, $offset);
		} else if ($paramtype === 'users' || $paramtype === 'user') {
			$logs = $this->queries->getUserLogFeed($sortparam, $limit, $offset);
		}

		if ($logs != null) {

			// JSON string to build
			$logsJSON = "{ \"logs\": { ";

			// Convert each individual user to a JSON string
			foreach ($logs as $log) {
				$logno = $log['log_id'];
				$logsJSON .= "\"" . $logno . "\":" . json_encode($log) . ",";
			}

			// Remove the final comma (invalid JSON syntax) and add final brace to JSON object
			$logsJSON = substr($logsJSON, 0, -1) . " } }";

			return $logsJSON;

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