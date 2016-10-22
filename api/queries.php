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
    // TODO PASSWORD SHOULD BE HASHED BEFORE BEING SENT ACROSS THE NETWORK TO THE API
    public function addUser($username, $first, $last, $password, $salt = null) 
    {

        $salt = $this->getSalt();
        $passalt = trim($password . $salt);
        $hash = password_hash($passalt, PASSWORD_DEFAULT);
        $date = date('Y-m-d H:i:s');
        $insert = $this->db->prepare('insert into users(username,first,last,salt,password, member_since)
                                     values(:username,:first,:last,:salt,:password,:member_since)');
        $insert->bindParam(':username', $username, PDO::PARAM_STR);
        $insert->bindParam(':first', $first, PDO::PARAM_STR);
        $insert->bindParam(':last', $last, PDO::PARAM_STR);
        $insert->bindParam(':salt', $salt, PDO::PARAM_STR);
        $insert->bindParam(':password', $hash, PDO::PARAM_STR);
        $insert->bindParam(':member_since', $date, PDO::PARAM_STR);
        return $insert->execute();
    }

    // Update a user in the database
    public function updateUser($username, $user) 
    {
        $update = $this->db->prepare('update users set first=:first, last=:last, salt=:salt, password=:password, 
            profilepic=:profilepic, profilepic_name=:profilepic_name, description=:description, member_since=:member_since,
            class_year=:class_year, location=:location, favorite_event=:favorite_event where username=:username');
        $update->bindParam(':first', $user['first'], PDO::PARAM_STR);
        $update->bindParam(':last', $user['last'], PDO::PARAM_STR);
        $update->bindParam(':salt', $user['salt'], PDO::PARAM_STR);
        $update->bindParam(':password', $user['password'], PDO::PARAM_STR);
        $update->bindParam(':profilepic', $user['profilepic'], PDO::PARAM_LOB);
        $update->bindParam(':profilepic_name', $user['profilepic_name'], PDO::PARAM_STR);
        $update->bindParam(':description', $user['description'], PDO::PARAM_STR);
        $update->bindParam(':member_since', $user['member_since'], PDO::PARAM_STR);
        $update->bindParam(':class_year', $user['class_year'], PDO::PARAM_INT);
        $update->bindParam(':location', $user['location'], PDO::PARAM_STR);
        $update->bindParam(':favorite_event', $user['favorite_event'], PDO::PARAM_STR);
        $update->bindParam(':username', $username, PDO::PARAM_STR);
        $update->execute();
        return $update;
    }

    // Delete a user from the database
    public function deleteUser($username) 
    {
        $delete = $this->db->prepare('delete from users where username=:username');
        $delete->bindParam(':username', $username, PDO::PARAM_STR);
        return $delete->execute();
    }

    // Sign In a user by verifying that the submitted username and password matches the database
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
    public function getUsers() 
    {
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

    // Unsubscribe a user to a team
    public function removeTeams($username, $groupname) 
    {
        $delete = $this->db->prepare('delete from groupmembers where username=:username, groupname=:groupname');
        $delete->bindParam(':username', $username, PDO::PARAM_STR);
        $delete->bindParam(':groupname', $groupname, PDO::PARAM_STR);
        return $delete->execute();
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
        $select = $this->db->prepare('select groupmembers.group_name, group_title from groupmembers inner join groups on 
                                    groups.group_name=groupmembers.group_name where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Update a user in the database
    public function updateTeams($username, $oldteams, $newteams) 
    {
        // First remove any teams that are no longer associated with this user
        foreach ($oldteams as $oldteam) {
            $found = false;
            foreach ($newteams as $newteam) {
                if ($oldteam == $newteam) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $this->removeTeams($username, $newteam['group_name']);
            }
        }

        // Second add any teams that are newly associated with this user
        foreach ($newteams as $newteam) {
            $found = false;
            foreach ($oldteams as $oldteam) {
                if ($oldteam == $newteam) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $this->addTeams($username, $newteam['group_name']);
            }
        }
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