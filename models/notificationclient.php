<?php

// Author: Andrew Jarombek
// Date: 6/15/2017
// The Notification Client that uses api_client to make and interpret calls to the api for user information

require_once('api_client.php');
require_once('model_utils.php');

class NotificationClient
{

	function __construct() {}

	public function get($param) 
	{
		return null;
	}

	public function getAll()
	{
		$response = APIClient::notificationsGetRequest();
		return ModelUtils::getResponse($response);
	}

	public function post($object)
	{
		$response = APIClient::notificationPostRequest($object);
		return ModelUtils::getResponse($response);
	}

	public function put($id, $object)
	{
		return null;
	}

	public function delete($id)
	{
		$response = APIClient::notificationDeleteRequest($id);
		return ModelUtils::getResponse($response);
	}

}