<?php

// Author: Andrew Jarombek
// Date: 10/23/2016 - 
// The Client that makes calls to the REST API Endpoints
// Help from: https://web.archive.org/web/20130921214725/http://www.gen-x-design.com/archives/making-restful-requests-in-php/

class APIClientRequest
{
	const LOG_TAG = "[WEB](api_request.php): ";
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
	protected $curlHandle;

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

		$this->curlHandle = null;
	}

	// Allows us to use the same object to make multiple requests by clearing out
	// Instance variables
	public function flush()
	{
		$this->requestBody = null;
		$this->requestLength = 0;
		$this->verb = 'GET';
		$this->responseBody = null;
		$this->responseInfo = null;
	}

	// Choose how to execute a request based on the selected verb
	public function execute()
	{
		$this->curlHandle = curl_init();
		//$this->setAuth();

		try {
			switch (strtoupper($this->verb)) {
				case 'GET':
					$this->executeGet();
					break;
				case 'POST':
					$this->executePost();
					break;
				case 'PUT':
					$this->executePut();
					break;
				case 'DELETE':
					$this->executeDelete();
					break;
				default:
					throw new InvalidArgumentException('Current verb (' . 
						$this->verb . ') is an invalid REST verb.');
					
			}
			
		} catch (InvalidArgumentException $e) {
			curl_close($this->curlHandle);
			throw $e;
			
		} catch (Exception $e) {
			curl_close($this->curlHandle);
			throw $e;
		}
	}

	// Takes an array and prepares it for being POSTed or PUT
	public function buildPostBody($data = null)
	{
		$data = ($data !== null) ? $data : $this->requestBody;

		if (!is_array($data)) {
			throw new InvalidArgumentException("Invalid data input for postBody.  Array expected.");
		}

		$data = http_build_query($data, '', '&');
		$this->requestBody = $data;
	}

	// Execute a HTTP GET request
	protected function executeGet()
	{
		$this->doExecute();
	}

	// Execute a HTTP POST request
	protected function executePost()
	{
		if (!is_string($this->requestBody)) {
			//$this->buildPostBody();
		}

		curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $this->requestBody);
		curl_setopt($this->curlHandle, CURLOPT_POST, 1);

		$this->doExecute();
	}

	// Execute a HTTP PUT request
	protected function executePut()
	{
		if (!is_string($this->requestBody)) {
			//$this->buildPostBody();
		}

		curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $this->requestBody);

		$this->doExecute();
	}

	// Execute a HTTP DELETE request
	protected function executeDelete()
	{
		curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE');
		$this->doExecute();
	}

	// Execute the request
	protected function doExecute()
	{
		error_log(self::LOG_TAG . "Request Body: " . $this->requestBody);

		$this->setCurlOpts();
		$this->responseBody = curl_exec($this->curlHandle);
		$this->responseInfo = curl_getinfo($this->curlHandle);

		curl_close($this->curlHandle);
	}

	// Set all the Curl options common to all our requests
	protected function setCurlOpts()
	{
		curl_setopt($this->curlHandle, CURLOPT_TIMEOUT, 10);
		curl_setopt($this->curlHandle, CURLOPT_URL, $this->url);
		curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, array('Accept: ' . $this->password));
	}

	// If the API requires authentication, use this class
	protected function setAuth()
	{
		if ($this->username !== null && $this->password !== null) {
			curl_setopt($this->curlHandle, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
			curl_setopt($this->curlHandle, CURLOPT_USERPWD, $this->username . ':' . $this->password);
		}
	}

	public function getAcceptType()
	{
		return $this->acceptType;
	} 
	
	public function setAcceptType($acceptType)
	{
		$this->acceptType = $acceptType;
	} 
	
	public function getPassword()
	{
		return $this->password;
	} 
	
	public function setPassword($password)
	{
		$this->password = $password;
	} 
	
	public function getResponseBody()
	{
		return $this->responseBody;
	} 
	
	public function getResponseInfo()
	{
		return $this->responseInfo;
	} 
	
	public function getUrl()
	{
		return $this->url;
	} 
	
	public function setUrl($url)
	{
		$this->url = $url;
	} 
	
	public function getUsername()
	{
		return $this->username;
	} 
	
	public function setUsername($username)
	{
		$this->username = $username;
	} 
	
	public function getVerb()
	{
		return $this->verb;
	} 
	
	public function setVerb($verb)
	{
		$this->verb = $verb;
	}

}