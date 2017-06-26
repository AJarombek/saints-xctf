/*
 * Author: Andrew Jarombek
 * Date: 3/13/2017 - 6/2/2017
 * JavaScript for interacting with the calendar panel in the profile page
 * Version 1.0 (OFFICIAL RELEASE) - 6/2/2017
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
var paramtype = "user";
var sortparam = get('user');
var filter = 'r';
var firstDayOfCalendar, lastDayOfCalendar;
var currentColors = [];

// Sort Filters
var filter_run = true;
var filter_bike = false;
var filter_swim = false;
var filter_other = false;

$(document).ready(function() {

    // when the user clicks on the leaderboard filter option, filter the leaderboard accordingly
    $('#milesrun').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_run) {
            $('#milesrun').removeClass('inactiveleaderboard');
            $('#milesrun').addClass('activeleaderboard');
            filter_run = true;
            filterCalendar();
        } else {
            $('#milesrun').removeClass('activeleaderboard');
            $('#milesrun').addClass('inactiveleaderboard');
            filter_run = false;
            filterCalendar();
        }
    });

    $('#milesbiked').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_bike) {
            $('#milesbiked').removeClass('inactiveleaderboard');
            $('#milesbiked').addClass('activeleaderboard');
            filter_bike = true;
            filterCalendar();
        } else {
            $('#milesbiked').removeClass('activeleaderboard');
            $('#milesbiked').addClass('inactiveleaderboard');
            filter_bike = false;
            filterCalendar();
        }
    });

    $('#milesswam').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_swim) {
            $('#milesswam').removeClass('inactiveleaderboard');
            $('#milesswam').addClass('activeleaderboard');
            filter_swim = true;
            filterCalendar();
        } else {
            $('#milesswam').removeClass('activeleaderboard');
            $('#milesswam').addClass('inactiveleaderboard');
            filter_swim = false;
            filterCalendar();
        }
    });

    $('#milesother').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_other) {
            $('#milesother').removeClass('inactiveleaderboard');
            $('#milesother').addClass('activeleaderboard');
            filter_other = true;
            filterCalendar();
        } else {
            $('#milesother').removeClass('activeleaderboard');
            $('#milesother').addClass('inactiveleaderboard');
            filter_other = false;
            filterCalendar();
        }
    });
});

// Function that generates a new calendar with a specific month and year
function generateCalendar(date) {

	$('#monthyear p:nth-child(2)').html('').append(calendarMonth + " " + calendarYear);

	// Unbind the old click listeners
	$('#monthyear i:nth-child(1)').unbind();
	$('#monthyear i:nth-child(3)').unbind();

	setUpCalendar(date);
}

function setUpCalendar(date) {

    var weekstart = $('#week_start').val();

	weeklyMiles = [0,0,0,0,0,0];
	calendarRows = 6;
    currentColors = [];

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

	firstDayOfCalendar = dateCopy.toString('yyyy-MM-dd');

	var prevMonth = true;
	var nextMonth = false;

	for (var i = 1; i <= 42; i++) {
		if ((i + newOffset) % 8 == 0) {
			newOffset += 1
            currentColors.push('#ddd');

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
            currentColors.push('#eee');
		} else {
            currentColors.push('#ddd');
        }

		$('#calendar .calendarday:nth-child(' + index + ')').attr("id", dateId);

		dateCopy.addDays(1);
	}

	dateCopy.addDays(-1);
	lastDayOfCalendar = dateCopy.toString('yyyy-MM-dd');

    // Build an object of the rangeview parameters
    var params = new Object();
    params.paramtype = paramtype;
    params.sortparam = sortparam;
    params.filter = filter;
    params.start = firstDayOfCalendar;
    params.end = lastDayOfCalendar;

    // Encode the array of rangeview parameters
    var paramString = JSON.stringify(params);
    console.info(paramString);

    $.get('rangeviewdetails.php', {getRangeView : paramString}, function(response) {

    	console.info(response);
    	try {
        	var rangeview = JSON.parse(response);

        	console.info(rangeview);
	        if (rangeview.length > 0) {
	            console.info("Populating the Calendar...");
	            populateCalendar(rangeview);
	        } else {
	            console.info("Nothing to display this month.");
	        }
        } catch (e) {
        	console.error(e);
        }

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
    });
}

function filterCalendar() {

    // Change the filter accordingly
    if (filter_run) {
        if (filter_bike) {
            if (filter_swim) {
                if (filter_other) {
                    // [Run, Bike, Swim, Other]
                    filter = 'rbso';

                } else {
                    // [Run, Bike, Swim]
                    filter = 'rbs';
                }
            } else {
                if (filter_other) {
                    // [Run, Bike, Other]
                    filter = 'rbo';
                } else {
                    // [Run, Bike]
                    filter = 'rb';
                }
            }

        } else if (filter_swim) {
            if (filter_other) {
                // [Run, Swim, Other]
                filter = 'rso';
            } else {
                // [Run, Swim]
                filter = 'rs';
            }
        } else if (filter_other) {
            // [Run, Other]
            filter = 'ro';
        } else {
            // [Run]
            filter = 'r';
        }

    } else if (filter_bike) {
        if (filter_swim) {
            if (filter_other) {
                // [Bike, Swim, Other]
                filter = 'bso';
            } else {
                // [Bike, Swim]
                filter = 'bs';
            }
        } else if (filter_other) {
            // [Bike, Other]
            filter = 'bo';
        } else {
            // [Bike]
            filter = 'b';
        }

    } else if (filter_swim) {
        if (filter_other) {
            // [Swim, Other]
            filter = 'so';
        } else {
            // [Swim]
            filter = 's';
        }
    } else if (filter_other) {
        // [Other]
        filter = 'o';
    } else {
        filter = null;
    }

    console.info(filter);

    if (filter != null) {

        // Build an object of the rangeview parameters
        var params = new Object();
        params.paramtype = paramtype;
        params.sortparam = sortparam;
        params.filter = filter;
        params.start = firstDayOfCalendar;
        params.end = lastDayOfCalendar;

        // Encode the array of rangeview parameters
        var paramString = JSON.stringify(params);
        console.info(paramString);

        $.get('rangeviewdetails.php', {getRangeView : paramString}, function(response) {

            console.info(response);
            try {
                var rangeview = JSON.parse(response);

                console.info(rangeview);
                if (rangeview.length > 0) {
                    console.info("Populating the Calendar...");
                    removeCalendarMileage();
                    weeklyMiles = [0,0,0,0,0,0];
                    populateCalendar(rangeview);
                } else {
                    console.info("Nothing to display this month.");
                }
            } catch (e) {
                console.error(e);
                removeCalendarMileage();
                weeklyMiles = [0,0,0,0,0,0];
                populateCalendar(null);
            }
        });
    } else {
        removeCalendarMileage();
        weeklyMiles = [0,0,0,0,0,0];
        populateCalendar(null);
    }
}

function populateCalendar(rangeView) {
	for (day in rangeView) {
		var dayDate = rangeView[day]['date'];
		var dayMiles = parseFloat(rangeView[day]['miles']);
		var dayMilesView = dayMiles.toFixed(2);
		var dayFeel = rangeView[day]['feel'];

		$('#' + dayDate).append("<p class='calendarDayMileage'>" + dayMilesView + " <br>miles</p>");

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

function removeCalendarMileage() {
    for (var i = 1; i <= 48; i++) {
        $('#calendar .calendarday .calendarDayMileage:nth-child(' + i + ')').html('');
        $('#calendar .calendarend:nth-child(' + i + ')').html('');
        $('#calendar .calendarday:nth-child(' + i + ')').css('background-color', currentColors[i-1]);
    }
}

function populateWeeklyTotals() {
	for (var i = 1; i <= calendarRows; i++) {
		var index = (i * 8);
		var wMiles = parseFloat(weeklyMiles[i-1]);
		wMiles = wMiles.toFixed(2);
		$('#calendar .calendarend:nth-child(' + index + ')').append("<p class='calendarDayMileage'>" + wMiles + " <br>miles</p>");
	}
}