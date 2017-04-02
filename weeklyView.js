/*
 * Author: Andrew Jarombek
 * Date: 3/30/2017
 * JavaScript for interacting with the weekly view in the profile page
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
var firstDayOfWeek, lastDayOfWeek, syledFirstDayOfWeek, styledLastDayOfWeek;

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
		syledFirstDayOfWeek = dateCopy.toString('MMM dd, yyyy');
		lastDayOfWeek = dateCopy.addDays(6).toString('yyyy-MM-dd');
		styledLastDayOfWeek = dateCopy.toString('MMM dd, yyyy');
		dateCopy.addDays(-6);
		
		for (day in WEEKLY_DAYS_INDEX_MONDAY) {
			var index = WEEKLY_DAYS_INDEX_MONDAY[day]['index'];
			$('#' + index + ' th').html('').append(WEEKLY_DAYS_INDEX_MONDAY[day]['name']);
			$('#' + index + ' td p').attr("id", dateCopy.toString('yyyy-MM-dd'));
			dateCopy.addDays(1);
		}
	} else {
		firstDayOfWeek = dateCopy.sunday().toString('yyyy-MM-dd');
		syledFirstDayOfWeek = dateCopy.toString('MMM dd, yyyy');
		lastDayOfWeek = dateCopy.addDays(6).toString('yyyy-MM-dd');
		styledLastDayOfWeek = dateCopy.toString('MMM dd, yyyy');
		dateCopy.addDays(-6);

		for (day in WEEKLY_DAYS_INDEX_SUNDAY) {
			var index = WEEKLY_DAYS_INDEX_SUNDAY[day]['index'];
			$('#' + index + ' th').html('').append(WEEKLY_DAYS_INDEX_SUNDAY[day]['name']);
			$('#' + index + ' td p').attr("id", dateCopy.toString('yyyy-MM-dd'));
			dateCopy.addDays(1);
		}
	}

	$('caption p:nth-child(2)').html('').append(syledFirstDayOfWeek + " - " + styledLastDayOfWeek);

	var paramtype = "user";
    var sortparam = get('user');

    // Build an object of the rangeview parameters
    var params = new Object();
    params.paramtype = paramtype;
    params.sortparam = sortparam;
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

        // Set click events for prev and next month
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

		$('#' + dayDate).html(dayMilesView + ' mi');

		var background_color = FEEL_COLORS[dayFeel]["color"];
		$('#' + dayDate).parent().css('background-color', background_color);
	}

	for (day in rangeView) {
		var dayDate = rangeView[day]['date'];
		var dayMiles = parseFloat(rangeView[day]['miles']);

		var height = String(parseInt((dayMiles / maxMiles) * 250));
		$('#' + dayDate).parent().css('height', height + 'px');
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