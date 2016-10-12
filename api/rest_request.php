<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Class for storing information about the REST request made

namespace Rest;

class RestRequest {   
    private $data;  
    private $request_method;  
    private $method;  
  
    public function __construct() {  
        $this->data = array();  
        $this->method = '';    
        $this->request_method = 'get';  
    }  
  
  	// Getter and Setter methods
    public function setData($data) {  
        $this->data = $data;  
    }  
  
    public function setMethod($method) {  
        $this->method = $method;  
    }  
  
    public function setRequestMethod($request_method) {  
        $this->request_method = $request_method;  
    }  
  
    public function getData() {  
        return $this->data;  
    }  
  
    public function getMethod() {  
        return $this->method;  
    }  
  
    public function getRequestMethod() {  
        return $this->request_method;  
    }  
}