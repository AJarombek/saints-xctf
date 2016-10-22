<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Controller for REST requests for running logs

class LogRestController implements RestController
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

	// Get either a specific log or all the logs
	public function get($instance = null) 
	{
		if (isset($instance)) {
			// Get a specific logs information
			return $this->tojson->logToJSON($instance);
		} else {
			// Get all logs information
			return $this->tojson->logsToJSON();
		}
	}

	// Add a log to the api
	public function post($data = null) 
	{
		// POST is not allowed on a specific log
		if (isset($data)) {
			// Add the log to the database and then perform a GET request to
			// return the JSON log representation
			$logno = $this->toquery->addJSONLog($data);
			return $this->get($logno);
		} else {
			return 400;
		}
	}

	// Update a specific log in the api
	public function put($instance = null, $data = null) 
	{
		if (isset($instance) && isset($data)) {

			$oldlog = $this->get($instance);
			$newlog = $data;

			$response = $this->toquery->updateJSONLog($instance, $oldlog, $newlog);

			// Return either the response error or the new user JSON object
			if ($response == 409) {
				return $response;
			} else {
				return $this->get($instance);
			}

		} else {
			return 400;
		}
	}

	// Delete a specific log in the api
	public function delete($instance = null) 
	{
		if (isset($instance)) {
			$response = $this->toquery->deleteJSONLog($instance);
			return $response;
		} else {
			return 405;
		}
	}
}