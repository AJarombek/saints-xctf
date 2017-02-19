<?php

// Author: Andrew Jarombek
// Date: 10/20/2016 - 1/18/2017
// Convert JSON Objects from the REST API to Query parameters
// Version 0.4 (BETA) - 12/24/2016
// Version 0.5 (FEEDBACK UPDATE) - 1/18/2017

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

		$username = $user['username'];
		$first = $user['first'];
		$last = $user['last'];
		$email = $user['email'];
		$password = $user['password'];
		$activation_code = $user['activation_code'];

		error_log(self::LOG_TAG . "The Username to be Added: " . $username);
		$success = $this->queries->addUser($username, $first, $last, $email, $password, $activation_code);

		// If addUser returns false, there is an internal server error
		if (!$success) {
			return 409;
		} else {
			// Remove this activation code from the available code listing
			$this->queries->removeCode($activation_code);
			return $username;
		}
	}

	// Method to take a username, and two JSON objects (the old user object and the updated user object)
	// and use them to update the database to reflect changes
	public function updateJSONUser($username, $olduser, $newuser) 
	{
		$olduser = json_decode($olduser, true);

		error_log(self::LOG_TAG . "The Old User JSON object received: " . print_r($olduser, true));
		error_log(self::LOG_TAG . "The New User JSON object received: " . print_r($newuser, true));

		// Check to see if any modifications were made
		if ($newuser != $olduser) {

			// Check first if the only thing that should be updated is the fpw_code.
			if (isset($newuser['fpw_code'])) {

				// Update the Forgot Password Code
				$success = $this->queries->addForgotPassword($username, $newuser['fpw_code']);

				// If addForgotCode returns false, there is an internal server error
				if (!$success) {
					error_log(self::LOG_TAG . "Add Forgot Password FAILED!");
					return 409;
				}

			} else if (isset($newuser['fpw_delete_code']) && isset($newuser['fpw_password'])) {

				// Update the Users Password and Delete the Forgot Code
				$changePassword = $this->queries->updatePassword($username, $newuser['fpw_password']);
				$deleteCode = $this->queries->deleteForgotPassword($newuser['fpw_delete_code']);

				// If either database call returns false, there is an internal server error
				if (!$deleteCode || !$changePassword) {
					error_log(self::LOG_TAG . "Change Password FAILED!");
					return 409;
				}

			} else {

				// Update the User properties
				$success = $this->queries->updateUser($username, $newuser);

				// If updateUser returns false, there is an internal server error
				if (!$success) {
					error_log(self::LOG_TAG . "Update User Info FAILED!");
					return 409;
				}

				$oldGroups = $olduser['groups'];
				$newGroups = $newuser['groups'];

				// Check to see if the teams have been altered
				if ($oldGroups != $newGroups) {
					// Update the users team membership
					$success = $this->queries->updateTeams($username, $oldGroups, $newGroups);

					// If updateTeams returns false, there is an internal server error (HTTP Error 500)
					if (!$success) {
						error_log(self::LOG_TAG . "Update User Groups FAILED!");
						return 409;
					}
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
		error_log(self::LOG_TAG . "The JSON object received: " . print_r($log, true));

		$added_row = $this->queries->addLog($log);

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
		$oldlog = json_decode($oldlog, true);

		error_log(self::LOG_TAG . "The Old Log JSON object received: " . print_r($oldlog, true));
		error_log(self::LOG_TAG . "The New Log JSON object received: " . print_r($newlog, true));

		// Check to see if any modifications were made
		if ($newlog != $oldlog) {
			// Update the Log properties
			$added_row = $this->queries->updateLog($oldlog, $newlog);

			// If updateLog returns false, there is an internal server error
			if (!$added_row) {
				return 409;
			}
		} 
	}

	// Method takes a log number and deletes that log from the database
	public function deleteJSONLog($logno)
	{
		// First delete all comments on this log (avoid foreign key constraint)
		$deletecomments = $this->queries->deleteLogComments($logno);

		// Then delete the log
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
		$oldgroup = json_decode($oldgroup, true);

		error_log(self::LOG_TAG . "The Old Group JSON object received: " . print_r($oldgroup, true));
		error_log(self::LOG_TAG . "The New Group JSON object received: " . print_r($newgroup, true));

		// Check to see if any modifications were made
		if ($newgroup != $oldgroup) {
			// Update the Group properties
			$success = $this->queries->updateGroup($groupname, $newgroup);

			// If updateGroup returns false, there is an internal server error
			if (!$success) {
				return 409;
			}
		}
	}

	// Method to take a JSON object and get the appropriate parameter values
	// for adding a comment to the database
	public function addJSONComment($comment)
	{
		error_log(self::LOG_TAG . "The JSON object received: " . print_r($comment, true));

		$added_row = $this->queries->addComment($comment);

		// If addComment returns false, there is an internal server error
		if (!$added_row) {
			return 409;
		} else {
			return $added_row;
		}
	}

	// Method to take a comment id and two JSON objects (the old comment object and the updated comment object)
	// and use them to update the database to reflect changes
	public function updateJSONComment($commentid, $oldcomment, $newcomment)
	{
		$oldcomment = json_decode($oldcomment, true);

		error_log(self::LOG_TAG . "The Old Comment JSON object received: " . print_r($oldcomment, true));
		error_log(self::LOG_TAG . "The New Comment JSON object received: " . print_r($newcomment, true));

		// Check to see if any modifications were made
		if ($newcomment != $oldcomment) {
			// Update the Comment properties
			$added_row = $this->queries->updateComment($oldcomment, $newcomment);

			// If updateComment returns false, there is an internal server error
			if (!$added_row) {
				return 409;
			}
		} 
	}

	// Method takes a comment id and deletes that comment from the database
	public function deleteJSONComment($commentid)
	{
		$success = $this->queries->deleteComment($commentid);

		if (!$success) {
			return 404;
		} else {
			return null;
		}
	}

	// Method to take a JSON object and get the appropriate parameter values
	// for adding a message to the database
	public function addJSONMessage($message)
	{
		error_log(self::LOG_TAG . "The JSON object received: " . print_r($message, true));

		$added_row = $this->queries->addMessage($message);

		// If addMessage returns false, there is an internal server error
		if (!$added_row) {
			return 409;
		} else {
			return $added_row;
		}
	}

	// Method to take a log number and two JSON objects (the old log object and the updated log object)
	// and use them to update the database to reflect changes
	public function updateJSONMessage($messageno, $oldmessage, $newmessage)
	{
		$oldmessage = json_decode($oldmessage, true);

		error_log(self::LOG_TAG . "The Old Message JSON object received: " . print_r($oldmessage, true));
		error_log(self::LOG_TAG . "The New Message JSON object received: " . print_r($newmessage, true));

		// Check to see if any modifications were made
		if ($newmessage != $oldmessage) {
			// Update the Message properties
			$added_row = $this->queries->updateMessage($oldmessage, $newmessage);

			// If updateMessage returns false, there is an internal server error
			if (!$added_row) {
				return 409;
			}
		} 
	}

	// Method takes a message number and deletes that message from the database
	public function deleteJSONLog($messageno)
	{
		$success = $this->queries->deleteMessage($messageno);

		if (!$success) {
			return 404;
		} else {
			return null;
		}
	}
}