/*
 * Author: Andrew Jarombek
 * Date: 2/16/2017 - 2/20/2017
 * JavaScript for interacting with the group panels
 * Version 0.6 (GROUPS UPDATE) - 2/20/2017
 */

$(document).ready(function() {

	var logs = true;
	var leaderboards = false;
	var messages = false;
	var members = false;
	var admin = false;

    var mygroup = false;

    if ($('#mygroup').val() == 'true') {
        mygroup = true;
    }

    // when the user clicks on the panels, display it and remove the current panel
    $('#panelslistlogs').on("click", function() {

    	// Switch Panels if this isnt the active panel
        if (!logs) {
        	disablePanel();
        	$('#panelslistlogs').removeClass('inactivepanelslist');
        	$('#panelslistlogs').addClass('activepanelslist');
        	$('#activityfeed').addClass('activepanel');
        	$('#activityfeed').removeClass('inactivepanel');
        	logs = true;
        }
    });

    $('#panelslistleaderboards').on("click", function() {

    	// Switch Panels if this isnt the active panel
        if (!leaderboards) {
        	disablePanel();
        	$('#panelslistleaderboards').removeClass('inactivepanelslist');
        	$('#panelslistleaderboards').addClass('activepanelslist');
        	$('#leaderboards').addClass('activepanel');
        	$('#leaderboards').removeClass('inactivepanel');
        	leaderboards = true;
        }
    });

    $('#panelslistmessageboard').on("click", function() {

    	// Switch Panels if this isnt the active panel
        if (!messages && mygroup) {
        	disablePanel();
        	$('#panelslistmessageboard').removeClass('inactivepanelslist');
        	$('#panelslistmessageboard').addClass('activepanelslist');
        	$('#messageboard').addClass('activepanel');
        	$('#messageboard').removeClass('inactivepanel');
        	messages = true;

            group = get('name');
            $('#panelslistmessageboard').html('').append('MESSAGE BOARD');
            $('#panelslistmessageboard').css('padding-left', '16px');
            $('#panelslistmessageboard').css('padding-right', '16px');

            $.get('groupdetails.php', {viewedmessages : group}, function(response) {});
        }
    });

    $('#panelslistmembers').on("click", function() {

    	// Switch Panels if this isnt the active panel
        if (!members) {
        	disablePanel();
        	$('#panelslistmembers').removeClass('inactivepanelslist');
        	$('#panelslistmembers').addClass('activepanelslist');
        	$('#members').addClass('activepanel');
        	$('#members').removeClass('inactivepanel');
        	members = true;
        }
    });

    $('#panelslistadmin').on("click", function() {

    	// Switch Panels if this isnt the active panel
        if (!admin && mygroup) {
        	disablePanel();
        	$('#panelslistadmin').removeClass('inactivepanelslist');
        	$('#panelslistadmin').addClass('activepanelslist');
        	$('#admin').addClass('activepanel');
        	$('#admin').removeClass('inactivepanel');
        	admin = true;
        }
    });

    function disablePanel() {
    	if (logs) {
    		disable('#panelslistlogs');
    		removeDisplay('#activityfeed');
    		logs = false;
    	} else if (leaderboards) {
    		disable('#panelslistleaderboards');
    		removeDisplay('#leaderboards');
    		leaderboards = false;
    	} else if (messages) {
    		disable('#panelslistmessageboard');
    		removeDisplay('#messageboard');
    		messages = false;
    	} else if (members) {
    		disable('#panelslistmembers');
    		removeDisplay('#members');
    		members = false;
    	} else if (admin) {
    		disable('#panelslistadmin');
    		removeDisplay('#admin');
    		admin = false;
    	}
    }

    // Display a panel list element
    function disable(id) {
    	$(id).addClass('inactivepanelslist');
        $(id).removeClass('activepanelslist');
    }

    // Remove a panel from the display
    function removeDisplay(id) {
    	$(id).addClass('inactivepanel');
        $(id).removeClass('activepanel');
    }
    
});