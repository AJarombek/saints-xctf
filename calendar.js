/*
 * Author: Andrew Jarombek
 * Date: 3/13/2017
 * JavaScript for interacting with the calendar panel in the profile page
 */

const DAYS_INDEX_MONDAY = {
    'Monday': { index: 0, name: 'Monday' },
    'Tuesday': { index: 1, name: 'Tuesday' },
    'Wednesday': { index: 2, name: 'Wednesday' },
    'Thursday': { index: 3, name: 'Thursday' },
    'Friday': { index: 4, name: 'Friday' },
    'Saturday': { index: 5, name: 'Saturday' },
    'Sunday': { index: 6, name: 'Sunday' }
};

const DAYS_INDEX_SUNDAY = {
    'Monday': { index: 1, name: 'Monday' },
    'Tuesday': { index: 2, name: 'Tuesday' },
    'Wednesday': { index: 3, name: 'Wednesday' },
    'Thursday': { index: 4, name: 'Thursday' },
    'Friday': { index: 5, name: 'Friday' },
    'Saturday': { index: 6, name: 'Saturday' },
    'Sunday': { index: 0, name: 'Sunday' }
};

var calendarDate = Date.today();

// Get the year and month of the calendar
var calendarYear = calendarDate.toString('yyyy');
var calendarMonth = calendarDate.toString('MMMM');

var weeklyMiles;
var calendarRows = 6;

// Function that generates a new calendar with a specific month and year
function generateCalendar(date) {

	$('#monthyear p:nth-child(2)').html('').append(calendarMonth + " " + calendarYear);

	// Unbind the old click listeners
	$('#monthyear i:nth-child(1)').unbind();
	$('#monthyear i:nth-child(3)').unbind();

	// Set click events for prev and next month
	$('#monthyear i:nth-child(1)').on('click', function() {
		destroyCalendar();
		calendarDate.addMonths(-1);
		calendarYear = calendarDate.toString('yyyy');
		calendarMonth = calendarDate.toString('MMMM');
		generateCalendar(calendarDate);
	});

	$('#monthyear i:nth-child(3)').on('click', function() {
		destroyCalendar();
		calendarDate.addMonths(1);
		calendarYear = calendarDate.toString('yyyy');
		calendarMonth = calendarDate.toString('MMMM');
		generateCalendar(calendarDate);
	});

	setUpCalendar(date);
}

function setUpCalendar(date) {

    var weekstart = $('#week_start').val();

	weeklyMiles = [0,0,0,0,0,0];
	calendarRows = 6;

	// Make a deep copy of the date object
	var dateCopy = Date.parse(date.toString('yyyy-MM-dd'));
	console.info(dateCopy);

	var firstDayOfMonth = dateCopy.moveToFirstDayOfMonth();
	var firstCalenderDay = firstDayOfMonth.toString('dddd');
	console.info(firstDayOfMonth);
	console.info(firstCalenderDay);

	var offset;

	// Implement the users week start preferences
	if (weekstart == "monday") {
		offset = parseInt(DAYS_INDEX_MONDAY[firstCalenderDay]['index']);
		for (day in DAYS_INDEX_MONDAY) {
			var index = DAYS_INDEX_MONDAY[day]['index'] + 1;
			$('#weekdays .wd:nth-child(' + index + ')').html('')
				.append(DAYS_INDEX_MONDAY[day]['name']);
		}
	} else {
		offset = parseInt(DAYS_INDEX_SUNDAY[firstCalenderDay]['index']);
		for (day in DAYS_INDEX_SUNDAY) {
			var index = DAYS_INDEX_SUNDAY[day]['index'] + 1;
			$('#weekdays .wd:nth-child(' + index + ')').html('')
				.append(DAYS_INDEX_SUNDAY[day]['name']);
		}
	}

	var newOffset = 0;
	var startDay = 0 - offset;

	dateCopy.addDays(startDay);

	var firstDayOfCalendar = dateCopy.toString('yyyy-MM-dd');

	var prevMonth = true;
	var nextMonth = false;

	for (var i = 1; i <= 42; i++) {
		if ((i + newOffset) % 8 == 0) {
			newOffset += 1

			// Stop populating rows if it is the next month
			if (nextMonth) {
				calendarRows = parseInt((i / 8) + 1);
				break;
			}
		}

		var index = newOffset + i;

		var dateValue = dateCopy.toString('d');
		var dateId = dateCopy.toString('yyyy-MM-dd');
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

		dateCopy.addDays(1);
	}

	var lastDayOfCalendar = dateCopy.toString('yyyy-MM-dd');

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

		var dayIndex = $('#' + dayDate).index();
		dayIndex = parseInt(dayIndex / 8);
		weeklyMiles[dayIndex] += dayMiles;
	}

	populateWeeklyTotals();
}

function destroyCalendar() {
	for (var i = 1; i <= 48; i++) {
		$('#calendar .calendarday:nth-child(' + i + ')').html('');
		$('#calendar .calendarend:nth-child(' + i + ')').html('');
		$('#calendar .calendarday:nth-child(' + i + ')').css('background-color', '');
	}
}

function populateWeeklyTotals() {
	for (var i = 1; i <= calendarRows; i++) {
		var index = (i * 8);
		$('#calendar .calendarend:nth-child(' + index + ')').append("<p class='calendarDayMileage'>" + weeklyMiles[i-1] + " <br>miles</p>");
	}
}