<?php

// Author: Andrew Jarombek
// Date: 4/6/2017
// Controller for REST requests for activation code info

require_once('rest_controller.php');
require_once('tojson.php');
require_once('toquery.php');
require_once('api_utils.php');

class ActivationCodeRestController implements RestController
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

	// Get a specific activation code
	public function get($instance = null) 
	{
		if (isset($instance)) {
			return $this->tojson->activationCodeToJSON($instance);
		} else {
			return 409;
		}
	}

	// Add an activation code to the api
	public function post($data = null) 
	{
		// POST is not allowed on a specific activation code
		if (!isset($data)) {
			$data = APIUtils::createCode();
			// Add the activation code to the database and then perform a GET request to
			// return the JSON activation code representation
			$result = $this->toquery->addJSONActivationCode($data);
			return $this->get($result);
		} else {
			return 400;
		}
	}

	// You are not allowed to update an activation code
	public function put($instance = null, $data = null) 
	{
		return null;
	}

	// Delete a specific activation code in the api
	public function delete($instance = null) 
	{
		if (isset($instance)) {
			$response = $this->toquery->deleteJSONActivationCode($instance);
			return $response;
		} else {
			return 405;
		}
	}
}