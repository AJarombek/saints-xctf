<?php

// Author: Andrew Jarombek
// Date: 5/28/2016 - 
// Model For Accessing the Database

// Class To Search the Database and Add to the Database
class Queries {
    
    private $db; // PDO Construct
    
    function __construct($db) {
        $this->db = $db;
    }
    
    function usernameExists($username) {
        
    }
    
    function addUser($username, $first, $last, $password) {
        
    }
    
    function addGroups() {
        
    }
}