/*
 * Author: Andrew Jarombek
 * Date: 3/13/2017
 * JavaScript for interacting with the user panels
 */

$(document).ready(function() {

	var logs = true;
	var weekly = false;
	var monthly = false;
    var calendarGenerated = false;
    var weeklyViewGenerated = false;

    // when the user clicks on the panels, display it and remove the current panel
    $('#panelslistlogs').on("click", function() {

    	// Switch Panels if this isnt the active panel
        if (!logs) {
        	disablePanel();
        	$('#panelslistlogs').removeClass('inactivepanelslist');
        	$('#panelslistlogs').addClass('activepanelslist');
        	$('#activityfeed').addClass('activepanel');
        	$('#activityfeed').removeClass('inactivepanel');
            $('#activityinput').addClass('activepanel');
            $('#activityinput').removeClass('inactivepanel');
        	logs = true;
        }
    });

    $('#panelslistmonthly').on("click", function() {

    	// Switch Panels if this isnt the active panel
        if (!monthly) {
        	disablePanel();
        	$('#panelslistmonthly').removeClass('inactivepanelslist');
        	$('#panelslistmonthly').addClass('activepanelslist');
        	$('#monthlycalendar').addClass('activepanel');
        	$('#monthlycalendar').removeClass('inactivepanel');

            if (calendarGenerated == false) {
                // Get up a calendar format for a given month
                calendarGenerated = true;
                generateCalendar(Date.today());
            }
        	monthly = true;
        }
    });

    $('#panelslistweekly').on("click", function() {

    	// Switch Panels if this isnt the active panel
        if (!weekly) {
        	disablePanel();
        	$('#panelslistweekly').removeClass('inactivepanelslist');
        	$('#panelslistweekly').addClass('activepanelslist');
        	$('#weeklygraph').addClass('activepanel');
        	$('#weeklygraph').removeClass('inactivepanel');
            
            if (weeklyViewGenerated == false) {
                // Set up weekly view format for given week
                weeklyViewGenerated = true;
                generateWeeklyView(Date.today());
            }
        	weekly = true;
        }
    });

    function disablePanel() {
    	if (logs) {
    		disable('#panelslistlogs');
    		removeDisplay('#activityfeed');
            removeDisplay('#activityinput');
    		logs = false;
    	} else if (monthly) {
    		disable('#panelslistmonthly');
    		removeDisplay('#monthlycalendar');
    		monthly = false;
    	} else if (weekly) {
    		disable('#panelslistweekly');
    		removeDisplay('#weeklygraph');
    		weekly = false;
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