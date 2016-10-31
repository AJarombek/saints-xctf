<?php

// Author: Andrew Jarombek
// Date: 10/24/2016 - 
// The Client that creates calls for the REST API

require_once('api_request.php');

class APIClient
{
	const LOG_TAG = "[WEB](api_client.php): ";

	/*
	 *	API GET Requests
	 */

	public static function usersGetRequest()
	{
		$request = new APIClientRequest('localhost/saints-xctf/api/api.php/users', 'GET');
		$request->execute();
		return $request;
	}

	public static function userGetRequest($username)
	{
		$uri = 'localhost/saints-xctf/api/api.php/users/' . $username;
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function logsGetRequest()
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/logs', 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function logGetRequest($log_id)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/logs/' . $log_id;
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function groupsGetRequest()
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/groups', 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function groupGetRequest($groupname)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/groups/' . $groupname;
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function logFeedGetRequest($params)
	{
		$paramtype = $params['paramtype'];
		$sortparam = $params['sortparam'];
		$limit = $params['limit'];
		$offset = $params['offset'];

		$uri = 'http://localhost/saints-xctf/api/api.php/groups/' . 
				$paramtype . '/' . $sortparam . '/' . $limit . '/' . $offset ;
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	/*
	 *	API POST Requests
	 */

	public static function userPostRequest($newuser)
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/users', 'POST', $newuser);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function logPostRequest($newlog)
	{
		$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/logs', 'POST', $newlog);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	/*
	 *	API PUT Requests
	 */

	public static function userPutRequest($username, $newuser)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/users/' . $username;
		$request = new APIClientRequest($uri, 'PUT', $newuser);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function logPutRequest($log_id, $newlog)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/logs/' . $log_id;
		$request = new APIClientRequest($uri, 'PUT', $newlog);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function groupPutRequest($groupname, $newgroup)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/groups/' . $groupname;
		$request = new APIClientRequest($uri, 'PUT', $newgroup);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	/*
	 *	API DELETE Requests
	 */

	public static function userDeleteRequest($username)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/users/' . $username;
		$request = new APIClientRequest($uri, 'DELETE');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function logDeleteRequest($log_id)
	{
		$uri = 'http://localhost/saints-xctf/api/api.php/logs/' . $log_id;
		$request = new APIClientRequest($uri, 'DELETE');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}
}