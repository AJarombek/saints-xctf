/*
 * Author: Andrew Jarombek
 * Date: 6/11/2016 - 6/2/2017
 * JavaScript for the header buttons interactivity once the user is logged in
 * Version 0.4 (BETA) - 12/24/2016
 * Version 1.0 (OFFICIAL RELEASE) - 6/2/2017
 */

$(document).ready(function() {

    // On every screen resize, determine the x-position for the dropdown menu
    // Also executes on page load
    $( window ).resize(function() {
        var teams = $( "#teams" );
        var position = teams.position();
        $('#dropdiv').css('left', position.left - 80);
    }).resize();
    
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

    $('#mobilemenu i').hover(function() {
    	$('.mobile-dropdown-content').css('display', 'block');
    });

    // When you leave the signedoutmenu and you arent in the dropdownmenu, 
    // hide the team drop down menu
    $('#signedoutmenu').mouseleave(function() {
    	if (!$(".dropdown-content").is(":hover")) {
    		$('.dropdown-content').css('display', '');
    	}
        if (!$(".mobile-dropdown-content").is(":hover")) {
    		$('.mobile-dropdown-content').css('display', '');
    	}
    });

    // When you leave the dropdownmenu and you arent in the signedoutmenu, 
    // hide the team drop down menu
    $('.dropdown-content').mouseleave(function() {
    	if (!$("#signedoutmenu").is(":hover")) {
    		$('.dropdown-content').css('display', '');
    	}
    });

    // Do the same for the mobile dropdown menu
    $('.mobile-dropdown-content').mouseleave(function() {
    	if (!$("#signedoutmenu").is(":hover")) {
    		$('.mobile-dropdown-content').css('display', '');
    	}
    });

    $('#profile').on('click', function() {});

    $('#home').on('click', function() {});
});