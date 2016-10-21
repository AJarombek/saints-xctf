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

	public function updateJSONUser($username, $user) 
	{

	}

}