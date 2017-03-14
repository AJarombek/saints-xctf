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

	date.addDays(-1);
	var previousLastDay = date.toString('d');
	date.addDays(1);

	var lastDayOfMonth = date.moveToLastDayOfMonth();
	var lastDay = lastDayOfMonth.toString('d');
	console.info(lastDay);

	var offset = parseInt(DAYS_INDEX[firstCalenderDay]);
	var originalOffset = offset;
	console.info(offset);

	// Populate this month
	for (var i = 1; i <= lastDay; i++) {
		if ((i + offset) % 8 == 0) {
			offset += 1
		}
		var child = offset + i;
		console.info(child);
		$('#calendar .calendarday:nth-child(' + child + ')').append("<p>" + i + "</p>");
		$('#calendar .calendarday:nth-child(' + child + ')').css('background-color', '#eee');
	}

	// Populate what is visible of last month
	for (var i = originalOffset; i >= 0; i--) {
		$('#calendar .calendarday:nth-child(' + i + ')').append("<p>" + previousLastDay + "</p>");
		previousLastDay --;
	}

	// Populate what is visible of next month
	var i = 1;
	var newOffset = offset + parseInt(lastDay) + 1;
	while (newOffset % 8 != 0) {
		$('#calendar .calendarday:nth-child(' + newOffset + ')').append("<p>" + i + "</p>");
		i++;
		newOffset++;
	}
}