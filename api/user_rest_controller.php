<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Controller for REST requests for user info

require_once('queries.php');
require_once('tojson.php');

class UserRestController implements RestController
{
	private $db;
	private $user;
	//private $queries;

	public function __construct($db, $user = null)
	{
		$this->db = $db;
		$this->user = $user;
		//$this->queries = new Queries($db);
	}

	// Get either a specific user or all the users
	public function get($instance = null) 
	{
		$queries = new Queries($db);
		if (isset($instance)) {
			// Get a specific users information
		} else {
			// Get all users information
			return ToJSON::usersToJSON($queries);
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