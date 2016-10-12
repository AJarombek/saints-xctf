<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Util class for dealing with REST requests and responses
// Help from: https://web.archive.org/web/20130910164802/
//       http://www.gen-x-design.com/archives/create-a-rest-api-with-php/

namespace Rest;
require_once('rest_request.php');

class RestUtils 
{  

    public static function processRequest() 
    {  
        // Get the HTTP verb (GET, POST, PUT, DELETE)
        $request_method = strtolower($_SERVER['REQUEST_METHOD']);

        $rest_request = new RestRequest();
        $data = array();

        // Populate data based on the request method
        switch ($request_method) {
            case 'get':
                $data = $_GET;
                break;
            case 'post':
                $data = $_POST;
                break;
            case 'put':
                // Get the input locations contents and put it in array put_vars
                parse_str(file_get_contents('php://input'), $put_vars);
                $data = $put_vars;
            
            default:
                // code...
                break;
        }

        // Store the request method
        $rest_request->setMethod($request_method);

        // Store the raw data that was in the request
        $rest_request->setRequestVars($data);

        // If the request had data
        if (isset($data['data'])) {
            $rest_request->setData(json_decode($data['data']));
        }

        return $rest_request;
    }  
  
    public static function sendResponse($status = 200, $body = '', $content_type = 'text/html') 
    {  
        $status_header = 'HTTP/1.1' . $status . ' ' . RestUtils::getStatusCodeMessage($status);

        // set the header status and content type
        header($status_header);
        header('Content-type: ' . $content_type);

        // If a page has a body, simply echo it
        if ($body != '') {
            echo $body;
            exit;
        } 
        else 
        {
            // Otherwise we need to create a body

            // Create some potential error code messages to print to the screen
            switch($status) {  
                case 401:  
                    $message = 'You must be authorized to view this page.';  
                    break;  
                case 404:  
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';  
                    break;  
                case 500:  
                    $message = 'The server encountered an error processing your request.';  
                    break;  
                case 501:  
                    $message = 'The requested method is not implemented.';  
                    break;  
            }

            // Create the error message to be displayed
            $body = '{Error connecting to API: ' . getStatusCodeMessage($status) 
                    . ' - ' . $message . '}';

            echo $body;
            exit;
        }
    }  
  
    // Return the proper status code message from the status code
    public static function getStatusCodeMessage($status) 
    {  
        // Array of all the HTTP response codes 
        $codes = Array(  
            100 => 'Continue',  
            101 => 'Switching Protocols',  
            200 => 'OK',  
            201 => 'Created',  
            202 => 'Accepted',  
            203 => 'Non-Authoritative Information',  
            204 => 'No Content',  
            205 => 'Reset Content',  
            206 => 'Partial Content',  
            300 => 'Multiple Choices',  
            301 => 'Moved Permanently',  
            302 => 'Found',  
            303 => 'See Other',  
            304 => 'Not Modified',  
            305 => 'Use Proxy',  
            306 => '(Unused)',  
            307 => 'Temporary Redirect',  
            400 => 'Bad Request',  
            401 => 'Unauthorized',  
            402 => 'Payment Required',  
            403 => 'Forbidden',  
            404 => 'Not Found',  
            405 => 'Method Not Allowed',  
            406 => 'Not Acceptable',  
            407 => 'Proxy Authentication Required',  
            408 => 'Request Timeout',  
            409 => 'Conflict',  
            410 => 'Gone',  
            411 => 'Length Required',  
            412 => 'Precondition Failed',  
            413 => 'Request Entity Too Large',  
            414 => 'Request-URI Too Long',  
            415 => 'Unsupported Media Type',  
            416 => 'Requested Range Not Satisfiable',  
            417 => 'Expectation Failed',  
            500 => 'Internal Server Error',  
            501 => 'Not Implemented',  
            502 => 'Bad Gateway',  
            503 => 'Service Unavailable',  
            504 => 'Gateway Timeout',  
            505 => 'HTTP Version Not Supported'  
        );  
  
        // If the status matches a status code in the array, return it
        return (isset($codes[$status])) ? $codes[$status] : '';  
    }  
}  