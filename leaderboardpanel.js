/*
 * Author: Andrew Jarombek
 * Date: 2/17/2017
 * JavaScript for interacting with the leaderboard panel
 */

$(document).ready(function() {

	var alltime = true;
	var yearly = false;
	var monthly = false;
	var weekly = false;

    var groupJSON = $('#group_data').val();
    var groupdata = JSON.parse(groupJSON);
    console.info(groupdata);

    // when the user clicks on the leaderboard option, display it and remove the current leaderboard
    $('#milesalltime').on("click", function() {

    	// Switch Leaderboards if this isnt the active leaderboard
        if (!alltime) {
        	disableLeaderboard();
        	$('#milesalltime').removeClass('inactiveleaderboard');
        	$('#milesalltime').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append('<dt id="leaderboardtitle">Miles All Time</dt>');
            showLeaderboard('miles');
        	alltime = true;
        }
    });

    $('#milespastyear').on("click", function() {

        // Switch Leaderboards if this isnt the active leaderboard
        if (!yearly) {
            disableLeaderboard();
            $('#milespastyear').removeClass('inactiveleaderboard');
            $('#milespastyear').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append('<dt id="leaderboardtitle">Miles Yearly</dt>');
            showLeaderboard('milespastyear');
            yearly = true;
        }
    });

    $('#milespastmonth').on("click", function() {

        // Switch Leaderboards if this isnt the active leaderboard
        if (!monthly) {
            disableLeaderboard();
            $('#milespastmonth').removeClass('inactiveleaderboard');
            $('#milespastmonth').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append('<dt id="leaderboardtitle">Miles Monthly</dt>');
            showLeaderboard('milespastmonth');
            monthly = true;
        }
    });

    $('#milespastweek').on("click", function() {

        // Switch Leaderboards if this isnt the active leaderboard
        if (!weekly) {
            disableLeaderboard();
            $('#milespastweek').removeClass('inactiveleaderboard');
            $('#milespastweek').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append('<dt id="leaderboardtitle">Miles Weekly</dt>');
            showLeaderboard('milespastweek');
            weekly = true;
        }
    });

    function disableLeaderboard() {
    	if (alltime) {
    		disable('#milesalltime');
    		alltime = false;
    	} else if (yearly) {
    		disable('#milespastyear');
    		yearly = false;
    	} else if (monthly) {
    		disable('#milespastmonth');
    		monthly = false;
    	} else if (weekly) {
    		disable('#milespastweek');
    		weekly = false;
    	}
    }

    // Display a panel list element
    function disable(id) {
    	$(id).addClass('inactiveleaderboard');
        $(id).removeClass('activeleaderboard');
    }

    function showLeaderboard(board) {
        data = groupdata['leaderboards'][board];
        console.info(data);

        count = 1;
        for (entry in data) {
            console.info(entry);
            first = String(data[entry]['first']);
            last = String(data[entry]['last']);
            last = last.charAt(0) + '.';
            miles = data[entry]['miles'];
            miles = miles.toFixed(1);
            text = "#" + count + ": " + first + " " + last + " " + miles + " miles";
            console.info(text);

            $('#leaderboardchart').append('<dd class="percentage"><span class="text">' + text + '</span></dd> ');
            count++;
        }
    }
    
});