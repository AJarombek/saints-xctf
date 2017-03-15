<?php

// Author: Andrew Jarombek
// Date: 3/14/2017
// Controller for REST requests for a range view

class RangeViewRestController implements RestController
{
	private $db;
	private $log;
	private $tojson;

	public function __construct($db, $log = null)
	{
		$this->db = $db;
		$this->log = $log;
		$this->tojson = new ToJSON($db);
	}

	// Get a range view
	public function get($instance = null) 
	{

		if (isset($instance)) {
			// Get the individual argument parameters
			$paramtype = $instance['paramtype'];
			$sortparam = $instance['sortparam'];
			$start = $instance['start'];
			$end = $instance['end'];

			// Get a range view
			return $this->tojson->rangeViewToJSON($paramtype, $sortparam, $start, $end);
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