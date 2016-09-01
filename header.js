/*
 * Author: Andrew Jarombek
 * Date: 6/11/2016 - 
 * JavaScript for the header buttons interactivity once the user is logged in
 */

$(document).ready(function() {
    
    // Sign the user out when they click on the signout header button
    $("#signout").on('click', function() {
        $.get('signout.php', function(response) {
            window.location = 'index.php';
        });
    });

    $('#teams').on('click', function() {});

    $('#profile').on('click', function() {});

    $('#home').on('click', function() {});
});