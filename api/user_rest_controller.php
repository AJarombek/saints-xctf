<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Controller for REST requests for user info

require_once('rest_controller.php');
require_once('tojson.php');
require_once('toquery.php');

class UserRestController implements RestController
{
	private $db;
	private $user;
	private $tojson;
	private $toquery;

	public function __construct($db, $user = null)
	{
		$this->db = $db;
		$this->user = $user;
		$this->tojson = new ToJSON($db);
		$this->toquery = new ToQuery($db);
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
	public function post($data = null) 
	{
		// POST is not allowed on a specific user
		if (isset($data)) {
			$username = $this->toquery->addJSONUser($data);
			return $this->get($username);
		} else {
			return null;
		}
	}

	// Update a specific user in the api
	public function put($instance = null, $data = null) 
	{
		
	}

	// Delete a specific user in the api
	public function delete($instance = null) 
	{
		
	}
}