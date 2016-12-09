<!DOCTYPE html>

<!--
Author: Andrew Jarombek
Date: 5/23/2016 - 
Header HTML Code
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
        		if (window.location.pathname != '/saints-xctf/index.php')
        			window.location = "index.php";
        	</script>
    	<?php endif; ?>
    </head>

