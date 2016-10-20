<?php

// Author: Andrew Jarombek
// Date: 5/28/2016 - 
// Model For Accessing the Database

// Class To Search the Database and Add to the Database
class Queries 
{
    
    private $db; // PDO Construct
    
    public function __construct($db) 
    {
        $this->db = $db;
    }
    
    // Check if a Username is already in use, return boolean
    public function usernameExists($username) 
    {
        $select = $this->db->prepare('select count(*) from users where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        
        $result = $select->fetch(PDO::FETCH_ASSOC);
        $count = $result['count(*)'];
        
        return ($count>0);
    }
    
    // Create a salt for password protection
    public function getSalt() 
    {
        $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*(){}[]|';
        $saltLength = 64;
    
        $salt = '';
        for ($i = 0; $i < $saltLength; $i++) {
            $salt .= $charset[mt_rand(0, strlen($charset) - 1)];
        }
        return $salt;
    }
    
    // Try to add a user to the database
    public function addUser($username, $first, $last, $password) 
    {

        $salt = $this->getSalt();
        $passalt = trim($password . $salt);
        $hash = password_hash($passalt, PASSWORD_DEFAULT);
        $insert = $this->db->prepare('insert into users(username,first,last,salt,password)
                                     values(:username,:first,:last,:salt,:password)');
        $insert->bindParam(':username', $username, PDO::PARAM_STR);
        $insert->bindParam(':first', $first, PDO::PARAM_STR);
        $insert->bindParam(':last', $last, PDO::PARAM_STR);
        $insert->bindParam(':salt', $salt, PDO::PARAM_STR);
        $insert->bindParam(':password', $hash, PDO::PARAM_STR);
        return $insert->execute();
    }

    public function signIn($username, $password) 
    {
        $select = $this->db->prepare('select * from users where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();

        $result = $select->fetch(PDO::FETCH_ASSOC);
        // Recreate the password hash with the submitted password
        $salt = $result['salt'];
        $oldhash = $result['password'];

        $passalt = trim($password . $salt);
        $match = password_verify($passalt, $oldhash);

        // Error Checking
        $_SESSION['salt'] = $salt;
        $_SESSION['passalt'] = $passalt;

        if ($username === $result['username'])
            $_SESSION['unmatch'] = 'true';
        else
            $_SESSION['unmatch'] = 'false';
        if ($match)
            $_SESSION['pmatch'] = 'true';
        else
            $_SESSION['pmatch'] = 'false';

        // Return true if credentials match, false if they dont
        return ($username === $result['username'] && $match);
    }

    // Get all of the users and their information
    public function getUsers() {
        $select = $this->db->prepare('select * from users');
        $select->execute();
        
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // Get all of the users information, returns an array
    public function getUserDetails($username) 
    {
        $select = $this->db->prepare('select * from users where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        
        $result = $select->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // Check to see if the user is subscribed to any teams, return a boolean
    public function subscribed($username) 
    {
        $select = $this->db->prepare('select count(*) from groupmembers where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute;
        
        $result = $select->fetch(PDO::FETCH_ASSOC);
        $count = $result[0];
        
        return ($count>0);
    }
    
    // Subscribe a user to a team
    public function addTeams($username, $groupname) 
    {
        $insert = $this->db->prepare('insert into groupmembers(group_name,username) values(:groupname,:username)');
        $insert->bindParam(':username', $username, PDO::PARAM_STR);
        $insert->bindParam(':groupname', $groupname, PDO::PARAM_STR);
        return $insert->execute();
    }

    // Get all of the running logs
    public function getLogs() 
    {
        $select = $this->db->prepare('select * from logs order by date');
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get a specific users running logs
    public function getUsersLogs($username) 
    {
        $select = $this->db->prepare('select * from logs where username=:username order by date');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get all the teams a user is subscribed to
    public function getTeams($username) 
    {
        $select = $this->db->prepare('select group_title from groupmembers inner join groups on 
                                    groups.group_name=groupmembers.group_name where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get the total miles that a user has exercised
    public function getUserMiles($username) 
    {
        $select = $this->db->prepare('select sum(miles) as total from logs where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        
        $miles = $result['total'];

        if (isset($miles)) {
            return $miles;
        } else {
            return 0;
        }
    }

    // Get the total miles that a user has exercised for a specific exercise
    public function getUserMilesExercise($username, $exercise) 
    {
        $select = $this->db->prepare('select sum(miles) as total from logs where username=:username and type=:exercise');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->bindParam(':exercise', $exercise, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        
        $miles = $result['total'];

        if (isset($miles)) {
            return $miles;
        } else {
            return 0;
        }
    }

    // Get the total miles that a user had exercised over a given interval of time
    public function getUserMilesInterval($username, $interval) 
    {
        if ($interval === 'year') {
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and date >= date_sub(now(), interval 1 year)');
        } elseif ($interval === 'month') {
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and date >= date_sub(now(), interval 1 month)');
        } elseif ($interval === 'week') {
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and date >= date_sub(now(), interval 1 week)');
        } else {
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username');
        }
        
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        $miles = $result['total'];

        if (isset($miles)) {
            return $miles;
        } else {
            return 0;
        }
    }

    // Get the total miles that a user had exercised over a given interval of time for a specific exercise
    public function getUserMilesExerciseInterval($username, $interval, $exercise) 
    {
        if ($interval === 'year') {
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and type=:exercise and date >= date_sub(now(), interval 1 year)');
        } elseif ($interval === 'month') {
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and type=:exercise and date >= date_sub(now(), interval 1 month)');
        } elseif ($interval === 'week') {
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and type=:exercise and date >= date_sub(now(), interval 1 week)');
        } else {
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and type=:exercise');
        }
        
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->bindParam(':exercise', $exercise, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        $miles = $result['total'];

        if (isset($miles)) {
            return $miles;
        } else {
            return 0;
        }
    }
}