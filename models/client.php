<?php

// Author: Andrew Jarombek
// Date: 10/24/2016 - 
// Client for REST API interface

interface Client
{
	public function get($id);

	public function getAll();

	public function post($object);

	public function put($id, $object);

	public function delete($id);
}