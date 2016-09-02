<?php

// Author: Andrew Jarombek
// Date: 8/31/2016 - 
// Controller for Getting the details necessary for the profile page

// Connect to database
require_once('models/database.php');
$db = databaseConnection();

if (!isset($db)) {
    $_SESSION['message'] = "Could not connect to the database.";
} else {
    
    require_once('models/queries.php');
    $queries = new Queries($db);

    $username = $_GET['user'];

    // The Users Running Logs
    $logs = $queries->getUserLogs($username);

    // The Users Account Information
    $details = $queries->getUserDetails($username);
    $name = $details['first'] . ' ' . $details['last'];
    $description = $details['description'];

    // The Users Miles Run History
    $alltime = $queries->getUserMilesRun($username);
    $yearly = $queries->getUserMilesRun($username, 'year');
    $monthly = $queries->getUserMilesRun($username, 'month');
    $weekly = $queries->getUserMilesRun($username, 'week');
}
