/*
 * Author: Andrew Jarombek
 * Date: 12/8/2016 - 6/2/2017
 * JavaScript for interacting with the group page
 * Version 0.4 (BETA) - 12/24/2016
 * Version 1.0 (OFFICIAL RELEASE) - 6/2/2017
 */

$(document).ready(function() {

    // when the user clicks on edit group, go to editgroup.php
    $('#edit_profile').on("click", function() {
    	var groupname = get('name');
    	
        window.location = 'editgroup.php?name=' + groupname;
    });
    
});