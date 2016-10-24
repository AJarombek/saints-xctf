<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// The Client that makes calls to the REST API Endpoints
// Help from: https://web.archive.org/web/20130921214725/http://www.gen-x-design.com/archives/making-restful-requests-in-php/

class APIClient
{
	// Instance Variables for the API Client

	// The URL we will be requesting against
	protected $url;
	// The type of request we will be making 
	protected $verb;
	// The request body to be sent with PUT and POST requests
	protected $requestBody;
	// An internally used variable for PUT requests
	protected $requestLength;
	protected $username;
	protected $password;
	// What kind of content we will accept as a response (JSON)
	protected $acceptType;
	// The body of our response
	protected $responseBody;
	// All the other info in the response
	protected $responseInfo;

	public function __construct($url = null, $verb = 'GET', $requestBody = null) 
	{
		$this->url = $url;
		$this->verb = $verb;
		$this->requestBody = $requestBody;
		$this->requestLength = 0;
		$this->password = null;
		$this->acceptType = 'application/json';
		$this->responseBody = null;
		$this->responseInfo = null;

		if ($this->requestBody !== null) {
			$this->buildPostBody();
		}
	}

	public function flush()
	{
		$this->requestBody = null;
		$this->requestLength = 0;
		$this->verb = 'GET';
		$this->responseBody = null;
		$this->responseInfo = null;
	}

	public function execute()
	{

	}

	public function buildPostBody($data = null)
	{

	}

	protected function executeGet($ch)
	{

	}

	protected function executePost($ch)
	{
		
	}

	protected function executePut($ch)
	{
		
	}

	protected function executeDelete($ch)
	{
		
	}

	protected function doExecute($curlHandle)
	{

	}

	protected function setCurlOpts($curlHandle)
	{

	}

	protected function setAuth($curlHandle)
	{

	}

}