<?php

// Author: Andrew Jarombek
// Date: 5/28/2016 - 12/24/2016
// Model for Making a Database Connection
// Version 0.4 (BETA) - 12/24/2016

// Return a PDO connection
function databaseConnection() 
{
    
    // Connection parameters
    require_once('cred.php');

    // Attempt connection
    try 
    {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // For development only
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $db;
    }
    
    // If it doesn't work
    catch (PDOException $e) 
    {
        echo $e->getMessage(); // For development only
        return NULL;
    }
}