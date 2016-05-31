<?php

// Author: Andrew Jarombek
// Date: 5/31/2016 - 
// Controller for Adding a Singed Up User

session_start();

if (isset($_POST['userDetails'])) {
    
    // Connect to database
    require_once('models/database.php');
    $db = databaseConnection();
    
    if (!isset($db)) {
        $_SESSION['message'] = "Could not connect to the database.";
    } else {
        
        require_once('models/queries.php');
        $queries = new Queries($db);
        
        $username = $_POST['userDetails'][0];
        $first = $_POST['userDetails'][1];
        $last = $_POST['userDetails'][2];
        $password = $_POST['userDetails'][3];
        
        $added = $queries->addUser($username, $first, $last, $password);
        
        echo $added;
        exit();
    }
}