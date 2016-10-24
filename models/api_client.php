<?php

// Author: Andrew Jarombek
// Date: 10/24/2016 - 
// The Client that creates calls for the REST API

require_once('api_request.php');

class APIClient
{

	/*
	 *	API GET Requests
	 */

	public static function usersGetRequest()
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/users', 'GET');
		return $request->execute();
	}

	public static function userGetRequest($username)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/users/' . $username;
		$request = new APIClientRequest($uri, 'GET');
		return $request->execute();
	}

	public static function logsGetRequest()
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/logs', 'GET');
		return $request->execute();
	}

	public static function logGetRequest($log_id)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/logs/' . $log_id;
		$request = new APIClientRequest($uri, 'GET');
		return $request->execute();
	}

	public static function groupsGetRequest()
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/groups', 'GET');
		return $request->execute();
	}

	public static function groupGetRequest($groupname)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/groups/' . $groupname;
		$request = new APIClientRequest($uri, 'GET');
		return $request->execute();
	}

	/*
	 *	API POST Requests
	 */

	public static function usersPostRequest($newuser)
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/users', 'POST', $newuser);
		return $request->execute();
	}

	public static function logsPostRequest($newlog)
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/logs', 'POST', $newlog);
		return $request->execute();
	}

	/*
	 *	API PUT Requests
	 */

	public static function userPutRequest($username, $newuser)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/users/' . $username;
		$request = new APIClientRequest($uri, 'PUT', $newuser);
		return $request->execute();
	}

	public static function logPutRequest($log_id, $newlog)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/logs/' . $log_id;
		$request = new APIClientRequest($uri, 'PUT', $newlog);
		return $request->execute();
	}

	public static function groupPutRequest($groupname, $newgroup)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/groups/' . $groupname;
		$request = new APIClientRequest($uri, 'PUT', $newgroup);
		return $request->execute();
	}

	/*
	 *	API DELETE Requests
	 */

	public static function userDeleteRequest($username)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/users/' . $username;
		$request = new APIClientRequest($uri, 'DELETE');
		return $request->execute();
	}

	public static function logDeleteRequest($log_id)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/logs/' . $log_id;
		$request = new APIClientRequest($uri, 'DELETE');
		return $request->execute();
	}
}