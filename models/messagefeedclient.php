<?php

// Author: Andrew Jarombek
// Date: 2/18/2017
// The Message Feed Client that uses api_client to make and interpret calls to the api for messagefeed information

require_once('api_client.php');
require_once('model_utils.php');

class MessageFeedClient
{

	function __construct() {}

	// param is an array -> [paramtype, sortparam, limit, offset]
	public function get($param) 
	{
		$response = APIClient::messageFeedGetRequest($param);
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