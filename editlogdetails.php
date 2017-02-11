<?php

// Author: Andrew Jarombek
// Date: 2/5/2017 -
// Controller for Getting the details necessary for the edit log page

session_start();

$LOG_TAG = "[WEB](editlogdetails.php): ";

require_once('models/logclient.php');

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
