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
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        
        $result = $select->fetch(PDO::FETCH_ASSOC);
        $count = $result['count(*)'];
        
        return ($count>0);
    }
    
    // Create a salt for password protection
    function getSalt() {
        $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/\\][{}\'";:?.>,<!@#$%^&*()-_=+|';
        $saltLength = 64;
    
        $salt = '';
        for ($i = 0; $i < $saltLength; $i++) {
            $salt .= $charset[mt_rand(0, strlen($charset) - 1)];
        }
        return $salt;
    }
    
    // Try to add a user to the database
    function addUser($username, $first, $last, $password) {
        $salt = $this->getSalt();
        $hash = password_hash($password . $salt, PASSWORD_DEFAULT);
        $insert = $this->db->prepare('insert into users(username,first,last,salt,password)
                                     values(:username,:first,:last,:salt,:password)');
        $insert->bindParam(':username', $username, PDO::PARAM_STR);
        $insert->bindParam(':first', $first, PDO::PARAM_STR);
        $insert->bindParam(':last', $last, PDO::PARAM_STR);
        $insert->bindParam(':salt', $salt, PDO::PARAM_STR);
        $insert->bindParam(':password', $hash, PDO::PARAM_STR);
        return $insert->execute();
    }

    function signIn($username, $password) {
        $select = $this->db->prepare('select * from users where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();

        $result = $select->fetch(PDO::FETCH_ASSOC);
        // Recreate the password hash with the submitted password
        $salt = trim($result['salt']);
        $oldhash = trim($result['password']);
        $newhash = password_hash($password . $salt, PASSWORD_DEFAULT);

        // Error Checking
        if ($username === $result['username'])
            $_SESSION['unmatch'] = 'true';
        else
            $_SESSION['unmatch'] = 'false';
        if ($newhash === $oldhash)
            $_SESSION['pmatch'] = 'true';
        else
            $_SESSION['pmatch'] = 'false';

        // Return true if credentials match, false if they dont
        return ($username === $result['username'] && $newhash === $oldhash);
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
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute;
        
        $result = $select->fetch(PDO::FETCH_ASSOC);
        $count = $result[0];
        
        return ($count>0);
    }
    
    // Subscribe a user to a team
    function addTeams($username, $groupname) {
        $insert = $this->db->prepare('insert into groupmembers(group_name,username) values(:groupname,:username)');
        $insert->bindParam(':username', $username, PDO::PARAM_STR);
        $insert->bindParam(':groupname', $groupname, PDO::PARAM_STR);
        return $insert->execute();
    }

    // Get all of the running logs
    function getLogs() {
        $select = $this->db->prepare('select * from logs order by date');
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get all the teams a user is subscribed to
    function getTeams($username) {
        $select = $this->db->prepare('select group_title from groups natural join groupmembers where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}