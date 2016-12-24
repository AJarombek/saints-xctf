<?php

// Author: Andrew Jarombek
// Date: 10/30/2016 - 12/24/2016
// The Log Client that uses api_client to make and interpret calls to the api for logfeed information
// Version 0.4 (BETA) - 12/24/2016

require_once('api_client.php');
require_once('model_utils.php');

class LogFeedClient
{

	function __construct() {}

	// param is an array -> [paramtype, sortparam, limit, offset]
	public function get($param) 
	{
		$response = APIClient::logFeedGetRequest($param);
		return ModelUtils::getResponse($response);
	}

	public function getAll()
	{
		return null;
	}

	public function post($object)
	{
		return null;
	}

	public function put($id, $object)
	{
		return null;
	}

	public function delete($id)
	{
		return null;
	}

}