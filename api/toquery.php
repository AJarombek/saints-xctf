<?php

// Author: Andrew Jarombek
// Date: 10/20/2016 - 
// Convert JSON Objects from the REST API to Query parameters

require_once('queries.php');

class ToQuery
{
	private $queries;
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
		$this->queries = new Queries($db);
	}

	// Method to take a JSON object and get the appropriate parameter values
	// for adding a user to the database
	public function addJSONUser($user) 
	{
		$userArray = json_decode($user, true);
		$userObject = $userArray['users'][0];
		$username = $userObject['username'];
		$first = $userObject['first'];
		$last = $userObject['last'];
		$password = $userObject['password'];
		$salt = $userObject['salt'];
		$this->queries->addUser($username, $first, $last, $password, $salt);

		return $username;
	}

	// Method to take a username, and two JSON objects (the old user object and the updated user object)
	// and use them to update the database to reflect changes
	public function updateJSONUser($username, $olduser, $newuser) 
	{
		$oldUserArray = json_decode($olduser, true);
		$oldUserObject = $oldUserArray['users'][0];

		$newUserArray = json_decode($newuser, true);
		$newUserObject = $newUserArray['users'][0];

		// Check to see if any modifications were made
		if ($newUserObject != $oldUserObject) {
			// Update the User properties
			$success = $this->queries->updateUser($username, $newuser);

			// If updateUser returns false, there is an internal server error (HTTP Error 500)
			if (!$success) {
				return 409;
			}

			$oldGroups = $oldUserObject['groups'];
			$newGroups = $newUserObject['groups'];

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

		if (!success) {
			return 404;
		} else {
			return null;
		}
	}

	// Method to take a JSON object and get the appropriate parameter values
	// for adding a log to the database
	public function addJSONLog($logno)
	{

	}

	// Method to take a log number and two JSON objects (the old log object and the updated log object)
	// and use them to update the database to reflect changes
	public function updateJSONLog($logno, $oldlog, $newlog)
	{

	}

	// Method takes a log number and deletes that log from the database
	public function deleteJSONLog($logno)
	{

	}
}