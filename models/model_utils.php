<?php

// Author: Andrew Jarombek
// Date: 10/30/2016 - 
// A class of utility functions for the model

class ModelUtils
{

	// A class that gets the response body out of the response object.
	// The response body is in JSON format
	public static function getResponse($response) {
		$responseBody = $response->getResponseBody();

		$verb = $response->getVerb();
		$responseInfo = $response->getResponseInfo();
		$responseCode = $responseInfo['http_code'];

		// Check to see if the response gives an appropriate successful http 
		// response code for the given http verb used
		switch ($verb) {
			case 'GET':
				if ($responseCode === 200) {
					return $responseBody;
				} else {
					return null;
				}
				break;
			case 'POST':
				if ($responseCode === 201) {
					return $responseBody;
				} else {
					return null;
				}
				break;
			case 'PUT':
				if ($responseCode === 200) {
					return $responseBody;
				} else {
					return null;
				}
				break;
			case 'DELETE':
				if ($responseCode === 204) {
					return true;
				} else {
					return false;
				}
				break;
			default:
				return null;
		}
	}
}