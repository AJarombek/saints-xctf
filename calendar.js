/*
 * Author: Andrew Jarombek
 * Date: 3/13/2017
 * JavaScript for interacting with the calendar panel in the profile page
 */

$(document).ready(function() {

});

const DAYS_INDEX = {
    'Monday': 0,
    'Tuesday': 1,
    'Wednesday': 2,
    'Thursday': 3,
    'Friday': 4,
    'Saturday': 5,
    'Sunday': 6,
};

var calendarGenerated = false;

var calendarDate = Date.today();

// Get the year and month of the calendar
var calendarYear = calendarDate.toString('yyyy');
var calendarMonth = calendarDate.toString('MMMM');

// Function that generates a new calendar with a specific month and year
function generateCalendar(date, month, year) {

	if (calendarGenerated == false) {
		// Get up a calendar format for a given month
		calendarGenerated = true;
		setUpCalendar(date);

		// Set click events for prev and next month
	}
}

function setUpCalendar(date) {
	console.info(date);
	var firstDayOfMonth = date.moveToFirstDayOfMonth();
	var firstCalenderDay = firstDayOfMonth.toString('dddd');
	console.info(firstDayOfMonth);
	console.info(firstCalenderDay);

	var offset = parseInt(DAYS_INDEX[firstCalenderDay]);
	var newOffset = 0;
	var startDay = 0 - offset;

	date.addDays(startDay);

	var firstDayOfCalendar = date.toString('yyyy-MM-dd');

	var prevMonth = true;
	var nextMonth = false;

	for (var i = 1; i <= 42; i++) {
		if ((i + newOffset) % 8 == 0) {
			newOffset += 1

			// Stop populating rows if it is the next month
			if (nextMonth) {
				break;
			}
		}

		var index = newOffset + i;

		var dateValue = date.toString('d');
		var dateId = date.toString('yyyy-MM-dd');
		console.info(dateId);

		if (!prevMonth && !nextMonth && dateValue == 1) {
			nextMonth = true;
		}

		if (prevMonth && dateValue == 1) {
			prevMonth = false;
		}

		$('#calendar .calendarday:nth-child(' + index + ')').append("<p class='calendarDayNum'>" + dateValue + "</p>");

		if (!prevMonth && !nextMonth) {
			$('#calendar .calendarday:nth-child(' + index + ')').css('background-color', '#eee');
		}

		$('#calendar .calendarday:nth-child(' + index + ')').attr("id", dateId);

		date.addDays(1);
	}

	var lastDayOfCalendar = date.toString('yyyy-MM-dd');

	var paramtype = "user";
    var sortparam = get('user');

    // Build an object of the rangeview parameters
    var params = new Object();
    params.paramtype = paramtype;
    params.sortparam = sortparam;
    params.start = firstDayOfCalendar;
    params.end = lastDayOfCalendar;

    // Encode the array of rangeview parameters
    var paramString = JSON.stringify(params);

    $.get('rangeviewdetails.php', {getRangeView : paramString}, function(response) {

        var rangeview = JSON.parse(response);
        console.info(rangeview);
        if (rangeview.length > 0) {
            console.info("Populating the Calendar...");
            populateCalendar(rangeview);
        } else {
            console.info("Nothing to display this month.");
            $('#activityfeed').html('').append("<p class='nofeed'><i>No Activity</i></p>");
        }
    });
}

function populateCalendar(rangeView) {
	for (day in rangeView) {
		var dayDate = rangeView[day]['date'];
		var dayMiles = rangeView[day]['miles'];
		var dayFeel = rangeView[day]['feel'];

		$('#' + dayDate).append("<p class='calendarDayMileage'>" + dayMiles + " <br>miles</p>");

		var background_color = FEEL_COLORS[dayFeel]["color"];
		$('#' + dayDate).css('background-color', background_color);
	}
}