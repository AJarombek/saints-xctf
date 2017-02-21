<?php

// Author: Andrew Jarombek
// Date: 2/18/2017 - 2/20/2017
// Controller for REST requests for messages
// Version 0.6 (GROUPS UPDATE) - 2/20/2017

class MessageRestController implements RestController
{
	private $db;
	private $message;
	private $tojson;
	private $toquery;

	public function __construct($db, $message = null)
	{
		$this->db = $db;
		$this->message = $message;
		$this->tojson = new ToJSON($db);
		$this->toquery = new ToQuery($db);
	}

	// Get either a specific message or all the messages
	public function get($instance = null) 
	{
		if (isset($instance)) {
			// Get a specific messages information
			return $this->tojson->messageToJSON($instance);
		} else {
			// Get all messages information
			return $this->tojson->messagesToJSON();
		}
	}

	// Add a message to the api
	public function post($data = null) 
	{
		// POST is not allowed on a specific message
		if (isset($data)) {
			// Add the message to the database and then perform a GET request to
			// return the JSON message representation
			$messageno = $this->toquery->addJSONMessage($data);
			return $this->get($messageno);
		} else {
			return 400;
		}
	}

	// Update a specific message in the api
	public function put($instance = null, $data = null) 
	{
		if (isset($instance) && isset($data)) {

			$oldmessage = $this->get($instance);
			$newmessage = $data;

			$response = $this->toquery->updateJSONMessage($instance, $oldlog, $newlog);

			// Return either the response error or the new message JSON object
			if ($response == 409) {
				return $response;
			} else {
				return $this->get($instance);
			}

		} else {
			return 400;
		}
	}

	// Delete a specific message in the api
	public function delete($instance = null) 
	{
		if (isset($instance)) {
			$response = $this->toquery->deleteJSONMessage($instance);
			return $response;
		} else {
			return 405;
		}
	}
}