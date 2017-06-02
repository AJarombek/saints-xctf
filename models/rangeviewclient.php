<?php

// Author: Andrew Jarombek
// Date: 3/14/2017 - 6/2/2017
// The Range View Client that uses api_client to make and interpret calls to the api for range view information
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

require_once('api_client.php');
require_once('model_utils.php');

class RangeViewClient
{

	function __construct() {}

	// param is an array -> [paramtype, sortparam, start, end]
	public function get($param) 
	{
		$response = APIClient::rangeViewGetRequest($param);
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