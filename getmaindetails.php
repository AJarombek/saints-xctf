<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 
// Controller for Getting the details necessary for the main logged in page

// Connect to database
require_once('models/database.php');
$db = databaseConnection();

if (!isset($db)) {
    $_SESSION['message'] = "Could not connect to the database.";
} else {
    
    require_once('models/queries.php');
    $queries = new Queries($db);
    
    $logs = $queries->getLogs();
    $teams = $queries->getTeams($_SESSION['username']);
}
