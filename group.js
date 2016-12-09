/*
 * Author: Andrew Jarombek
 * Date: 12/8/2016 - 
 * JavaScript for interacting with the group page
 */

$(document).ready(function() {

    // when the user clicks on edit group, go to editgroup.php
    $('#edit_profile').on("click", function() {
        window.location = 'editgroup.php';
    });
    
});