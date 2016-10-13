<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Controller for REST requests for user info

namespace Rest;
require_once('rest_controller.php');

class UserRestController implements RestController
{
	private $user;

	public function __construct($user = null)
	{
		$this->user = $user;
	}

	public function get($instance = null) 
	{

	}

	public function post($instance = null) 
	{
		
	}

	public function put($instance = null) 
	{
		
	}

	public function delete($instance = null) 
	{
		
	}
}