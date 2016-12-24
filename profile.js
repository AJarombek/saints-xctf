/*
 * Author: Andrew Jarombek
 * Date: 11/7/2016 - 12/24/2016
 * JavaScript for interacting with the profile page
 * Version 0.4 (BETA) - 12/24/2016
 */

$(document).ready(function() {

    // when the user clicks on edit profile, go to editprofile.php
    $('#edit_profile').on("click", function() {
        window.location = 'editprofile.php';
    });
    
});