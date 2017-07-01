<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 12/24/2016
// Controller for REST requests for running logs
// Version 0.4 (BETA) - 12/24/2016

class MailRestController implements RestController
{
	private $db;
	private $log;
	private $tojson;
	private $toquery;

	public function __construct($db, $log = null)
	{
		$this->db = $db;
		$this->log = $log;
		$this->tojson = new ToJSON($db);
		$this->toquery = new ToQuery($db);
	}

	// Getting mail is not allowed
	public function get($instance = null) 
	{
		return null;
	}

	// Send a piece of mail
	public function post($data = null) 
	{
		if (isset($data)) {
			$to = $data['emailAddress'];
            $subject = $data['subject'];
            $txt = $data['body'];
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: admin@saintsxctf.com\r\n";
            $headers .= "Reply-To: admin@saintsxctf.com \r\n";
            $headers .= "Return-Path: admin@saintsxctf.com\r\n";
            $headers .= "X-Mailer: PHP \r\n";

            mail($to,$subject,$txt,$headers);
		} else {
			return 400;
		}
	}

	// Modifying mail is not allowed
	public function put($instance = null, $data = null) 
	{
		return null;
	}

	// Deleting mail is not allowed
	public function delete($instance = null) 
	{
		return null;
	}
}