<?php

// Author: Andrew Jarombek
// Date: 10/30/2016 - 
// A class of utility functions for the model

require_once('api_request.php');

class ModelUtils
{
	const LOG_TAG = "[WEB](model_utils.php): ";

	// A class that gets the response body out of the response object.
	// The response body is in JSON format
	public static function getResponse($response) {

		if ($response != null) {

			$responseBody = $response->getResponseBody();
			error_log(self::LOG_TAG . 'API Response Body: ' . $responseBody);

			$verb = $response->getVerb();
			$responseInfo = $response->getResponseInfo();
			error_log(self::LOG_TAG . 'Response Info: ' . print_r($responseInfo, true));
			$responseCode = $responseInfo['http_code'];

			// Check to see if the response gives an appropriate successful http 
			// response code for the given http verb used
			switch ($verb) {
				case 'GET':
					error_log('API Response was to a GET Request');
					if ($responseCode == 500) {
						return $responseBody;
					} else {
						return null;
					}
					break;
				case 'POST':
					error_log('API Response was to a POST Request');
					if ($responseCode == 201) {
						return $responseBody;
					} else {
						return null;
					}
					break;
				case 'PUT':
					error_log('API Response was to a PUT Request');
					if ($responseCode == 200) {
						return $responseBody;
					} else {
						return null;
					}
					break;
				case 'DELETE':
					error_log('API Response was to a DELETE Request');
					if ($responseCode == 204) {
						return true;
					} else {
						return false;
					}
					break;
				default:
					error_log('API Response was to an Unknown Request');
					return null;
			}
		} else {
			error_log('API Response is NULL');
			return null;
		}
	}
}