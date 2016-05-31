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
    
    // Check if a Username is already in use, return boolean
    function usernameExists($username) {
        $select = $this->db->prepare('select count(*) from users where username=:username');
        $select->bindParam(':username', $username, PDO:PARAM_STR);
        $select->execute;
        
        $result = $select->fetch(PDO::FETCH_ASSOC);
        $count = $result[0];
        
        if (result>0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Try to add a user to the database
    function addUser($username, $first, $last, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $insert = $this->db->prepare('insert into users(username,first,last,password)
                                     values(:username,:first,:last,:password)');
        $insert->bindParam(':username', $username, PDO::PARAM_STR);
        $insert->bindParam(':first', $first, PDO::PARAM_STR);
        $insert->bindParam(':last', $last, PDO::PARAM_STR);
        $insert->bindParam(':password', $hash, PDO::PARAM_STR);
        return $insert->execute();
    }
    
    // Get all of the users information, returns an array
    function getUserDetails($username) {
        $select = $this->db->prepare('select * from users where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        
        $result = $select->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // Check to see if the user is subscribed to any teams, return a boolean
    function subscribed($username) {
        $select = $this->db->prepare('select count(*) from groupmembers where username=:username');
        $select->bindParam(':username', $username, PDO:PARAM_STR);
        $select->execute;
        
        $result = $select->fetch(PDO::FETCH_ASSOC);
        $count = $result[0];
        
        if (result>0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Subscribe a user to a team
    function addSubscription($username, $groupname) {
        $insert = $this->db->prepare('insert into groupmembers(group_name,username) values(:groupname,:username)');
        $insert->bindParam(':username', $username, PDO::PARAM_STR);
        $insert->bindParam(':groupname', $groupname, PDO::PARAM_STR);
        return $insert->execute();
    }
}