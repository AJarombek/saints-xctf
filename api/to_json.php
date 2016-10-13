<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Convert arrays from database queries to JSON objects for the API

namespace Rest;
require_once('queries.php');

class ToJSON
{
	private $queries;
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
		$queries = new Queries($db);
	}

	public function usersToJSON() {
		$users = $queries->getUsers();
		$usersJSON = json_encode($users);
		return $usersJSON;
	}
}