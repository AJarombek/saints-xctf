<?php

// Author: Andrew Jarombek
// Date: 10/24/2016 - 6/2/2017
// The Client that creates calls for the REST API
// Version 0.4 (BETA) - 12/24/2016
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

require_once('api_request.php');

class APIClient
{
	const LOG_TAG = "[WEB](api_client.php): ";

	// When DEBUG is False, contact www.saintsxctf.com
	// When True, contact localhost
	const DEBUG = false;

	private static $url;

    /**
     * Initialize static variables for use across static functions.
     */
	public static function init()
    {
        $ENV = getenv("ENV");

        if (self::DEBUG) {
            APIClient::$url = "localhost/saints-xctf/";
        } else {
            APIClient::$url = ($ENV == "dev") ? "saintsxctfdev.jarombek.io/" : "saintsxctf.jarombek.io/";
        }
    }

	/*
	 *	API GET Requests
	 */

	public static function usersGetRequest()
	{
        $request = new APIClientRequest(APIClient::$url . '/api/api.php/users', 'GET');

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

        return $request;
	}

	public static function userGetRequest($username)
	{
		$uri = APIClient::$url . '/api/api.php/users/' . $username;
		
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

        return $request;
	}

	public static function logsGetRequest()
	{
		$request = new APIClientRequest(APIClient::$url . '/api/api.php/logs', 'GET');

		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function logGetRequest($log_id)
	{
		$uri = APIClient::$url . '/api/api.php/logs/' . $log_id;

		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function groupsGetRequest()
	{
		$request = new APIClientRequest(APIClient::$url . '/api/api.php/groups', 'GET');
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function groupGetRequest($groupname)
	{
		$uri = APIClient::$url . '/api/api.php/groups/' . $groupname;
		
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function logFeedGetRequest($params)
	{
		$paramtype = $params['paramtype'];
		$sortparam = $params['sortparam'];
		$limit = $params['limit'];
		$offset = $params['offset'];

		$uri = APIClient::$url . '/api/api.php/logfeed/' .
				$paramtype . '/' . $sortparam . '/' . $limit . '/' . $offset;
		
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function commentsGetRequest()
	{
		$request = new APIClientRequest(APIClient::$url . '/api/api.php/comments', 'GET');
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function commentGetRequest($comment_id)
	{
		$uri = APIClient::$url . '/api/api.php/comments/' . $comment_id;
		
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function messagesGetRequest()
	{
		$request = new APIClientRequest(APIClient::$url . '/api/api.php/messages', 'GET');

		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function messageGetRequest($message_id)
	{
		$uri = APIClient::$url . '/api/api.php/messages/' . $message_id;

		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function messageFeedGetRequest($params)
	{
		$paramtype = $params['paramtype'];
		$sortparam = $params['sortparam'];
		$limit = $params['limit'];
		$offset = $params['offset'];

		$uri = APIClient::$url . '/api/api.php/messagefeed/' .
            $paramtype . '/' . $sortparam . '/' . $limit . '/' . $offset ;
		
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function rangeViewGetRequest($params)
	{
		$paramtype = $params['paramtype'];
		$sortparam = $params['sortparam'];
		$filter = $params['filter'];
		$start = $params['start'];
		$end = $params['end'];

		$uri = APIClient::$url . '/api/api.php/rangeview/' .
            $paramtype . '/' . $sortparam . '/' . $filter . '/' . $start . '/' . $end;
		
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function activationCodeGetRequest($activation_code)
	{
		$uri = APIClient::$url . '/api/api.php/activationcode/' . $activation_code;
		
		$request = new APIClientRequest($uri, 'GET');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function notificationsGetRequest()
	{
		$request = new APIClientRequest(APIClient::$url . '/api/api.php/notifications', 'GET');

		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	/*
	 *	API POST Requests
	 */

	public static function userPostRequest($newuser)
	{
		$request = new APIClientRequest(APIClient::$url . '/api/api.php/users', 'POST', $newuser);
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function logPostRequest($newlog)
	{
		$request = new APIClientRequest(APIClient::$url . '/api/api.php/logs', 'POST', $newlog);
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function commentPostRequest($newcomment)
	{
		$request = new APIClientRequest(APIClient::$url . '/api/api.php/comments', 'POST', $newcomment);
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function messagePostRequest($newmessage)
	{
		$request = new APIClientRequest(APIClient::$url . '/api/api.php/messages', 'POST', $newmessage);
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function activationCodePostRequest($activation_code)
	{
		$request = new APIClientRequest(APIClient::$url . '/api/api.php/activationcode',
            'POST', $activation_code);
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function notificationPostRequest($notification)
	{
		$request = new APIClientRequest(APIClient::$url . '/api/api.php/notification', 'POST', $notification);
		
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	/*
	 *	API PUT Requests
	 */

	public static function userPutRequest($username, $newuser)
	{
		$uri = APIClient::$url . '/api/api.php/users/' . $username;
		
		$request = new APIClientRequest($uri, 'PUT', $newuser);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function logPutRequest($log_id, $newlog)
	{
		$uri = APIClient::$url . '/api/api.php/logs/' . $log_id;
		
		$request = new APIClientRequest($uri, 'PUT', $newlog);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function groupPutRequest($groupname, $newgroup)
	{
		$uri = APIClient::$url . '/api/api.php/groups/' . $groupname;
		
		$request = new APIClientRequest($uri, 'PUT', $newgroup);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function commentPutRequest($comment_id, $newcomment)
	{
		$uri = APIClient::$url . '/api/api.php/comments/' . $comment_id;
		
		$request = new APIClientRequest($uri, 'PUT', $newcomment);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function messagePutRequest($message_id, $newmessage)
	{
		$uri = APIClient::$url . '/api/api.php/messages/' . $message_id;
		
		$request = new APIClientRequest($uri, 'PUT', $newmessage);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function notificationPutRequest($notification_id, $newnotification)
	{
		$uri = APIClient::$url . '/api/api.php/notifications/' . $notification_id;
		
		$request = new APIClientRequest($uri, 'PUT', $newnotification);
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	/*
	 *	API DELETE Requests
	 */

	public static function userDeleteRequest($username)
	{
		$uri = APIClient::$url . '/api/api.php/users/' . $username;
		
		$request = new APIClientRequest($uri, 'DELETE');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function logDeleteRequest($log_id)
	{
		$uri = APIClient::$url . '/api/api.php/logs/' . $log_id;
		
		$request = new APIClientRequest($uri, 'DELETE');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function commentDeleteRequest($comment_id)
	{
		$uri = APIClient::$url . '/api/api.php/comments/' . $comment_id;
		
		$request = new APIClientRequest($uri, 'DELETE');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function messageDeleteRequest($message_id)
	{
		$uri = APIClient::$url . '/api/api.php/messages/' . $message_id;
		
		$request = new APIClientRequest($uri, 'DELETE');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function activationCodeDeleteRequest($activation_code)
	{
		$uri = APIClient::$url . '/api/api.php/activationcode/' . $activation_code;

		$request = new APIClientRequest($uri, 'DELETE');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}

	public static function notificationDeleteRequest($notification)
	{
		$uri = APIClient::$url . '/api/api.php/notification/' . $notification;
		
		$request = new APIClientRequest($uri, 'DELETE');
		error_log(self::LOG_TAG . 'Requested REST URL: ' . $request->getUrl());
		error_log(self::LOG_TAG . 'Requested REST Verb: ' . $request->getVerb());

        try {
            $request->execute();
        } catch (Exception $e) {
            error_log(self::LOG_TAG . 'ERROR: ' . $request->getUrl() . ' - ' . $request->getVerb() . ' Failed');
        }

		return $request;
	}
}