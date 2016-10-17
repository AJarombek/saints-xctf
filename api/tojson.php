<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Convert arrays from database queries to JSON objects for the API

class ToJSON
{

	// Function that returns the users in the database in JSON format
	public static function usersToJSON($queries) {
		$users = $queries->getUsers();
		$usersJSON = json_encode($users);
		return $usersJSON;
	}
}