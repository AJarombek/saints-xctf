<?php

// Author: Andrew Jarombek
// Date: 10/20/2016 - 
// Convert JSON Objects from the REST API to Query parameters

require_once('queries.php');

class ToQuery
{
	private $queries;
	private $db;
	const LOG_TAG = "[API](toquery.php): ";

	public function __construct($db)
	{
		$this->db = $db;
		$this->queries = new Queries($db);
	}

	// Method to take a JSON object and get the appropriate parameter values
	// for adding a user to the database
	public function addJSONUser($user) 
	{
		error_log(self::LOG_TAG . "The JSON object received: " . print_r($user, true));

		$keys = array_keys($user);
		$userArray = $user[$keys[0]];

		$username = $userArray['username'];
		$first = $userArray['first'];
		$last = $userArray['last'];
		$password = $userArray['password'];
		$salt = $userArray['salt'];
		$success = $this->queries->addUser($username, $first, $last, $password, $salt);

		// If addUser returns false, there is an internal server error
		if (!$success) {
			return 409;
		} else {
			return $username;
		}
	}

	// Method to take a username, and two JSON objects (the old user object and the updated user object)
	// and use them to update the database to reflect changes
	public function updateJSONUser($username, $olduser, $newuser) 
	{
		$oldUserArray = json_decode($olduser, true);
		$newUserArray = json_decode($newuser, true);

		// Check to see if any modifications were made
		if ($newUserArray != $oldUserArray) {
			// Update the User properties
			$success = $this->queries->updateUser($username, $newUserArray);

			// If updateUser returns false, there is an internal server error
			if (!$success) {
				return 409;
			}

			$oldGroups = $oldUserArray['groups'];
			$newGroups = $newUserArray['groups'];

			// Check to see if the teams have been altered
			if ($oldGroups != $newGroups) {
				// Update the users team membership
				$success = $this->queries->updateTeams($username, $oldGroups, $newGroups);

				// If updateTeams returns false, there is an internal server error (HTTP Error 500)
				if (!$success) {
					return 409;
				}
			}
		} 
	}

	// Method takes a username and deletes that user from the database
	public function deleteJSONUser($username) 
	{
		$success = $this->queries->deleteUser($username);

		if (!$success) {
			return 404;
		} else {
			return null;
		}
	}

	// Method to take a JSON object and get the appropriate parameter values
	// for adding a log to the database
	public function addJSONLog($log)
	{
		$logArray = json_decode($log, true);
		$added_row = $this->queries->addLog($logArray);

		// If addLog returns false, there is an internal server error
		if (!$added_row) {
			return 409;
		} else {
			return $added_row;
		}
	}

	// Method to take a log number and two JSON objects (the old log object and the updated log object)
	// and use them to update the database to reflect changes
	public function updateJSONLog($logno, $oldlog, $newlog)
	{
		$oldLogArray = json_decode($oldlog, true);
		$newLogArray = json_decode($newlog, true);

		// Check to see if any modifications were made
		if ($newLogArray != $oldLogArray) {
			// Update the Log properties
			$added_row = $this->queries->updateLog($oldLogArray, $newLogArray);

			// If updateLog returns false, there is an internal server error
			if (!$added_row) {
				return 409;
			}
		} 
	}

	// Method takes a log number and deletes that log from the database
	public function deleteJSONLog($logno)
	{
		$success = $this->queries->deleteLog($logno);

		if (!$success) {
			return 404;
		} else {
			return null;
		}
	}

	// Method to take a group name and two JSON objects (the old group object and the updated group object)
	// and use them to update the database to reflect changes
	public function updateJSONGroup($groupname, $oldgroup, $newgroup)
	{
		$oldGroupArray = json_decode($oldgroup, true);
		$newGroupArray = json_decode($newgroup, true);

		// Check to see if any modifications were made
		if ($newUserArray != $oldUserArray) {
			// Update the Group properties
			$success = $this->queries->updateGroup($groupname, $newGroupArray);

			// If updateGroup returns false, there is an internal server error
			if (!$success) {
				return 409;
			}
		}
	}
}