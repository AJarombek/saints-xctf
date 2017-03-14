/*
 * Author: Andrew Jarombek
 * Date: 3/13/2017
 * JavaScript for interacting with the calendar panel in the profile page
 */

$(document).ready(function() {

});

const DAYS_INDEX = {
    'monday': 1,
    'tuesday': 2,
    'wednesday': 3,
    'thursday': 4,
    'friday': 5,
    'saturday': 6,
    'sunday': 7,
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
	console.info(firstDayOfMonth);
	var lastDayOfMonth = date.moveToLastDayOfMonth();

	var firstCalenderDay = firstDayOfMonth.toString('dddd');
	var lastDay = lastDayOfMonth.toString('d');

	var offset = DAYS_INDEX[firstCalenderDay];

	for (var i = 0; i <= lastDay; i++) {
		$('#calendar .calendarday:nth-child(' + (offset + i) + ')').append("<p>" + i + "</p>");
	}
}