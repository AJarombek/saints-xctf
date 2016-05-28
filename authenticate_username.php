<?php

// Author: Andrew Jarombek
// Date: 5/28/2016 - 
// Controller for Authenticating a unique Username

session_start();

if (isset($_POST['username_auth'])) {
    
    if (!isset($db)) {
        $_SESSION['message'] = "Could not connect to the database.";
    } else {
        
        require_once('models/queries.php');
        $queries = new Queries($db);
        
        $exists = $queries->usernameExists($_POST['username_auth']);
        
        if ($exists) {
            echo json_encode($exists);
            exit();
        }
    }
}