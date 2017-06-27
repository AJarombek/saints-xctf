/*
 * Author: Andrew Jarombek
 * Date: 3/30/2017 - 6/2/2017
 * JavaScript for interacting with the weekly view in the profile page
 * Version 1.0 (OFFICIAL RELEASE) - 6/2/2017
 */

const WEEKLY_DAYS_INDEX_MONDAY = {
    'Monday': { index: 'd1', name: 'Monday' },
    'Tuesday': { index: 'd2', name: 'Tuesday' },
    'Wednesday': { index: 'd3', name: 'Wednesday' },
    'Thursday': { index: 'd4', name: 'Thursday' },
    'Friday': { index: 'd5', name: 'Friday' },
    'Saturday': { index: 'd6', name: 'Saturday' },
    'Sunday': { index: 'd7', name: 'Sunday' }
};

const WEEKLY_DAYS_INDEX_SUNDAY = {
	'Sunday': { index: 'd1', name: 'Sunday' },
    'Monday': { index: 'd2', name: 'Monday' },
    'Tuesday': { index: 'd3', name: 'Tuesday' },
    'Wednesday': { index: 'd4', name: 'Wednesday' },
    'Thursday': { index: 'd5', name: 'Thursday' },
    'Friday': { index: 'd6', name: 'Friday' },
    'Saturday': { index: 'd7', name: 'Saturday' }
};

var weeklyViewDate = Date.today();
var firstDayOfWeek, lastDayOfWeek, styledFirstDayOfWeek, styledLastDayOfWeek;

// Sort Filters
var filter_run_week = true;
var filter_bike_week = false;
var filter_swim_week = false;
var filter_other_week = false;
var filter_week = 'r';

$(document).ready(function() {

    // when the user clicks on the leaderboard filter option, filter the leaderboard accordingly
    $('#milesrunweek').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_run_week) {
            $('#milesrunweek').removeClass('inactiveleaderboard');
            $('#milesrunweek').addClass('activeleaderboard');
            filter_run_week = true;
            filterWeeklyView();
            destroyWeeklyView();
            generateWeeklyView(weeklyViewDate);
        } else {
            $('#milesrunweek').removeClass('activeleaderboard');
            $('#milesrunweek').addClass('inactiveleaderboard');
            filter_run_week = false;
            filterWeeklyView();
            destroyWeeklyView();
            generateWeeklyView(weeklyViewDate);
        }
    });

    $('#milesbikedweek').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_bike_week) {
            $('#milesbikedweek').removeClass('inactiveleaderboard');
            $('#milesbikedweek').addClass('activeleaderboard');
            filter_bike_week = true;
            filterWeeklyView();
            destroyWeeklyView();
            generateWeeklyView(weeklyViewDate);
        } else {
            $('#milesbikedweek').removeClass('activeleaderboard');
            $('#milesbikedweek').addClass('inactiveleaderboard');
            filter_bike_week = false;
            filterWeeklyView();
            destroyWeeklyView();
            generateWeeklyView(weeklyViewDate);
        }
    });

    $('#milesswamweek').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_swim_week) {
            $('#milesswamweek').removeClass('inactiveleaderboard');
            $('#milesswamweek').addClass('activeleaderboard');
            filter_swim_week = true;
            filterWeeklyView();
            destroyWeeklyView();
            generateWeeklyView(weeklyViewDate);
        } else {
            $('#milesswamweek').removeClass('activeleaderboard');
            $('#milesswamweek').addClass('inactiveleaderboard');
            filter_swim_week = false;
            filterWeeklyView();
            destroyWeeklyView();
            generateWeeklyView(weeklyViewDate);
        }
    });

    $('#milesotherweek').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_other_week) {
            $('#milesotherweek').removeClass('inactiveleaderboard');
            $('#milesotherweek').addClass('activeleaderboard');
            filter_other_week = true;
            filterWeeklyView();
            destroyWeeklyView();
            generateWeeklyView(weeklyViewDate);
        } else {
            $('#milesotherweek').removeClass('activeleaderboard');
            $('#milesotherweek').addClass('inactiveleaderboard');
            filter_other_week = false;
            filterWeeklyView();
            destroyWeeklyView();
            generateWeeklyView(weeklyViewDate);
        }
    });
});

function filterWeeklyView() {
	// Change the filter accordingly
    if (filter_run_week) {
        if (filter_bike_week) {
            if (filter_swim_week) {
                if (filter_other_week) {
                    // [Run, Bike, Swim, Other]
                    filter_week = 'rbso';

                } else {
                    // [Run, Bike, Swim]
                    filter_week = 'rbs';
                }
            } else {
                if (filter_other_week) {
                    // [Run, Bike, Other]
                    filter_week = 'rbo';
                } else {
                    // [Run, Bike]
                    filter_week = 'rb';
                }
            }

        } else if (filter_swim_week) {
            if (filter_other_week) {
                // [Run, Swim, Other]
                filter_week = 'rso';
            } else {
                // [Run, Swim]
                filter_week = 'rs';
            }
        } else if (filter_other_week) {
            // [Run, Other]
            filter_week = 'ro';
        } else {
            // [Run]
            filter_week = 'r';
        }

    } else if (filter_bike_week) {
        if (filter_swim_week) {
            if (filter_other_week) {
                // [Bike, Swim, Other]
                filter_week = 'bso';
            } else {
                // [Bike, Swim]
                filter_week = 'bs';
            }
        } else if (filter_other_week) {
            // [Bike, Other]
            filter_week = 'bo';
        } else {
            // [Bike]
            filter_week = 'b';
        }

    } else if (filter_swim_week) {
        if (filter_other_week) {
            // [Swim, Other]
            filter_week = 'so';
        } else {
            // [Swim]
            filter_week = 's';
        }
    } else if (filter_other_week) {
        // [Other]
        filter_week = 'o';
    } else {
        filter_week = null;
    }
}

// Function that generates a new weeklyview with a specific month and year
function generateWeeklyView(date) {

	// Unbind the old click listeners
	$('caption i:nth-child(1)').unbind();
	$('caption i:nth-child(3)').unbind();

	setUpWeeklyView(date);
}

function setUpWeeklyView(date) {

    var weekstart = $('#week_start').val();

	// Make a deep copy of the date object
	var dateCopy = Date.parse(date.toString('yyyy-MM-dd'));
	console.info(dateCopy);

	// Implement the users week start preferences
	if (weekstart == "monday") {
		firstDayOfWeek = dateCopy.last().monday().toString('yyyy-MM-dd');
		styledFirstDayOfWeek = dateCopy.toString('MMM dd, yyyy');
		lastDayOfWeek = dateCopy.addDays(6).toString('yyyy-MM-dd');
		styledLastDayOfWeek = dateCopy.toString('MMM dd, yyyy');
		dateCopy.addDays(-6);
		
		for (day in WEEKLY_DAYS_INDEX_MONDAY) {
			var index = WEEKLY_DAYS_INDEX_MONDAY[day]['index'];
			$('#' + index + ' th').html('').append(WEEKLY_DAYS_INDEX_MONDAY[day]['name']);
			$('#' + index + ' td p').attr("id", dateCopy.toString('yyyy-MM-dd') + "weekly");
			dateCopy.addDays(1);
		}
	} else {
		firstDayOfWeek = dateCopy.last().sunday().toString('yyyy-MM-dd');
		styledFirstDayOfWeek = dateCopy.toString('MMM dd, yyyy');
		lastDayOfWeek = dateCopy.addDays(6).toString('yyyy-MM-dd');
		styledLastDayOfWeek = dateCopy.toString('MMM dd, yyyy');
		dateCopy.addDays(-6);

		for (day in WEEKLY_DAYS_INDEX_SUNDAY) {
			var index = WEEKLY_DAYS_INDEX_SUNDAY[day]['index'];
			$('#' + index + ' th').html('').append(WEEKLY_DAYS_INDEX_SUNDAY[day]['name']);
			$('#' + index + ' td p').attr("id", dateCopy.toString('yyyy-MM-dd') + "weekly");
			dateCopy.addDays(1);
		}
	}

	$('caption p:nth-child(2)').html('').append(styledFirstDayOfWeek + " - " + styledLastDayOfWeek);

	var paramtype = "user";
    var sortparam = get('user');

    // Build an object of the rangeview parameters
    var params = new Object();
    params.paramtype = paramtype;
    params.sortparam = sortparam;
    params.filter = filter_week;
    params.start = firstDayOfWeek;
    params.end = lastDayOfWeek;

    // Encode the array of rangeview parameters
    var paramString = JSON.stringify(params);
    console.info(paramString);

    $.get('rangeviewdetails.php', {getRangeView : paramString}, function(response) {

    	console.info(response);
    	try {
        	var rangeview = JSON.parse(response);

        	console.info(rangeview);
	        if (rangeview.length > 0) {
	            console.info("Populating the Weekly View...");
	            populateWeeklyView(rangeview);
	        } else {
	            console.info("Nothing to display this week.");
	        }
        } catch (e) {
        	console.error(e);
        }

        // Set click events for prev and next week
		$('caption i:nth-child(1)').on('click', function() {
			destroyWeeklyView();
			weeklyViewDate.addWeeks(-1);
			generateWeeklyView(weeklyViewDate);
		});

		$('caption i:nth-child(3)').on('click', function() {
			destroyWeeklyView();
			weeklyViewDate.addWeeks(1);
			generateWeeklyView(weeklyViewDate);
		});
    });
}

function populateWeeklyView(rangeView) {
	var maxMiles = 0;

	for (day in rangeView) {
		var dayDate = rangeView[day]['date'];
		var dayMiles = parseFloat(rangeView[day]['miles']);
		var dayMilesView = dayMiles.toFixed(2);
		var dayFeel = rangeView[day]['feel'];

		if (dayMiles > maxMiles)
			maxMiles = dayMiles;

		$('#' + dayDate + "weekly").html(dayMilesView + ' mi');

		var background_color = FEEL_COLORS[dayFeel]["color"];
		$('#' + dayDate + "weekly").parent().css('background-color', background_color);
	}

	for (day in rangeView) {
		var dayDate = rangeView[day]['date'];
		var dayMiles = parseFloat(rangeView[day]['miles']);

		var height = String(parseInt((dayMiles / maxMiles) * 250));
		$('#' + dayDate + "weekly").parent().css('height', height + 'px');
	}
}

function destroyWeeklyView() {
	for (day in WEEKLY_DAYS_INDEX_MONDAY) {
		var index = WEEKLY_DAYS_INDEX_MONDAY[day]['index'];
		$('#' + index + ' th').html('').append(WEEKLY_DAYS_INDEX_MONDAY[day]['name']);

		var styles = {
	        backgroundColor : "#900",
	        height: "0px"
	    };

		$('#' + index + ' td').css(styles);
		$('#' + index + ' td p').removeAttr("id");
		$('#' + index + ' td p').html('');
	}
}