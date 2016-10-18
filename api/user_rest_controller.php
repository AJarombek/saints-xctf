<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Controller for REST requests for user info

require_once('rest_controller.php');
require_once('tojson.php');

class UserRestController implements RestController
{
	private $db;
	private $user;
	private $tojson;

	public function __construct($db, $user = null)
	{
		$this->db = $db;
		$this->user = $user;
		$this->tojson = new ToJSON($db);
	}

	// Get either a specific user or all the users
	public function get($instance = null) 
	{
		if (isset($instance)) {
			// Get a specific users information
			return $this->tojson->userToJSON($instance);
		} else {
			// Get all users information
			return $this->tojson->usersToJSON();
		}
	}

	// Add a user to the api
	public function post($instance = null) 
	{
		// POST is not allowed on a specific user
		if (isset($instance)) {
			return null;
		} else {

		}
	}

	// Update a specific user in the api
	public function put($instance = null) 
	{
		
	}

	// Delete a specific user in the api
	public function delete($instance = null) 
	{
		
	}
}