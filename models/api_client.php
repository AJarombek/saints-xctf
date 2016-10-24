<?php

// Author: Andrew Jarombek
// Date: 10/24/2016 - 
// The Client that creates calls for the REST API

require_once('api_request.php');

class APIClient
{

	function __construct()
	{

	}

	/*
	 *	API GET Requests
	 */

	public function usersGetRequest()
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/users', 'GET');
		$request->execute();
	}

	public function userGetRequest($username)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/users/' . $username;
		$request = new APIClientRequest($uri, 'GET');
		$request->execute();
	}

	public function logsGetRequest()
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/logs', 'GET');
		$request->execute();
	}

	public function logGetRequest($log_id)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/logs/' . $log_id;
		$request = new APIClientRequest($uri, 'GET');
		$request->execute();
	}

	public function groupsGetRequest()
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/groups', 'GET');
		$request->execute();
	}

	public function groupGetRequest($groupname)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/groups/' . $groupname;
		$request = new APIClientRequest($uri, 'GET');
		$request->execute();
	}

	/*
	 *	API POST Requests
	 */

	public function usersPostRequest($newuser)
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/users', 'POST');
		$request->execute();
	}

	public function logsPostRequest($newlog)
	{

	}

	/*
	 *	API PUT Requests
	 */

	public function userPutRequest($username, $newuser)
	{

	}

	public function logPutRequest($log_id, $newlog)
	{

	}

	public function groupPutRequest($groupname, $newgroup)
	{

	}

	/*
	 *	API DELETE Requests
	 */

	public function userDeleteRequest($username)
	{

	}

	public function logDeleteRequest($log_id)
	{

	}
}