<?php

// Author: Andrew Jarombek
// Date: 12/10/2016 - 12/24/2016
// The Comment Client that uses api_client to make and interpret calls to the api for comment information
// Version 0.4 (BETA) - 12/24/2016

require_once('api_client.php');
require_once('model_utils.php');

class CommentClient
{

	function __construct() {}

	public function get($param) 
	{
		$response = APIClient::commentGetRequest($param);
		return ModelUtils::getResponse($response);
	}

	public function getAll()
	{
		$response = APIClient::commentsGetRequest();
		return ModelUtils::getResponse($response);
	}

	public function post($object)
	{
		$response = APIClient::commentPostRequest($object);
		return ModelUtils::getResponse($response);
	}

	public function put($id, $object)
	{
		$response = APIClient::commentPutRequest($id, $object);
		return ModelUtils::getResponse($response);
	}

	public function delete($id)
	{
		$response = APIClient::commentDeleteRequest($id);
		return ModelUtils::getResponse($response);
	}

}