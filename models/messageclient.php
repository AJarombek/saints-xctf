<?php

// Author: Andrew Jarombek
// Date: 2/18/2017
// The Message Client that uses api_client to make and interpret calls to the api for message information

require_once('api_client.php');
require_once('model_utils.php');

class MessageClient
{

	function __construct() {}

	public function get($param) 
	{
		$response = APIClient::messageGetRequest($param);
		return ModelUtils::getResponse($response);
	}

	public function getAll()
	{
		$response = APIClient::messagesGetRequest();
		return ModelUtils::getResponse($response);
	}

	public function post($object)
	{
		$response = APIClient::messagePostRequest($object);
		return ModelUtils::getResponse($response);
	}

	public function put($id, $object)
	{
		$response = APIClient::messagePutRequest($id, $object);
		return ModelUtils::getResponse($response);
	}

	public function delete($id)
	{
		$response = APIClient::messageDeleteRequest($id);
		return ModelUtils::getResponse($response);
	}

}