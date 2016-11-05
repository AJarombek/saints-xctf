<?php

// Author: Andrew Jarombek
// Date: 8/31/2016 - 
// Controller for Getting the details necessary for the profile page

$username = $_GET['user'];

// The Users Running Logs
$logs = null;

// The Users Account Information
$username = $_SESSION['username'];
$name = $_SESSION['first'] . " " . $_SESSION['last'];
$user = $_SESSION['user'];
$groups = $user[$username]['groups'];

// The Users Miles Run History
$statistics = $user[$username]['statistics'];
