<?php

// Author: Andrew Jarombek
// Date: 6/9/2017
// Controller for REST requests for notifications

class NotificationRestController implements RestController
{
	private $db;
	private $message;
	private $tojson;
	private $toquery;

	public function __construct($db, $message = null)
	{
		$this->db = $db;
		$this->message = $message;
		$this->tojson = new ToJSON($db);
		$this->toquery = new ToQuery($db);
	}

	// Get all the notifications
	public function get($instance = null) 
	{
		if (isset($instance)) {
			// No get requests for a specific notification
			return null;
		} else {
			// Get all notifications information
			return $this->tojson->notificationsToJSON();
		}
	}

	// Add a notification to the api
	public function post($data = null) 
	{
		// POST is not allowed on a specific notification
		if (isset($data)) {
			// Add the notification to the database and then perform a GET request to
			// return the JSON notification representation
			$notificationno = $this->toquery->addJSONNotification($data);
			return $this->get($notificationno);
		} else {
			return 400;
		}
	}

	// Update a specific notification in the api
	public function put($instance = null, $data = null) 
	{
		if (isset($instance) && isset($data)) {

			$oldnotification = $this->get($instance);
			$newnotification = $data;

			$response = $this->toquery->updateJSONUser($instance, $oldnotification, $newnotification);

			// Return either the response error or the new notification JSON object
			if ($response == 409) {
				return $response;
			} else {
				return $this->get($instance);
			}

		} else {
			return 400;
		}
	}

	// Delete a specific notification in the api
	public function delete($instance = null) 
	{
		if (isset($instance)) {
			$response = $this->toquery->deleteJSONNotification($instance);
			return $response;
		} else {
			return 405;
		}
	}
}