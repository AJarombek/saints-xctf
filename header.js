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

    // Display the team drop down menu when Teams is hovered over
    $('#teams a').hover(function() {
    	$('.dropdown-content').css('display', 'block');
    });

    // When you leave the signedoutmenu and you arent in the dropdownmenu, 
    // hide the team drop down menu
    $('#signedoutmenu').mouseleave(function() {
    	if (!$(".dropdown-content").is(":hover")) {
    		$('.dropdown-content').css('display', '');
    	}
    });

    // When you leave the dropdownmenu and you arent in the signedoutmenu, 
    // hide the team drop down menu
    $('.dropdown-content').mouseleave(function() {
    	if (!$("#signedoutmenu").is(":hover")) {
    		$('.dropdown-content').css('display', '');
    	}
    });

    $('#profile').on('click', function() {});

    $('#home').on('click', function() {});
});