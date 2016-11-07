/*
 * Author: Andrew Jarombek
 * Date: 11/7/2016 - 
 * JavaScript for interacting with the profile page
 */

$(document).ready(function() {

    // when the user clicks on edit profile, go to editprofile.php
    $('#edit_profile').on("click", function() {
        window.location = 'editprofile.php';
    });
    
});