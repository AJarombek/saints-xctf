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
		$usersJSON = json_encode($users);
		return $usersJSON;
	}
}