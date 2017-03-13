<?php

// Author: Andrew Jarombek
// Date: 2/5/2017 - 2/20/2017
// Controller for Getting the details necessary for the edit log page
// Version 0.6 (GROUPS UPDATE) - 2/20/2017

session_start();

// Manual Session Timeout Handling
require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

$LOG_TAG = "[WEB](editlogdetails.php): ";

require_once('models/logclient.php');
require_once('controller_utils.php');

// Use the GET parameter to load the log
if (isset($_GET['getlog'])) {

    $logno = $_GET['getlog'];

    $logclient = new LogClient();

    $logJSON = $logclient->get($logno);
    error_log($LOG_TAG . "The Log from the API: " . $logJSON);

    echo $logJSON;
    exit();

// Update the log in the database
} else if (isset($_POST['updatelog'])) {
    
    $logJSON = $_POST['updatelog'];
    $log = json_decode($logJSON, true);

    // Get the id for the put request
    $logid = $log['log_id'];

    // We have to add miles to the log
    $metric = $log['metric'];
    $distance = $log['distance'];

    $miles = ControllerUtils::convertToMiles($distance, $metric);
    $log['miles'] = $miles;

    // We now have to get the mile pace with miles and time
    $pace = ControllerUtils::milePace($miles, $log['time']);
    $log['pace'] = $pace;

    $log['username'] = $_SESSION['username'];
    $log['first'] = $_SESSION['first'];
    $log['last'] = $_SESSION['last'];

    error_log($LOG_TAG . "The Submitted Log for Updating: " . print_r($log, true));

    $logJSON = json_encode($log);

    $logclient = new LogClient();

    $logJSON = $logclient->put($logid, $logJSON);
    error_log($LOG_TAG . "The Updated Log from the API: " . $logJSON);

    if ($logJSON != null) {
        echo "true";
    } else {
        echo "false";
    }
    exit();

} else {
    $logno = $_GET['logno'];
}
