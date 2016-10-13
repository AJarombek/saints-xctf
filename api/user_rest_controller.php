<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Controller for REST requests for user info

namespace Rest;
require_once('rest_controller.php');
require_once('to_json.php');

class UserRestController implements RestController
{
	private $user;
	private $queries;

	public function __construct($user = null)
	{
		$this->user = $user;
		$to_json = new ToJSON();
	}

	// Get either a specific user or all the users
	public function get($instance = null) 
	{
		if (isset($instance)) {
			// Get a specific users information
		} else {
			// Get all users information
		}
	}

	// Add a user to the api
	public function post($instance = null) 
	{
		
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