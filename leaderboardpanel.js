/*
 * Author: Andrew Jarombek
 * Date: 2/17/2017 - 6/2/2017
 * JavaScript for interacting with the leaderboard panel
 * Version 0.6 (GROUPS UPDATE) - 2/20/2017
 * Version 1.0 (OFFICIAL RELEASE) - 6/2/2017
 */

$(document).ready(function() {

    // Sort Date Spans
	var alltime = true;
	var yearly = false;
	var monthly = false;
	var weekly = false;

    // Sort Filters
    var filter_run = true;
    var filter_bike = false;
    var filter_swim = false;
    var filter_other = false;

    var groupJSON = $('#group_data').val();
    var groupdata = JSON.parse(groupJSON);
    console.info(groupdata);

    showLeaderboard('miles');
    var current_leaderboard = 'miles';
    var current_title = '<dt id="leaderboardtitle">Miles All Time</dt>';

    // when the user clicks on the leaderboard option, display it and remove the current leaderboard
    $('#milesalltime').on("click", function() {

    	// Switch Leaderboards if this isnt the active leaderboard
        if (!alltime) {
        	disableLeaderboard();
        	$('#milesalltime').removeClass('inactiveleaderboard');
        	$('#milesalltime').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            current_title = '<dt id="leaderboardtitle">Miles All Time</dt>';
            $('#leaderboardchart').append(current_title);
            showLeaderboard('miles');
            current_leaderboard = 'miles';
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
            current_title = '<dt id="leaderboardtitle">Miles Yearly</dt>';
            $('#leaderboardchart').append(current_title);
            showLeaderboard('milespastyear');
            current_leaderboard = 'milespastyear';
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
            current_title = '<dt id="leaderboardtitle">Miles Monthly</dt>';
            $('#leaderboardchart').append(current_title);
            showLeaderboard('milespastmonth');
            current_leaderboard = 'milespastmonth';
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
            current_title = '<dt id="leaderboardtitle">Miles Weekly</dt>';
            $('#leaderboardchart').append(current_title);
            showLeaderboard('milespastweek');
            current_leaderboard = 'milespastweek';
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

    // when the user clicks on the leaderboard filter option, filter the leaderboard accordingly
    $('#milesrun').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_run) {
            $('#milesrun').removeClass('inactiveleaderboard');
            $('#milesrun').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append(current_title);
            filter_run = true;
            showLeaderboard(current_leaderboard);
        } else {
            $('#milesrun').removeClass('activeleaderboard');
            $('#milesrun').addClass('inactiveleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append(current_title);
            filter_run = false;
            showLeaderboard(current_leaderboard);
        }
    });

    $('#milesbiked').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_bike) {
            $('#milesbiked').removeClass('inactiveleaderboard');
            $('#milesbiked').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append(current_title);
            filter_bike = true;
            showLeaderboard(current_leaderboard);
        } else {
            $('#milesbiked').removeClass('activeleaderboard');
            $('#milesbiked').addClass('inactiveleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append(current_title);
            filter_bike = false;
            showLeaderboard(current_leaderboard);
        }
    });

    $('#milesswam').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_swim) {
            $('#milesswam').removeClass('inactiveleaderboard');
            $('#milesswam').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append(current_title);
            filter_swim = true;
            showLeaderboard(current_leaderboard);
        } else {
            $('#milesswam').removeClass('activeleaderboard');
            $('#milesswam').addClass('inactiveleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append(current_title);
            filter_swim = false;
            showLeaderboard(current_leaderboard);
        }
    });

    $('#milesother').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_other) {
            $('#milesother').removeClass('inactiveleaderboard');
            $('#milesother').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append(current_title);
            filter_other = true;
            showLeaderboard(current_leaderboard);
        } else {
            $('#milesother').removeClass('activeleaderboard');
            $('#milesother').addClass('inactiveleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append(current_title);
            filter_other = false;
            showLeaderboard(current_leaderboard);
        }
    });

    // Display a panel list element
    function disable(id) {
    	$(id).addClass('inactiveleaderboard');
        $(id).removeClass('activeleaderboard');
    }

    // Display the leaderboard chosen
    function showLeaderboard(board) {
        var data = groupdata['leaderboards'][board];
        var mileFunction = sortDataByFilter(data);
        console.info('Mile Function' + mileFunction);

        console.info(data);

        if (data.length != 0) {
            var highestMileage = mileFunction(data, 0);
            console.info(highestMileage);
            highestMileage = parseFloat(highestMileage).toFixed(1);

            count = 1;
            for (entry in data) {

                if (count > 15) {
                    break;
                }

                // Get info for the entry
                console.info(entry);
                var first = String(data[entry]['first']);
                var last = String(data[entry]['last']);
                last = last.charAt(0) + '.';
                var miles = mileFunction(data, entry);
                console.info(miles);
                miles = parseFloat(miles).toFixed(1);
                var text = "#" + count + ": " + first + " " + last + " " + miles + " miles";
                console.info(text);

                var barno = "bar_" + entry;

                // Populate the entry
                $('#leaderboardchart').append('<dd id="' + barno + '" class="percentage"><span class="text">' +
                                             text + '</span></dd> ');

                // Then determine the width of the graph bar
                console.info(highestMileage);
                if (highestMileage == 0.0) {
                    var width = 0;
                } else {
                    var width = Math.round((miles / highestMileage) * 100);
                }
                width = width + "%";
                console.info(width);

                $('<style>#' + barno + ':after{width:' + width + '}</style>').appendTo('head');

                count++;
            }
        }
    }

    function sortDataByFilter(data) {
        if (filter_run) {
            if (filter_bike) {
                if (filter_swim) {
                    if (filter_other) {
                        // [Run, Bike, Swim, Other]
                        data.sort(function(a,b) {return (parseFloat(a.miles) < parseFloat(b.miles)) ? 1 : ((parseFloat(b.miles) < parseFloat(a.miles)) ? -1 : 0);} );
                        return function(data, entry) { return parseFloat(data[entry]['miles']);};
                    } else {
                        // [Run, Bike, Swim]
                        data.sort(function(a,b) {return (parseFloat(a.milesrun) + parseFloat(a.milesbiked) + parseFloat(a.milesswam) 
                                                        < parseFloat(b.milesrun) + parseFloat(b.milesbiked) + parseFloat(b.milesswam)) ? 1 : 
                                                        ((parseFloat(b.milesrun) + parseFloat(b.milesbiked) + parseFloat(b.milesswam) < 
                                                          parseFloat(a.milesrun) + parseFloat(a.milesbiked) + parseFloat(a.milesswam)) ? -1 : 0);} );
                        return function(data, entry) { return parseFloat(data[entry]['milesrun']) + parseFloat(data[entry]['milesbiked']) 
                                                            + parseFloat(data[entry]['milesswam']);};
                    }
                } else {
                    if (filter_other) {
                        // [Run, Bike, Other]
                        data.sort(function(a,b) {return (parseFloat(a.milesrun) + parseFloat(a.milesbiked) + parseFloat(a.milesswam) 
                                                        < parseFloat(b.milesrun) + parseFloat(b.milesbiked) + parseFloat(b.milesswam)) ? 1 : 
                                                        ((parseFloat(b.milesrun) + parseFloat(b.milesbiked) + parseFloat(b.milesswam) < 
                                                          parseFloat(a.milesrun) + parseFloat(a.milesbiked) + parseFloat(a.milesswam)) ? -1 : 0);} );
                        return function(data, entry) { return parseFloat(data[entry]['milesrun']) + parseFloat(data[entry]['milesbiked']) 
                                                            + parseFloat(data[entry]['milesother']);};
                    }
                }

                // [Run, Bike]
                data.sort(function(a,b) {return (parseFloat(a.milesrun) + parseFloat(a.milesbiked) < parseFloat(b.milesrun) + parseFloat(b.milesbiked)) ? 1 : 
                                                ((parseFloat(b.milesrun) + parseFloat(b.milesbiked) < parseFloat(a.milesrun) + parseFloat(a.milesbiked)) ? -1 : 0);} );
                return function(data, entry) { return parseFloat(data[entry]['milesbiked']) + parseFloat(data[entry]['milesrun']);};

            } else if (filter_swim) {
                if (filter_other) {
                    // [Run, Swim, Other]
                    data.sort(function(a,b) {return (parseFloat(a.milesrun) + parseFloat(a.milesother) + parseFloat(a.milesswam) 
                                                    < parseFloat(b.milesrun) + parseFloat(b.milesother) + parseFloat(b.milesswam)) ? 1 : 
                                                    ((parseFloat(b.milesrun) + parseFloat(b.milesother) + parseFloat(b.milesswam) 
                                                    < parseFloat(a.milesrun) + parseFloat(a.milesother) + parseFloat(a.milesswam)) ? -1 : 0);} );
                    return function(data, entry) { return parseFloat(data[entry]['milesrun']) + parseFloat(data[entry]['milesother']) 
                                                        + parseFloat(data[entry]['milesswam']);};
                } else {
                    // [Run, Swim]
                    data.sort(function(a,b) {return (parseFloat(a.milesswam) + parseFloat(a.milesrun) < parseFloat(b.milesswam) + parseFloat(b.milesrun)) ? 1 : 
                                                    ((parseFloat(b.milesswam) + parseFloat(b.milesrun) < parseFloat(a.milesswam) + parseFloat(a.milesrun)) ? -1 : 0);} );
                    return function(data, entry) { return parseFloat(data[entry]['milesrun']) + parseFloat(data[entry]['milesswam']);};
                }
            } else if (filter_other) {
                // [Run, Other]
                data.sort(function(a,b) {return (parseFloat(a.milesrun) + parseFloat(a.milesother) < parseFloat(b.milesrun) + parseFloat(b.milesother)) ? 1 : 
                                                ((parseFloat(b.milesrun) + parseFloat(b.milesother) < parseFloat(a.milesrun) + parseFloat(a.milesother)) ? -1 : 0);} );
                return function(data, entry) { return parseFloat(data[entry]['milesrun']) + parseFloat(data[entry]['milesother']);};
            }

            // [Run]
            data.sort(function(a,b) {return (parseFloat(a.milesrun) < parseFloat(b.milesrun)) ? 1 : ((parseFloat(b.milesrun) < parseFloat(a.milesrun)) ? -1 : 0);} );
            return function(data, entry) { return parseFloat(data[entry]['milesrun']);};

        } else if (filter_bike) {
            if (filter_swim) {
                if (filter_other) {
                    // [Bike, Swim, Other]
                    data.sort(function(a,b) {return (parseFloat(a.milesother) + parseFloat(a.milesbiked) + parseFloat(a.milesswam) 
                                                    < parseFloat(b.milesother) + parseFloat(b.milesbiked) + parseFloat(b.milesswam)) ? 1 : 
                                                    ((parseFloat(b.milesother) + parseFloat(b.milesbiked) + parseFloat(b.milesswam) 
                                                    < parseFloat(a.milesother) + parseFloat(a.milesbiked) + parseFloat(a.milesswam)) ? -1 : 0);} );
                    return function(data, entry) { return parseFloat(data[entry]['milesother']) + parseFloat(data[entry]['milesbiked']) 
                                                        + parseFloat(data[entry]['milesswam']);};
                } else {
                    // [Bike, Swim]
                    data.sort(function(a,b) {return (parseFloat(a.milesbiked) + parseFloat(a.milesswam) < parseFloat(b.milesbiked) + parseFloat(b.milesswam)) ? 1 : 
                                                ((parseFloat(b.milesbiked) + parseFloat(b.milesswam) < parseFloat(a.milesbiked) + parseFloat(a.milesswam)) ? -1 : 0);} );
                    return function(data, entry) { return parseFloat(data[entry]['milesbiked']) + parseFloat(data[entry]['milesswam']);};
                }
            } else if (filter_other) {
                // [Bike, Other]
                data.sort(function(a,b) {return (parseFloat(a.milesbiked) + parseFloat(a.milesother) < parseFloat(b.milesbiked) + parseFloat(b.milesother)) ? 1 : 
                                                ((parseFloat(b.milesbiked) + parseFloat(b.milesother) < parseFloat(a.milesbiked) + parseFloat(a.milesother)) ? -1 : 0);} );
                return function(data, entry) { return parseFloat(data[entry]['milesbiked']) + parseFloat(data[entry]['milesother']);};
            }

            // [Bike]
            data.sort(function(a,b) {return (parseFloat(a.milesbiked) < parseFloat(b.milesbiked)) ? 1 : ((parseFloat(b.milesbiked) < parseFloat(a.milesbiked)) ? -1 : 0);} );
            return function(data, entry) { return parseFloat(data[entry]['milesbiked']);};

        } else if (filter_swim) {
            if (filter_other) {
                // [Swim, Other]
                data.sort(function(a,b) {return (parseFloat(a.milesswam) + parseFloat(a.milesother) < parseFloat(b.milesswam) + parseFloat(b.milesother)) ? 1 : 
                                                ((parseFloat(b.milesswam) + parseFloat(b.milesother) < parseFloat(a.milesswam) + parseFloat(a.milesother)) ? -1 : 0);} );
                return function(data, entry) { return parseFloat(data[entry]['milesother']) + parseFloat(data[entry]['milesswam']);};
            }
            // [Swim]
            data.sort(function(a,b) {return (parseFloat(a.milesswam) < parseFloat(b.milesswam)) ? 1 : ((parseFloat(b.milesswam) < parseFloat(a.milesswam)) ? -1 : 0);} );
            return function(data, entry) { return parseFloat(data[entry]['milesswam']);};
        } else if (filter_other) {
            // [Other]
            data.sort(function(a,b) {return (parseFloat(a.milesother) < parseFloat(b.milesother)) ? 1 : ((parseFloat(b.milesother) < parseFloat(a.milesother)) ? -1 : 0);} );
            return function(data, entry) { return parseFloat(data[entry]['milesother']);};
        }
        return function(data, entry) { return 0; };
    }
    
});