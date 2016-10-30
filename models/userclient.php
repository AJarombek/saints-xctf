<?php

// Author: Andrew Jarombek
// Date: 10/24/2016 - 
// The User Client that uses api_client to make and interpret calls to the api for user information

require_once('api_client.php');
require_once('model_utils.php');

class UserClient
{

	function __construct() {}

	public function get($param) 
	{
		$response = APIClient::userGetRequest($param);
		return ModelUtils::getResponse($response);
	}

	public function getAll()
	{
		$response = APIClient::usersGetRequest();
		return ModelUtils::getResponse($response);
	}

	public function post($object)
	{
		$response = APIClient::usersPostRequest($object);
		return ModelUtils::getResponse($response);
	}

	public function put($id, $object)
	{
		$response = APIClient::userPutRequest($id, $object);
		return ModelUtils::getResponse($response);
	}

	public function delete($id)
	{
		$response = APIClient::userDeleteRequest($id);
		return ModelUtils::getResponse($response);
	}

}