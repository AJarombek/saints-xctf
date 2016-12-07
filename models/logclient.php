<?php

// Author: Andrew Jarombek
// Date: 10/24/2016 - 
// The Log Client that uses api_client to make and interpret calls to the api for log information

require_once('api_client.php');
require_once('model_utils.php');

class LogClient
{

	function __construct() {}

	public function get($param) 
	{
		$response = APIClient::logGetRequest($param);
		return ModelUtils::getResponse($response);
	}

	public function getAll()
	{
		$response = APIClient::logsGetRequest();
		return ModelUtils::getResponse($response);
	}

	public function post($object)
	{
		$response = APIClient::logPostRequest($object);
		return ModelUtils::getResponse($response);
	}

	public function put($id, $object)
	{
		$response = APIClient::logPutRequest($id, $object);
		return ModelUtils::getResponse($response);
	}

	public function delete($id)
	{
		$response = APIClient::logDeleteRequest($id);
		return ModelUtils::getResponse($response);
	}

}