<?php

// Author: Andrew Jarombek
// Date: 4/6/2017 - 6/2/2017
// The Activation Code Client that uses api_client to make and interpret calls to the api for activation code information
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

require_once('api_client.php');
require_once('model_utils.php');

class ActivationCodeClient
{

	function __construct() {}

	public function get($param) 
	{
		$response = APIClient::activationCodeGetRequest($param);
		return ModelUtils::getResponse($response);
	}

	public function getAll()
	{
		return null;
	}

	public function post($object)
	{
		$response = APIClient::activationCodePostRequest($object);
		return ModelUtils::getResponse($response);
	}

	public function put($id, $object)
	{
		return null;
	}

	public function delete($id)
	{
		$response = APIClient::activationCodeDeleteRequest($id);
		return ModelUtils::getResponse($response);
	}

}