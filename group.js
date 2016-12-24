/*
 * Author: Andrew Jarombek
 * Date: 12/8/2016 - 12/24/2016
 * JavaScript for interacting with the group page
 * Version 0.4 (BETA) - 12/24/2016
 */

$(document).ready(function() {

    // when the user clicks on edit group, go to editgroup.php
    $('#edit_profile').on("click", function() {
        window.location = 'editgroup.php';
    });
    
});