<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 12/24/2016
// REST Controller interface
// Version 0.4 (BETA) - 12/24/2016

interface RestController
{
	// Function for an HTTP GET request
	public function get($instance = null);

	// Function for an HTTP POST request
	public function post($data = null);

	// Function for an HTTP PUT request
	public function put($instance = null, $data = null);

	// Function for an HTTP DELETE request
	public function delete($instance = null);
}