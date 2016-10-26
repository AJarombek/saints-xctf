<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Controller for REST requests for running logs

class LogFeedRestController implements RestController
{
	private $db;
	private $log;
	private $tojson;
	private $toquery;

	public function __construct($db, $log = null)
	{
		$this->db = $db;
		$this->log = $log;
		$this->tojson = new ToJSON($db);
		$this->toquery = new ToQuery($db);
	}

	// Get either a feed of logs
	public function get($instance = null) 
	{

		if (isset($instance)) {
			// Get the individual argument parameters
			$paramtype = $instance['paramtype'];
			$sortparam = $instance['sortparam'];
			$limit = $instance['limit'];
			$offset = $instance['offset'];

			// Get a feed of workout logs
			return $this->tojson->logFeedToJSON($paramtype, $sortparam, $limit, $offset);
		} else {
			return null;
		}
	}

	// Adding a feed of logs is not allowed
	public function post($data = null) 
	{
		return null;
	}

	// Modifying a feed of logs is not allowed
	public function put($instance = null, $data = null) 
	{
		return null;
	}

	// Deleting a feed of logs is not allowed
	public function delete($instance = null) 
	{
		return null;
	}
}