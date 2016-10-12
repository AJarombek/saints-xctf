<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// REST Controller interface

namespace Rest;

interface RestController() 
{
	// Function for an HTTP GET request
	public function get();

	// Function for an HTTP POST request
	public function post();

	// Function for an HTTP PUT request
	public function put();

	// Function for an HTTP DELETE request
	public function delete();
}