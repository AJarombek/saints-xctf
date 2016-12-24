<?php

// Author: Andrew Jarombek
// Date: 10/24/2016 - 12/24/2016
// The Group Client that uses api_client to make and interpret calls to the api for group information
// Version 0.4 (BETA) - 12/24/2016

require_once('api_client.php');
require_once('model_utils.php');

class GroupClient
{

	function __construct() {}

	public function get($param) 
	{
		$response = APIClient::groupGetRequest($param);
		return ModelUtils::getResponse($response);
	}

	public function getAll()
	{
		$response = APIClient::groupsGetRequest();
		return ModelUtils::getResponse($response);
	}

	public function post($object)
	{
		return null;
	}

	public function put($id, $object)
	{
		$response = APIClient::groupPutRequest($id, $object);
		return ModelUtils::getResponse($response);
	}

	public function delete($id)
	{
		return null;
	}

}