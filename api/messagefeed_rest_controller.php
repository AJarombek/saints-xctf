<?php

// Author: Andrew Jarombek
// Date: 2/18/2017 - 2/20/2017
// Controller for REST requests for running messages
// Version 0.6 (GROUPS UPDATE) - 2/20/2017

class MessageFeedRestController implements RestController
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

	// Get either a feed of messages
	public function get($instance = null) 
	{

		if (isset($instance)) {
			// Get the individual argument parameters
			$paramtype = $instance['paramtype'];
			$sortparam = $instance['sortparam'];
			$limit = $instance['limit'];
			$offset = $instance['offset'];

			// Get a feed of workout logs
			return $this->tojson->messageFeedToJSON($paramtype, $sortparam, $limit, $offset);
		} else {
			return null;
		}
	}

	// Adding a feed of messages is not allowed
	public function post($data = null) 
	{
		return null;
	}

	// Modifying a feed of messages is not allowed
	public function put($instance = null, $data = null) 
	{
		return null;
	}

	// Deleting a feed of messages is not allowed
	public function delete($instance = null) 
	{
		return null;
	}
}