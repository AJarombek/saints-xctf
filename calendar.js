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

var calendarDate = Date.today();

// Get the year and month of the calendar
var calendarYear = calendarDate.toString('yyyy');
var calendarMonth = calendarDate.toString('MMMM');

// Function that generates a new calendar with a specific month and year
function generateCalendar(date, month, year) {

	// Get up a calendar format for a given month
	setUpCalendar(date);

	// Populate the calendar with this months logs
	//getMonthLogs(username, month, year);

	// Generate the weekly calendar stats
	//generateCalendarStatistics();
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

		$('#calendar .calendarday:nth-child(' + index + ')').append("<p>" + dateValue + "</p>");

		if (!prevMonth && !nextMonth) {
			$('#calendar .calendarday:nth-child(' + index + ')').css('background-color', '#eee');
		}

		$('#calendar .calendarday:nth-child(' + index + ')').attr("id", dateId);

		date.addDays(1);
	}

	var lastDayOfCalendar = date.toString('yyyy-MM-dd');
}