<?php

// Author: Andrew Jarombek
// Date: 5/28/2016 - 6/2/2017
// Model For Accessing the Database
// Version 0.4 (BETA) - 12/24/2016
// Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

require_once('api_utils.php');

// Class To Search the Database and Add to the Database
class Queries 
{
    
    private $db; // PDO Construct
    const LOG_TAG = "[API](queries.php): ";
    
    public function __construct($db) 
    {
        $this->db = $db;
    }

    //****************************************************
    //  LOG IN AND SIGN UP
    //****************************************************
    
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

    // Function to update the last signed in date for a user
    public function updateLastSignIn($username)
    {
        date_default_timezone_set('America/New_York');
        $date = date('Y-m-d H:i:s');
        $update = $this->db->prepare('update users set last_signin=:date where username=:username');
        $update->bindParam(':date', $date, PDO::PARAM_STR);
        $update->bindParam(':username', $username, PDO::PARAM_STR);
        $update->execute();
        return $update;
    }

    //****************************************************
    //  FORGOT PASSWORD
    //****************************************************

    // Try to add a user to the database
    public function addForgotPassword($username, $forgot_code) 
    {
        date_default_timezone_set('America/New_York');
        $expires = date('Y-m-d H:i:s', strtotime('+2 hours'));
        $insert = $this->db->prepare('insert into forgotpassword(username,forgot_code,expires)
                                     values(:username,:forgot_code,:expires)');
        $insert->bindParam(':username', $username, PDO::PARAM_STR);
        $insert->bindParam(':forgot_code', $forgot_code, PDO::PARAM_STR);
        $insert->bindParam(':expires', $expires, PDO::PARAM_STR);
        return $insert->execute();
    }

    // Return the forgot password codes for this particular user
    public function getForgotPassword($username)
    {
        date_default_timezone_set('America/New_York');
        $select = $this->db->prepare('select forgot_code from forgotpassword where username=:username and expires >= NOW()');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Delete a forgot password code from the database
    public function deleteForgotPassword($forgot_code) 
    {
        $delete = $this->db->prepare('delete from forgotpassword where forgot_code=:forgot_code');
        $delete->bindParam(':forgot_code', $forgot_code, PDO::PARAM_STR);
        return $delete->execute();
    }

    //****************************************************
    //  USERS AND USER INFORMATION
    //****************************************************

    // Try to add a user to the database
    public function addUser($username, $first, $last, $email, $password, $activation_code, $salt = null) 
    {
        $exists = $this->codeExists($activation_code);
        $week_start = 'monday';
        if ($exists) {
            date_default_timezone_set('America/New_York');
            $date = date('Y-m-d H:i:s');
            $insert = $this->db->prepare('insert into users(username,first,last,email,salt,password,
                                        member_since,activation_code,last_signin,week_start)
                                        values(:username,:first,:last,:email,:salt,:password,
                                        :member_since,:activation_code,:last_signin,:week_start)');
            $insert->bindParam(':username', $username, PDO::PARAM_STR);
            $insert->bindParam(':first', $first, PDO::PARAM_STR);
            $insert->bindParam(':last', $last, PDO::PARAM_STR);
            $insert->bindParam(':email', $email, PDO::PARAM_STR);
            $insert->bindParam(':salt', $salt, PDO::PARAM_STR);
            $insert->bindParam(':password', $password, PDO::PARAM_STR);
            $insert->bindParam(':member_since', $date, PDO::PARAM_STR);
            $insert->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
            $insert->bindParam(':last_signin', $date, PDO::PARAM_STR);
            $insert->bindParam(':week_start', $week_start, PDO::PARAM_STR);
            return $insert->execute();
        } else {
            return false;
        }
    }

    // Helper function to make sure the submitted code exists
    public function codeExists($activation_code)
    {
        $select = $this->db->prepare('select count(*) as \'exists\' from codes where activation_code=:activation_code');
        $select->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        $exists = $result['exists'];
        return ($exists == 1);
    }

    public function addCode($activation_code)
    {
        $insert = $this->db->prepare('insert into codes(activation_code)
                                     values(:activation_code)');
        $insert->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
        return $insert->execute();
    }

    // Remove a used activation code from the list
    public function removeCode($activation_code)
    {
        $delete = $this->db->prepare('delete from codes where activation_code=:activation_code');
        $delete->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
        return $delete->execute();
    }

    // Update a user in the database
    public function updateUser($username, $user) 
    {
        $update = $this->db->prepare('update users set first=:first, last=:last, email=:email, salt=:salt,  
            password=:password, profilepic=:profilepic, profilepic_name=:profilepic_name, description=:description,
            class_year=:class_year, location=:location, favorite_event=:favorite_event, week_start=:week_start 
            where username=:username');
        $update->bindParam(':first', $user['first'], PDO::PARAM_STR);
        $update->bindParam(':last', $user['last'], PDO::PARAM_STR);
        $update->bindParam(':email', $user['email'], PDO::PARAM_STR);
        $update->bindParam(':salt', $user['salt'], PDO::PARAM_STR);
        $update->bindParam(':password', $user['password'], PDO::PARAM_STR);
        $update->bindParam(':profilepic', $user['profilepic'], PDO::PARAM_LOB);
        $update->bindParam(':profilepic_name', $user['profilepic_name'], PDO::PARAM_STR);
        $update->bindParam(':description', $user['description'], PDO::PARAM_STR);
        $update->bindParam(':class_year', $user['class_year'], PDO::PARAM_INT);
        $update->bindParam(':location', $user['location'], PDO::PARAM_STR);
        $update->bindParam(':favorite_event', $user['favorite_event'], PDO::PARAM_STR);
        $update->bindParam(':week_start', $user['week_start'], PDO::PARAM_STR);
        $update->bindParam(':username', $username, PDO::PARAM_STR);
        $update->execute();
        return $update;
    }

    // Update a users password in the database
    public function updatePassword($username, $password) 
    {
        $update = $this->db->prepare('update users set password=:password where username=:username');
        $update->bindParam(':username', $username, PDO::PARAM_STR);
        $update->bindParam(':password', $password, PDO::PARAM_STR);
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

    // Get all of the users information searching by email, returns an array
    public function getUserDetailsEmail($email) 
    {
        $select = $this->db->prepare('select * from users where email=:email');
        $select->bindParam(':email', $email, PDO::PARAM_STR);
        $select->execute();
        
        $result = $select->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Add flair for a specific user
    public function addUserFlair($username, $flair)
    {
        $insert = $this->db->prepare('insert into flair(username,flair) 
                                    values(:username,:flair)');
        $insert->bindParam(':username', $username, PDO::PARAM_STR);
        $insert->bindParam(':flair', $flair, PDO::PARAM_STR);
        return $insert->execute();
    }

    // Get the flair associated with this user
    public function getUserFlair($username)
    {
        $select = $this->db->prepare('select flair from flair where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // Check to see if the user is subscribed to any teams, return a boolean
    public function subscribed($username) 
    {
        $select = $this->db->prepare('select count(*) from groupmembers where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        
        $result = $select->fetch(PDO::FETCH_ASSOC);
        $count = $result[0];
        
        return ($count>0);
    }
    
    // Subscribe a user to a team
    public function addUserTeams($username, $group) 
    {
        $groupname = $group['group_name'];
        $status = $group['status'];
        $user = $group['user'];

        $insert = $this->db->prepare('insert into groupmembers(group_name,username,status,user) 
                                    values(:groupname,:username,:status,:user)');
        $insert->bindParam(':username', $username, PDO::PARAM_STR);
        $insert->bindParam(':groupname', $groupname, PDO::PARAM_STR);
        $insert->bindParam(':status', $status, PDO::PARAM_STR);
        $insert->bindParam(':user', $user, PDO::PARAM_STR);
        return $insert->execute();
    }

    // Update a users password in the database
    public function updateUserTeams($username, $group) 
    {
        $groupname = $group['group_name'];
        $status = $group['status'];
        $user = $group['user'];

        $update = $this->db->prepare('update groupmembers set status=:status, user=:user 
                                    where username=:username and group_name=:groupname');
        $update->bindParam(':username', $username, PDO::PARAM_STR);
        $update->bindParam(':groupname', $groupname, PDO::PARAM_STR);
        $update->bindParam(':status', $status, PDO::PARAM_STR);
        $update->bindParam(':user', $user, PDO::PARAM_STR);
        $update->execute();
        return $update;
    }

    // Unsubscribe a user to a team
    public function removeUserTeams($username, $groupname) 
    {
        $delete = $this->db->prepare('delete from groupmembers where username=:username and group_name=:groupname');
        $delete->bindParam(':username', $username, PDO::PARAM_STR);
        $delete->bindParam(':groupname', $groupname, PDO::PARAM_STR);
        return $delete->execute();
    }

    // Get all the teams a user is subscribed to
    public function getUserTeams($username) 
    {
        $select = $this->db->prepare('select groupmembers.group_name,group_title,status,user from groupmembers inner join groups on 
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
                if ($oldteam['group_name'] == $newteam['group_name']) {
                    $found = true;

                    // Check if the status has been updated
                    if ($oldteam['status'] != $newteam['status']) {
                        error_log(self::LOG_TAG . "Updating Group: " . $newteam['group_name'] . " For User: " . $username);
                        $updated = $this->updateUserTeams($username, $newteam);

                        if (!$updated) {
                            error_log(self::LOG_TAG . "FAILED to Update Team: " . $oldteam['group_name']);
                            return false;
                        }
                    }

                    break;
                }
            }

            // If the team is in the oldteams array but not in the newteams array, remove it
            if (!$found) {
                error_log(self::LOG_TAG . "Removing Group: " . $oldteam['group_name'] . " For User: " . $username);
                $removed = $this->removeUserTeams($username, $oldteam['group_name']);

                if (!$removed) {
                    error_log(self::LOG_TAG . "FAILED to Remove Team: " . $oldteam['group_name']);
                    return false;
                }
            }
        }

        // Second add any teams that are newly associated with this user
        foreach ($newteams as $newteam) {
            $found = false;
            foreach ($oldteams as $oldteam) {
                if ($oldteam['group_name'] == $newteam['group_name']) {
                    $found = true;
                    break;
                }
            }

            // If the team is not in the oldteams array but is in the newteams array, add it
            if (!$found) {
                error_log(self::LOG_TAG . "Adding Group: " . $newteam['group_name'] . " For User: " . $username);
                $added = $this->addUserTeams($username, $newteam);

                if (!$added) {
                    error_log(self::LOG_TAG . "FAILED to Add Team: " . $newteam['group_name']);
                    return false;
                }
            }
        }

        return true;
    }

    //****************************************************
    //  NOTIFICATIONS
    //****************************************************

    // Get all the notifications
    public function getNotifications()
    {
        $select = $this->db->prepare('select * from notifications');
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get the notifications from the past two weeks for this user
    public function getUserNotifications($username)
    {
        $select = $this->db->prepare('select * from notifications where 
                                    username=:username and time >= curdate() - interval 
                                    dayofweek(curdate()) + 13 day');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Add a notification to the database, return its notification_id
    public function addNotification($notification)
    {
        date_default_timezone_set('America/New_York');
        $time = date('Y-m-d H:i:s');
        $insert = $this->db->prepare('insert into notifications(username,time,link,description)
                                        values(:username,:time,:link,:description)');
        $insert->bindParam(':username', $notification['username'], PDO::PARAM_STR);
        $insert->bindParam(':time', $time, PDO::PARAM_STR);
        $insert->bindParam(':link', $notification['link'], PDO::PARAM_STR);
        $insert->bindParam(':description', $notification['description'], PDO::PARAM_STR);
        $insert->execute();

        if ($insert) {
            return $this->db->lastInsertId();
        } else {
            return $insert;
        }
    }

    // Delete a notification from the database
    public function deleteNotification($notificationid)
    {
        $delete = $this->db->prepare('delete from notifications where notification_id=:notificationid');
        $delete->bindParam(':notificationid', $notificationid, PDO::PARAM_INT);
        return $delete->execute();
    }

    //****************************************************
    //  MESSAGES
    //****************************************************

    // Add a message to the database, return its message_id
    public function addMessage($message)
    {
        date_default_timezone_set('America/New_York');
        $time = date('Y-m-d H:i:s');
        $insert = $this->db->prepare('insert into messages(username,first,last,group_name,time,content) 
                                        values(:username,:first,:last,:group_name,:time,:content);');
        $insert->bindParam(':username', $message['username'], PDO::PARAM_STR);
        $insert->bindParam(':first', $message['first'], PDO::PARAM_STR);
        $insert->bindParam(':last', $message['last'], PDO::PARAM_STR);
        $insert->bindParam(':group_name', $message['group_name'], PDO::PARAM_STR);
        $insert->bindParam(':time', $time, PDO::PARAM_STR);
        $insert->bindParam(':content', $message['content'], PDO::PARAM_STR);
        $insert->execute();

        if ($insert) {
            return $this->db->lastInsertId();
        } else {
            return $insert;
        }
    }

    // Update a message in the database
    public function updateMessage($oldmessage, $newmessage) {
        // Make sure that the old and new message have the same message_id before updating
        if ($oldmessage['message_id'] == $newmessage['message_id']) {
            $update = $this->db->prepare('update messages set content=:content where message_id=:message_id');
            $update->bindParam(':content', $newmessage['content'], PDO::PARAM_STR);
            $update->bindParam(':message_id', $newmessage['message_id'], PDO::PARAM_INT);
            $update->execute();
            return $update;
        } else {
            return false;
        }
    }

    // Delete a message from the database 
    public function deleteMessage($messageid)
    {
        $delete = $this->db->prepare('delete from messages where message_id=:messageid');
        $delete->bindParam(':messageid', $messageid, PDO::PARAM_INT);
        return $delete->execute();
    }

    // Get all of the messages
    public function getMessages() 
    {
        $select = $this->db->prepare('select * from messages order by date');
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get a specific message by its id number
    public function getMessageById($id) 
    {
        $select = $this->db->prepare('select * from messages where message_id=:id');
        $select->bindParam(':id', $id, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get a feed of messages from a certain group
    public function getGroupMessageFeed($sortparam, $limit, $offset)
    {
        $select = $this->db->prepare('select * from messages where group_name=:groupname order by time
                                    desc limit :limit offset :offset');
        $select->bindParam(':groupname', $sortparam, PDO::PARAM_STR);
        $select->bindParam(':limit', $limit, PDO::PARAM_INT);
        $select->bindParam(':offset', $offset, PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get a feed of messages from a certain user
    public function getUserMessageFeed($sortparam, $limit, $offset)
    {
        $select = $this->db->prepare('select * from messages where username=:username order by time
                                    desc limit :limit offset :offset');
        $select->bindParam(':username', $sortparam, PDO::PARAM_STR);
        $select->bindParam(':limit', $limit, PDO::PARAM_INT);
        $select->bindParam(':offset', $offset, PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //****************************************************
    //  EXERCISE LOGS
    //****************************************************

    // Add a new log to the database, takes an array of log information as a parameter
    public function addLog($log)
    {
        date_default_timezone_set('America/New_York');
        $time = date('Y-m-d H:i:s');
        $insert = $this->db->prepare('insert into logs(username,first,last,name,location,date,type,
                                        distance,metric,miles,time,pace,feel,description,time_created) 
                                        values(:username,:first,:last,:name,:location,:date,:type,
                                        :distance,:metric,:miles,:time,:pace,:feel,:description,:time_created);');
        $insert->bindParam(':username', $log['username'], PDO::PARAM_STR);
        $insert->bindParam(':first', $log['first'], PDO::PARAM_STR);
        $insert->bindParam(':last', $log['last'], PDO::PARAM_STR);
        $insert->bindParam(':name', $log['name'], PDO::PARAM_STR);
        $insert->bindParam(':location', $log['location'], PDO::PARAM_STR);
        $insert->bindParam(':date', $log['date'], PDO::PARAM_STR);
        $insert->bindParam(':type', $log['type'], PDO::PARAM_STR);
        $insert->bindParam(':distance', $log['distance'], PDO::PARAM_STR);
        $insert->bindParam(':metric', $log['metric'], PDO::PARAM_STR);
        $insert->bindParam(':miles', $log['miles'], PDO::PARAM_STR);
        $insert->bindParam(':time', $log['time'], PDO::PARAM_STR);
        $insert->bindParam(':pace', $log['pace'], PDO::PARAM_STR);
        $insert->bindParam(':feel', $log['feel'], PDO::PARAM_INT);
        $insert->bindParam(':description', $log['description'], PDO::PARAM_STR);
        $insert->bindParam(':time_created', $time, PDO::PARAM_STR);
        $insert->execute();

        if ($insert) {
            return $this->db->lastInsertId();
        } else {
            return $insert;
        }
    }

    // Update a log in the database
    public function updateLog($oldlog, $newlog) {
        // Make sure that the old and new log have the same log_id and username before updating
        if ($oldlog['log_id'] == $newlog['log_id']) {
            $update = $this->db->prepare('update logs set name=:name, location=:location, date=:date, type=:type, 
                                            distance=:distance, metric=:metric, miles=:miles, time=:time, pace=:pace,
                                            feel=:feel, description=:description where log_id=:log_id');
            $update->bindParam(':name', $newlog['name'], PDO::PARAM_STR);
            $update->bindParam(':location', $newlog['location'], PDO::PARAM_STR);
            $update->bindParam(':date', $newlog['date'], PDO::PARAM_STR);
            $update->bindParam(':type', $newlog['type'], PDO::PARAM_STR);
            $update->bindParam(':distance', $newlog['distance'], PDO::PARAM_STR);
            $update->bindParam(':metric', $newlog['metric'], PDO::PARAM_STR);
            $update->bindParam(':miles', $newlog['miles'], PDO::PARAM_STR);
            $update->bindParam(':time', $newlog['time'], PDO::PARAM_STR);
            $update->bindParam(':pace', $newlog['pace'], PDO::PARAM_STR);
            $update->bindParam(':feel', $newlog['feel'], PDO::PARAM_INT);
            $update->bindParam(':description', $newlog['description'], PDO::PARAM_STR);
            $update->bindParam(':log_id', $newlog['log_id'], PDO::PARAM_INT);
            $update->execute();
            return $update;
        } else {
            return false;
        }
    }

    // Delete a log with a given log_no from the database
    public function deleteLog($logid) 
    {
        $delete = $this->db->prepare('delete from logs where log_id=:logid');
        $delete->bindParam(':logid', $logid, PDO::PARAM_INT);
        return $delete->execute();
    }

    // Get all of the running logs
    public function getLogs() 
    {
        $select = $this->db->prepare('select * from logs order by date');
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get a specific running log by its id number
    public function getLogById($id) 
    {
        $select = $this->db->prepare('select * from logs where log_id=:id');
        $select->bindParam(':id', $id, PDO::PARAM_STR);
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

    // Get a feed of logs from group members
    public function getGroupLogFeed($sortparam, $limit, $offset) 
    {
        $select = $this->db->prepare('select log_id,logs.username,first,last,name,location,date,type,distance,metric,miles,
                                    time,pace,feel,description from logs inner join groupmembers on 
                                    logs.username=groupmembers.username where group_name=:groupname and status=\'accepted\' order by date
                                    desc, log_id desc limit :limit offset :offset');
        $select->bindParam(':groupname', $sortparam, PDO::PARAM_STR);
        $select->bindParam(':limit', $limit, PDO::PARAM_INT);
        $select->bindParam(':offset', $offset, PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get a feed of logs from specific users
    public function getUserLogFeed($sortparam, $limit, $offset) 
    {
        $select = $this->db->prepare('select * from logs where username=:username order by date desc
                                    limit :limit offset :offset');
        $select->bindParam(':username', $sortparam, PDO::PARAM_STR);
        $select->bindParam(':limit', $limit, PDO::PARAM_INT);
        $select->bindParam(':offset', $offset, PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get a feed of all logs
    public function getLogFeed($limit, $offset) 
    {
        $select = $this->db->prepare('select * from logs order by date desc, log_id desc limit :limit offset :offset');
        $select->bindParam(':limit', $limit, PDO::PARAM_INT);
        $select->bindParam(':offset', $offset, PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //****************************************************
    //  RANGE VIEW
    //****************************************************

    // Get a range view from group members
    public function getGroupRangeView($sortparam, $start, $end) 
    {
        $select = $this->db->prepare('select date, sum(miles) as miles, cast(avg(feel) as unsigned) as feel from logs 
                                    inner join groupmembers on logs.username=groupmembers.username where group_name=:groupname 
                                    and date >= :start and date <= :end group by date');
        $select->bindParam(':groupname', $sortparam, PDO::PARAM_STR);
        $select->bindParam(':start', $start, PDO::PARAM_INT);
        $select->bindParam(':end', $end, PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get a range view from specific users
    public function getUserRangeView($sortparam, $start, $end) 
    {
        error_log(self::LOG_TAG . "User: " . $sortparam);
        error_log(self::LOG_TAG . "Start: " . $start);
        error_log(self::LOG_TAG . "End: " . $end);
        $select = $this->db->prepare('select date, sum(miles) as miles, cast(avg(feel) as unsigned) as feel from logs 
                                    where username=:username and date >= :start and date <= :end group by date');
        $select->bindParam(':username', $sortparam, PDO::PARAM_STR);
        $select->bindParam(':start', $start, PDO::PARAM_STR);
        $select->bindParam(':end', $end, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get a range view for everyone
    public function getRangeView($start, $end) 
    {
        $select = $this->db->prepare('select date, sum(miles) as miles, cast(avg(feel) as unsigned) as feel from logs 
                                    where date >= :start and date <= :end group by date');
        $select->bindParam(':start', $start, PDO::PARAM_INT);
        $select->bindParam(':end', $end, PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //****************************************************
    //  COMMENTS
    //****************************************************

    // Get all of the comments from the database
    public function getAllComments()
    {
        $select = $this->db->prepare('select * from comments');
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get a single comment from the database
    public function getComment($commentid)
    {
        $select = $this->db->prepare('select * from comments where comment_id=:commentid');
        $select->bindParam(':commentid', $commentid, PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get all the comments on a specific log in the database
    public function getComments($logid)
    {
        $select = $this->db->prepare('select * from comments where log_id=:logid order by time desc');
        $select->bindParam(':logid', $logid, PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Add a comment to the database
    public function addComment($comment)
    {
        date_default_timezone_set('America/New_York');
        $time = date('Y-m-d H:i:s');
        $insert = $this->db->prepare('insert into comments(log_id,content,time,username,first,last)
                                     values(:logid,:content,:time,:username,:first,:last)');
        $insert->bindParam(':logid', $comment['log_id'], PDO::PARAM_INT);
        $insert->bindParam(':content', $comment['content'], PDO::PARAM_STR);
        $insert->bindParam(':time', $time, PDO::PARAM_STR);
        $insert->bindParam(':username', $comment['username'], PDO::PARAM_STR);
        $insert->bindParam(':first', $comment['first'], PDO::PARAM_STR);
        $insert->bindParam(':last', $comment['last'], PDO::PARAM_STR);
        $insert->execute();

        // Return back the id of the comment submitted
        if ($insert) {
            return $this->db->lastInsertId();
        } else {
            return $insert;
        }
    }

    // Update a comment in the database
    public function updateComment($oldcomment, $newcomment) {
        // Make sure that the old and new log have the same log_id and username before updating
        if ($oldcomment['log_id'] == $newcomment['log_id'] && $oldcomment['username'] == $newcomment['username']) {
            $time = date('Y-m-d H:i:s');
            $update = $this->db->prepare('update comments set time=:time, content=:content where comment_id=:comment_id');
            $update->bindParam(':time', $time, PDO::PARAM_STR);
            $update->bindParam(':content', $newlog['content'], PDO::PARAM_STR);
            $update->bindParam(':comment_id', $newlog['comment_id'], PDO::PARAM_INT);
            $update->execute();
            return $update;
        } else {
            return false;
        }
    }

    // Delete a comment with a given comment_id from the database
    public function deleteComment($commentid) 
    {
        $delete = $this->db->prepare('delete from comments where comment_id=:commentid');
        $delete->bindParam(':commentid', $commentid, PDO::PARAM_INT);
        return $delete->execute();
    }

    // Delete a comment on a specific log from the database
    public function deleteLogComments($logid) 
    {
        $delete = $this->db->prepare('delete from comments where log_id=:logid');
        $delete->bindParam(':logid', $logid, PDO::PARAM_INT);
        return $delete->execute();
    }

    //****************************************************
    //  TEAMS/GROUPS
    //****************************************************

    // Get all the teams in the database
    public function getTeams() 
    {
        $select = $this->db->prepare('select * from groups');
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get a team from the database
    public function getTeam($teamname) 
    {
        $select = $this->db->prepare('select * from groups where group_name=:teamname');
        $select->bindParam(':teamname', $teamname, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Update a teams info in the database
    public function updateTeam($oldteam, $newteam) {
        // Make sure that the old and new group have the same name and title before updating
        if ($oldteam['group_name'] == $newteam['group_name'] && $oldteam['group_title'] == $newteam['group_title']) {
            $update = $this->db->prepare('update groups set grouppic=:grouppic, grouppic_name=:grouppic_name, 
                                            description=:description, week_start:=:week_start where group_name=:group_name');
            $update->bindParam(':grouppic', $newteam['grouppic'], PDO::PARAM_LOB);
            $update->bindParam(':grouppic_name', $newteam['grouppic_name'], PDO::PARAM_STR);
            $update->bindParam(':description', $newteam['description'], PDO::PARAM_STR);
            $update->bindParam(':group_name', $newteam['group_name'], PDO::PARAM_STR);
            $update->bindParam(':week_start', $newteam['week_start'], PDO::PARAM_STR);
            $update->execute();
            return $update;
        } else {
            return false;
        }
    }

    // Get a specific teams members in the database
    public function getTeamMembers($team) 
    {
        $select = $this->db->prepare('select users.username,first,last,member_since,user,status from groupmembers inner join groups 
                                        on groups.group_name=groupmembers.group_name inner join users on 
                                        groupmembers.username=users.username where groupmembers.group_name=:team');
        $select->bindParam(':team', $team, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get all the teams and their members in the database
    public function getAllTeamMembers() 
    {
        $select = $this->db->prepare('select groupmembers.group_name, username from groupmembers inner join groups on 
                                    groups.group_name=groupmembers.group_name');
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //****************************************************
    //  STATISTICS
    //****************************************************

    // Get the total miles that a user has exercised
    public function getUserMiles($username) 
    {
        $select = $this->db->prepare('select sum(miles) as total from logs where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        
        $miles = $result['total'];

        if (isset($miles)) {
            return round($miles, 2);
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
            return round($miles, 2);
        } else {
            return 0;
        }
    }

    // Get the total miles that a user had exercised over a given interval of time
    public function getUserMilesInterval($username, $interval, $week_start = 'monday') 
    {
        if ($interval === 'year') {
            $date = APIUtils::firstDayOfYear();
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and date >= :date');
        } elseif ($interval === 'month') {
            $date = APIUtils::firstDayOfMonth();
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and date >= :date');
        } elseif ($interval === 'week') {
            $date = APIUtils::firstDayOfWeek($week_start);
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and date >= :date');
        } else {
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username');
        }
        
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->bindParam(':date', $date, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        $miles = $result['total'];

        if (isset($miles)) {
            return round($miles, 2);
        } else {
            return 0;
        }
    }

    // Get the total miles that a user had exercised over a given interval of time for a specific exercise
    public function getUserMilesExerciseInterval($username, $interval, $exercise, $week_start = 'monday') 
    {
        if ($interval === 'year') {
            $date = APIUtils::firstDayOfYear();
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and type=:exercise and date >= :date');
        } elseif ($interval === 'month') {
            $date = APIUtils::firstDayOfMonth();
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and type=:exercise and date >= :date');
        } elseif ($interval === 'week') {
            $date = APIUtils::firstDayOfWeek($week_start);
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and type=:exercise and date >= :date');
        } else {
            $select = $this->db->prepare('select sum(miles) as total from logs where username=:username 
                and type=:exercise');
        }
        
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->bindParam(':exercise', $exercise, PDO::PARAM_STR);
        $select->bindParam(':date', $date, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        $miles = $result['total'];

        if (isset($miles)) {
            return round($miles, 2);
        } else {
            return 0;
        }
    }

    // Get the total miles that a team has exercised
    public function getTeamMiles($team) 
    {
        $select = $this->db->prepare('select sum(miles) as total from logs inner join groupmembers on 
                                    logs.username = groupmembers.username where group_name=:team 
                                    and status=\'accepted\'');
        $select->bindParam(':team', $team, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        
        $miles = $result['total'];

        if (isset($miles)) {
            return round($miles, 2);
        } else {
            return 0;
        }
    }

    // Get the total miles that a team has exercised for a specific exercise
    public function getTeamMilesExercise($team, $exercise)
    {
        $select = $this->db->prepare('select sum(miles) as total from logs inner join groupmembers on 
                                    logs.username = groupmembers.username where group_name=:team 
                                    and type=:exercise and status=\'accepted\'');
        $select->bindParam(':team', $team, PDO::PARAM_STR);
        $select->bindParam(':exercise', $exercise, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        
        $miles = $result['total'];

        if (isset($miles)) {
            return round($miles, 2);
        } else {
            return 0;
        }
    }

    // Get the total miles that a team had exercised over a given interval of time
    public function getTeamMilesInterval($team, $interval, $week_start = 'monday') 
    {
        if ($interval === 'year') {
            $date = APIUtils::firstDayOfYear();
            $select = $this->db->prepare('select sum(miles) as total from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team 
                                            and date >= :date and status=\'accepted\'');
        } elseif ($interval === 'month') {
            $date = APIUtils::firstDayOfMonth();
            $select = $this->db->prepare('select sum(miles) as total from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team 
                                            and date >= :date and status=\'accepted\'');
        } elseif ($interval === 'week') {
            $date = APIUtils::firstDayOfWeek($week_start);
            $select = $this->db->prepare('select sum(miles) as total from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team 
                                            and date >= :date and status=\'accepted\'');
        } else {
            $select = $this->db->prepare('select sum(miles) as total from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team 
                                            and status=\'accepted\'');
        }
        
        $select->bindParam(':team', $team, PDO::PARAM_STR);
        $select->bindParam(':date', $date, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        $miles = $result['total'];

        if (isset($miles)) {
            return round($miles, 2);
        } else {
            return 0;
        }
    }

    // Get the total miles that a team had exercised over a given interval of time for a specific exercise
    public function getTeamMilesExerciseInterval($team, $exercise, $interval, $week_start = 'monday')
    {
        if ($interval === 'year') {
            $date = APIUtils::firstDayOfYear();
            $select = $this->db->prepare('select sum(miles) as total from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team
                                            and type=:exercise and date >= :date and status=\'accepted\'');
        } elseif ($interval === 'month') {
            $date = APIUtils::firstDayOfMonth();
            $select = $this->db->prepare('select sum(miles) as total from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team 
                                            and type=:exercise and date >= :date and status=\'accepted\'');
        } elseif ($interval === 'week') {
            $date = APIUtils::firstDayOfWeek($week_start);
            $select = $this->db->prepare('select sum(miles) as total from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team 
                                            and type=:exercise and date >= :date and status=\'accepted\'');
        } else {
            $select = $this->db->prepare('select sum(miles) as total from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team and 
                                            type=:exercise and status=\'accepted\'');
        }
        
        $select->bindParam(':team', $team, PDO::PARAM_STR);
        $select->bindParam(':exercise', $exercise, PDO::PARAM_STR);
        $select->bindParam(':date', $date, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        $miles = $result['total'];

        if (isset($miles)) {
            return round($miles, 2);
        } else {
            return 0;
        }
    }

    // Get the all time average body feel for a user
    public function getUserAvgFeel($username) 
    {
        $select = $this->db->prepare('select avg(feel) as average from logs where username=:username');
        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        
        $feel = $result['average'];

        if (isset($feel)) {
            return round($feel, 1);
        } else {
            return 0;
        }
    }

    // Get the average body feel for a user during a specific interval
    public function getUserAvgFeelInterval($username, $interval, $week_start = 'monday') 
    {
        if ($interval === 'year') {
            $date = APIUtils::firstDayOfYear();
            $select = $this->db->prepare('select avg(feel) as average from logs where username=:username 
                and date >= :date');
        } elseif ($interval === 'month') {
            $date = APIUtils::firstDayOfMonth();
            $select = $this->db->prepare('select avg(feel) as average from logs where username=:username 
                and date >= :date');
        } elseif ($interval === 'week') {
            $date = APIUtils::firstDayOfWeek($week_start);
            $select = $this->db->prepare('select avg(feel) as average from logs where username=:username 
                and date >= :date');
        } else {
            $select = $this->db->prepare('select avg(feel) as average from logs where username=:username');
        }

        $select->bindParam(':username', $username, PDO::PARAM_STR);
        $select->bindParam(':date', $date, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        
        $feel = $result['average'];

        if (isset($feel)) {
            return round($feel, 1);
        } else {
            return 0;
        }
    }

    // Get the all time average body feel for a team
    public function getTeamAvgFeel($team) 
    {
        $select = $this->db->prepare('select avg(feel) as average from logs inner join groupmembers on 
                                    logs.username = groupmembers.username where group_name=:team 
                                    and status=\'accepted\'');
        $select->bindParam(':team', $team, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        
        $feel = $result['average'];

        if (isset($feel)) {
            return round($feel, 1);
        } else {
            return 0;
        }
    }

    // Get the average body feel for a team during a specific interval
    public function getTeamAvgFeelInterval($team, $interval, $week_start = 'monday')
    {
        if ($interval === 'year') {
            $date = APIUtils::firstDayOfYear();
            $select = $this->db->prepare('select avg(feel) as average from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team 
                                            and date >= :date and status=\'accepted\'');
        } elseif ($interval === 'month') {
            $date = APIUtils::firstDayOfMonth();
            $select = $this->db->prepare('select avg(feel) as average from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team 
                                            and date >= :date and status=\'accepted\'');
        } elseif ($interval === 'week') {
            $date = APIUtils::firstDayOfWeek($week_start);
            $select = $this->db->prepare('select avg(feel) as average from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team 
                                            and date >= :date and status=\'accepted\'');
        } else {
            $select = $this->db->prepare('select avg(feel) as average from logs inner join groupmembers on 
                                            logs.username = groupmembers.username where group_name=:team 
                                            and status=\'accepted\'');
        }
        
        $select->bindParam(':team', $team, PDO::PARAM_STR);
        $select->bindParam(':date', $date, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        $feel = $result['average'];

        if (isset($feel)) {
            return round($feel, 1);
        } else {
            return 0;
        }
    }

    // Get the leaders with the most total miles on the team
    public function getTeamLeadersMiles($team) 
    {
        $select = $this->db->prepare('select groupmembers.username,first,last,sum(miles) as miles from logs inner join 
                                        groupmembers on logs.username = groupmembers.username where group_name=:team 
                                        and status=\'accepted\' and type=\'run\' group by groupmembers.username order by miles desc limit 10');
        $select->bindParam(':team', $team, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get the total miles that a team had exercised over a given interval of time
    public function getTeamLeadersMilesInterval($team, $interval, $week_start = 'monday') 
    {
        if ($interval === 'year') {
            $date = APIUtils::firstDayOfYear();
            $select = $this->db->prepare('select groupmembers.username,first,last,sum(miles) as miles from logs inner join 
                                        groupmembers on logs.username = groupmembers.username where group_name=:team 
                                        and date >= :date and status=\'accepted\' and type=\'run\' group by groupmembers.username 
                                        order by miles desc limit 10');
        } elseif ($interval === 'month') {
            $date = APIUtils::firstDayOfMonth();
            $select = $this->db->prepare('select groupmembers.username,first,last,sum(miles) as miles from logs inner join 
                                        groupmembers on logs.username = groupmembers.username where group_name=:team 
                                        and date >= :date and status=\'accepted\' and type=\'run\' group by groupmembers.username 
                                        order by miles desc limit 10');
        } elseif ($interval === 'week') {
            $date = APIUtils::firstDayOfWeek($week_start);
            $select = $this->db->prepare('select groupmembers.username,first,last,sum(miles) as miles from logs inner join 
                                        groupmembers on logs.username = groupmembers.username where group_name=:team 
                                        and date >= :date and status=\'accepted\' and type=\'run\' group by groupmembers.username 
                                        order by miles desc limit 10');
        } else {
            $select = $this->db->prepare('select groupmembers.username,first,last,sum(miles) as miles from logs inner join 
                                        groupmembers on logs.username = groupmembers.username where group_name=:team 
                                        and status=\'accepted\' and type=\'run\' group by groupmembers.username order by miles desc limit 10');
        }
        
        $select->bindParam(':team', $team, PDO::PARAM_STR);
        $select->bindParam(':date', $date, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Return the date of the newest log for a particular team
    public function getTeamNewestLogDate($team)
    {
        $select = $this->db->prepare('select max(time_created) as newest from logs inner join groupmembers on 
                                        logs.username = groupmembers.username where group_name=:team and status=\'accepted\'');
        $select->bindParam(':team', $team, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        
        $newest = $result['newest'];
        if ($newest == null) {
            return "0000-00-00 00:00:00";
        } else {
            return $newest;
        }
    }

    // Return the date of the newest message for a particular team
    public function getTeamNewestMessageDate($team)
    {
        $select = $this->db->prepare('select max(time) as newest from messages where group_name=:team');
        $select->bindParam(':team', $team, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        $newest = $result['newest'];
        if ($newest == null) {
            return "0000-00-00 00:00:00";
        } else {
            return $newest;
        }
    }
}