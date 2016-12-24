<?php

// Author: Andrew Jarombek
// Date: 10/24/2016 - 12/24/2016
// The Client that creates calls for the REST API
// Version 0.4 (BETA) - 12/24/2016

require_once('api_request.php');

class APIClient
{
	const LOG_TAG = "[WEB](api_client.php): ";

	// When DEBUG is False, contact www.saintsxctf.com
	// When True, contact localhost
	const DEBUG = false;

	/*
	 *	API GET Requests
	 */

	public static function usersGetRequest()
	{
		if (self::DEBUG) {
			$request = new APIClientRequest('localhost/saints-xctf/api/api.php/users', 'GET');
		} else {
			$request = new APIClientRequest('www.saintsxctf.com/api/api.php/users', 'GET');
		}
		
		$request->execute();
		return $request;
	}

	public static function userGetRequest($username)
	{
		if (self::DEBUG) {
			$uri = 'localhost/saints-xctf/api/api.php/users/' . $username;
		} else {
			$uri = 'www.saintsxctf.com/api/api.php/users/' . $username;
		}
		
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function logsGetRequest()
	{
		if (self::DEBUG) {
			$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/logs', 'GET');
		} else {
			$request = new APIClientRequest('http://www.saintsxctf.com/api/api.php/logs', 'GET');
		}

		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function logGetRequest($log_id)
	{
		if (self::DEBUG) {
			$uri = 'http://localhost/saints-xctf/api/api.php/logs/' . $log_id;
		} else {
			$uri = 'http://www.saintsxctf.com/api/api.php/logs/' . $log_id;
		}

		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function groupsGetRequest()
	{
		if (self::DEBUG) {
			$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/groups', 'GET');
		} else {
			$request = new APIClientRequest('http://www.saintsxctf.com/api/api.php/groups', 'GET');
		}
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function groupGetRequest($groupname)
	{
		if (self::DEBUG) {
			$uri = 'http://localhost/saints-xctf/api/api.php/groups/' . $groupname;
		} else {
			$uri = 'http://www.saintsxctf.com/api/api.php/groups/' . $groupname;
		}
		
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

		if (self::DEBUG) {
			$uri = 'http://localhost/saints-xctf/api/api.php/logfeed/' . 
				$paramtype . '/' . $sortparam . '/' . $limit . '/' . $offset ;
		} else {
			$uri = 'http://www.saintsxctf.com/api/api.php/logfeed/' . 
				$paramtype . '/' . $sortparam . '/' . $limit . '/' . $offset ;
		}
		
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function commentsGetRequest()
	{
		if (self::DEBUG) {
			$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/comments', 'GET');
		} else {
			$request = new APIClientRequest('http://www.saintsxctf.com/api/api.php/comments', 'GET');
		}
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function commentGetRequest($comment_id)
	{
		if (self::DEBUG) {
			$uri = 'http://localhost/saints-xctf/api/api.php/comments/' . $comment_id;
		} else {
			$uri = 'http://www.saintsxctf.com/api/api.php/comments/' . $comment_id;
		}
		
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
		if (self::DEBUG) {
			$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/users', 'POST', $newuser);
		} else {
			$request = new APIClientRequest('http://www.saintsxctf.com/api/api.php/users', 'POST', $newuser);
		}
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function logPostRequest($newlog)
	{
		if (self::DEBUG) {
			$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/logs', 'POST', $newlog);
		} else {
			$request = new APIClientRequest('http://www.saintsxctf.com/api/api.php/logs', 'POST', $newlog);
		}
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function commentPostRequest($newcomment)
	{
		if (self::DEBUG) {
			$request = new APIClientRequest('http://localhost/saints-xctf/api/api.php/comments', 'POST', $newcomment);
		} else {
			$request = new APIClientRequest('http://www.saintsxctf.com/api/api.php/comments', 'POST', $newcomment);
		}
		
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
		if (self::DEBUG) {
			$uri = 'http://localhost/saints-xctf/api/api.php/users/' . $username;
		} else {
			$uri = 'http://www.saintsxctf.com/api/api.php/users/' . $username;
		}
		
		$request = new APIClientRequest($uri, 'PUT', $newuser);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function logPutRequest($log_id, $newlog)
	{
		if (self::DEBUG) {
			$uri = 'http://localhost/saints-xctf/api/api.php/logs/' . $log_id;
		} else {
			$uri = 'http://www.saintsxctf.com/api/api.php/logs/' . $log_id;
		}
		
		$request = new APIClientRequest($uri, 'PUT', $newlog);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function groupPutRequest($groupname, $newgroup)
	{
		if (self::DEBUG) {
			$uri = 'http://localhost/saints-xctf/api/api.php/groups/' . $groupname;
		} else {
			$uri = 'http://www.saintsxctf.com/api/api.php/groups/' . $groupname;
		}
		
		$request = new APIClientRequest($uri, 'PUT', $newgroup);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function commentPutRequest($comment_id, $newcomment)
	{
		if (self::DEBUG) {
			$uri = 'http://localhost/saints-xctf/api/api.php/comments/' . $comment_id;
		} else {
			$uri = 'http://www.saintsxctf.com/api/api.php/comments/' . $comment_id;
		}
		
		$request = new APIClientRequest($uri, 'PUT', $newlog);
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
		if (self::DEBUG) {
			$uri = 'http://localhost/saints-xctf/api/api.php/users/' . $username;
		} else {
			$uri = 'http://www.saintsxctf.com/api/api.php/users/' . $username;
		}
		
		$request = new APIClientRequest($uri, 'DELETE');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function logDeleteRequest($log_id)
	{
		if (self::DEBUG) {
			$uri = 'http://localhost/saints-xctf/api/api.php/logs/' . $log_id;
		} else {
			$uri = 'http://www.saintsxctf.com/api/api.php/logs/' . $log_id;
		}
		
		$request = new APIClientRequest($uri, 'DELETE');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}

	public static function commentDeleteRequest($comment_id)
	{
		if (self::DEBUG) {
			$uri = 'http://localhost/saints-xctf/api/api.php/comments/' . $comment_id;
		} else {
			$uri = 'http://www.saintsxctf.com/api/api.php/comments/' . $comment_id;
		}
		
		$request = new APIClientRequest($uri, 'DELETE');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());
		$request->execute();
		return $request;
	}
}