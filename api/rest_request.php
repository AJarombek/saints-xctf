<?php

// Author: Andrew Jarombek
// Date: 10/12/2016 - 
// Class for storing information about the REST request made

namespace Rest;

class RestRequest {  
    private $request_vars;  
    private $data;  
    private $http_accept;  
    private $method;  
  
    public function __construct() {  
        $this->request_vars = array();  
        $this->data = '';    
        $this->method = 'get';  
    }  
  
  	// Getter and Setter methods
    public function setData($data) {  
        $this->data = $data;  
    }  
  
    public function setMethod($method) {  
        $this->method = $method;  
    }  
  
    public function setRequestVars($request_vars) {  
        $this->request_vars = $request_vars;  
    }  
  
    public function getData() {  
        return $this->data;  
    }  
  
    public function getMethod() {  
        return $this->method;  
    }  
  
    public function getRequestVars() {  
        return $this->request_vars;  
    }  
}