<!DOCTYPE html>

<!--
Author: Andrew Jarombek
Date: 5/23/2016 - 1/18/2017
Header HTML Code
Version 0.4 (BETA) - 12/24/2016
Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
-->

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SaintsXCTF</title>
        <link rel="stylesheet" href="views/style.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto:500,700,400' rel='stylesheet' type='text/css'>
        <?php if (!isset($_SESSION['username'])): ?>
        	<script>
                // Debug = False means final version, True means localhost version
                var debug = true;

                // Check if this is the final website version or not
                if (debug) {
            		if (window.location.pathname != '/saints-xctf/index.php' && 
                        window.location.pathname != '/saints-xctf/forgotpassword.php')
            			window.location = "index.php";
                } else {
                    if (window.location.pathname != '/index.php' && 
                        window.location.pathname != '/forgotpassword.php')
                        window.location = "index.php";
                }
        	</script>
        <?php else: ?>
            <input id="session_username" type="hidden" value=<?php echo "\"" . $_SESSION['username'] . "\"";?>>
    	<?php endif; ?>
    </head>

