<?php

// Author: Andrew Jarombek
// Date: 10/20/2016 - 12/24/2016
// Controller for REST requests for group information
// Version 0.4 (BETA) - 12/24/2016

class GroupRestController implements RestController
{
	private $db;
	private $group;
	private $tojson;
	private $toquery;

	public function __construct($db, $group = null)
	{
		$this->db = $db;
		$this->group = $group;
		$this->tojson = new ToJSON($db);
		$this->toquery = new ToQuery($db);
	}

	// Get either a specific group or all the groups
	public function get($instance = null) 
	{
		if (isset($instance)) {
			// Get a specific groups information
			return $this->tojson->groupToJSON($instance);
		} else {
			// Get all groups information
			return $this->tojson->groupsToJSON();
		}
	}

	// You are not allowed to add a group to the API
	public function post($data = null) 
	{
		return null;
	}

	// Update a specific group in the api
	public function put($instance = null, $data = null) 
	{
		if (isset($instance) && isset($data)) {

			$oldgroup = $this->get($instance);
			$newgroup = $data;

			$response = $this->toquery->updateJSONGroup($instance, $oldgroup, $newgroup);

			// Return either the response error or the new group JSON object
			if ($response == 409) {
				return $response;
			} else {
				return $this->get($instance);
			}

		} else {
			return 400;
		}
	}

	// You are not allowed to delete a group in the api
	public function delete($instance = null) 
	{
		return null;
	}
}