<?php

// Author: Andrew Jarombek
// Date: 10/24/2016 - 12/24/2016
// Client for REST API interface
// Version 0.4 (BETA) - 12/24/2016

interface Client
{
	public function get($param);

	public function getAll();

	public function post($object);

	public function put($id, $object);

	public function delete($id);
}