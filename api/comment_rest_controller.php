<?php

// Author: Andrew Jarombek
// Date: 12/10/2016 - 12/24/2016
// Controller for REST requests for running logs
// Version 0.4 (BETA) - 12/24/2016

class CommentRestController implements RestController
{
	private $db;
	private $comment;
	private $tojson;
	private $toquery;

	public function __construct($db, $comment = null)
	{
		$this->db = $db;
		$this->comment = $comment;
		$this->tojson = new ToJSON($db);
		$this->toquery = new ToQuery($db);
	}

	// Get either a specific comment or all the comments
	public function get($instance = null) 
	{
		if (isset($instance)) {
			// Get a specific comments information
			return $this->tojson->commentToJSON($instance);
		} else {
			// Get all comments information
			return $this->tojson->commentsToJSON();
		}
	}

	// Add a comment to the api
	public function post($data = null) 
	{
		// POST is not allowed on a specific comment
		if (isset($data)) {
			// Add the comment to the database and then perform a GET request to
			// return the JSON comment representation
			$commentno = $this->toquery->addJSONComment($data);
			return $this->get($commentno);
		} else {
			return 400;
		}
	}

	// Update a specific comment in the api
	public function put($instance = null, $data = null) 
	{
		if (isset($instance) && isset($data)) {

			$oldcomment = $this->get($instance);
			$newcomment = $data;

			$response = $this->toquery->updateJSONComment($instance, $oldcomment, $newcomment);

			// Return either the response error or the new comment JSON object
			if ($response == 409) {
				return $response;
			} else {
				return $this->get($instance);
			}

		} else {
			return 400;
		}
	}

	// Delete a specific comment in the api
	public function delete($instance = null) 
	{
		if (isset($instance)) {
			$response = $this->toquery->deleteJSONComment($instance);
			return $response;
		} else {
			return 405;
		}
	}
}