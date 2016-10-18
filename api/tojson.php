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
		$usersJSON = json_encode($users, JSON_FORCE_OBJECT);
		$usersJSON = "\"users\": {\n" . $usersJSON . "\n}";
		return $this->prettyPrintJSON($usersJSON);
	}

	// Function that returns a specific user in the database in JSON format
	public function userToJSON($user)
	{
		$user_info = $this->queries->getUserDetails($user);
		$userJSON = json_encode($user_info);
		return $userJSON;
	}

	// Helper function to print out JSON in an indented format
	// http://stackoverflow.com/questions/6054033/pretty-printing-json-with-php
	private function prettyPrintJSON($JSON)
	{
		$result = '';
		$level = 0;
		$in_quotes = false;
		$in_escape = false;
		$ends_line_level = NULL;
		$json_length = strlen($JSON);

		// Go through the string one character at a time
		for ($i = 0; $i < $json_length; $i++) {
			$char = $JSON[$i];
			$new_line_level = NULL;
			$post = "";
			if ($ends_line_level !== NULL) {
				$new_line_level = $ends_line_level;
				$ends_line_level = NULL;
			}
			if ($in_escape) {
				$in_escape = false;
			} else if ($char === '"') {
				$in_quotes = !$in_quotes;
			} else if (!$in_quotes) {
				switch ($char) {
					case '}': case ']':
						$level--;
						$ends_line_level = NULL;
						$new_line_level = $level;
						break;

					case '{': case '[':
						$level++;

					case ',':
						$ends_line_level = $level;
						break;

					case ':':
						$post = " ";
						break;

					case " ": case "\t": case "\n": case "\r":
						$char = "";
						$ends_line_level = $new_line_level;
						$new_line_level = NULL;
						break;
				}
			} else if ($char === '\\') {
				$in_escape = true;
			}
			if ($new_line_level !== NULL) {
				$result .= "\n".str_repeat("\t", $new_line_level);
			} 
			$result .= $char.$post;
		}
		return $result;
	}
}