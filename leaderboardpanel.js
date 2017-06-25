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
            showLeaderboard(current_leaderboard);
            filter_run = true;
        } else {
            // Only Deselect if there is another Filter active
            if (filter_bike || filter_swim || filter_other) {
                $('#milesrun').removeClass('activeleaderboard');
                $('#milesrun').addClass('inactiveleaderboard');
                $('#leaderboardchart').html('');
                $('#leaderboardchart').append(current_title);
                showLeaderboard(current_leaderboard);
                filter_run = false;
            }
        }
    });

    $('#milesbiked').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_bike) {
            $('#milesbiked').removeClass('inactiveleaderboard');
            $('#milesbiked').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append(current_title);
            showLeaderboard(current_leaderboard);
            filter_bike = true;
        } else {
            // Only Deselect if there is another Filter active
            if (filter_run || filter_swim || filter_other) {
                $('#milesbiked').removeClass('activeleaderboard');
                $('#milesbiked').addClass('inactiveleaderboard');
                $('#leaderboardchart').html('');
                $('#leaderboardchart').append(current_title);
                showLeaderboard(current_leaderboard);
                filter_bike = false;
            }
        }
    });

    $('#milesswam').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_swim) {
            $('#milesswam').removeClass('inactiveleaderboard');
            $('#milesswam').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append(current_title);
            showLeaderboard(current_leaderboard);
            filter_swim = true;
        } else {
            // Only Deselect if there is another Filter active
            if (filter_run || filter_bike || filter_other) {
                $('#milesswam').removeClass('activeleaderboard');
                $('#milesswam').addClass('inactiveleaderboard');
                $('#leaderboardchart').html('');
                $('#leaderboardchart').append(current_title);
                showLeaderboard(current_leaderboard);
                filter_swim = false;
            }
        }
    });

    $('#milesother').on("click", function() {

        // Change the Leaderboard Filter
        if (!filter_other) {
            $('#milesother').removeClass('inactiveleaderboard');
            $('#milesother').addClass('activeleaderboard');
            $('#leaderboardchart').html('');
            $('#leaderboardchart').append(current_title);
            showLeaderboard(current_leaderboard);
            filter_other = true;
        } else {
            // Only Deselect if there is another Filter active
            if (filter_run || filter_bike || filter_swim) {
                $('#milesother').removeClass('activeleaderboard');
                $('#milesother').addClass('inactiveleaderboard');
                $('#leaderboardchart').html('');
                $('#leaderboardchart').append(current_title);
                showLeaderboard(current_leaderboard);
                filter_other = false;
            }
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
        sortDataByFilter(data);

        console.info(data);

        if (data.length != 0) {
            var highestMileage = parseFloat(data[0]['miles']);
            highestMileage = highestMileage.toFixed(1);

            count = 1;
            for (entry in data) {

                // Get info for the entry
                console.info(entry);
                first = String(data[entry]['first']);
                last = String(data[entry]['last']);
                last = last.charAt(0) + '.';
                miles = parseFloat(data[entry]['miles']);
                miles = miles.toFixed(1);
                text = "#" + count + ": " + first + " " + last + " " + miles + " miles";
                console.info(text);

                barno = "bar_" + entry;

                // Populate the entry
                $('#leaderboardchart').append('<dd id="' + barno + '" class="percentage"><span class="text">' +
                                             text + '</span></dd> ');

                // Then determine the width of the graph bar
                width = Math.round((miles / highestMileage) * 100);
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
                        data.sort(function(a,b) {return (a.miles > b.miles) ? 1 : ((b.miles > a.miles) ? -1 : 0);} );
                    } else {
                        // [Run, Bike, Swim]
                        data.sort(function(a,b) {return (a.milesrun + a.milesbiked + a.milesswam > b.milesrun + b.milesbiked + b.milesswam) ? 1 : 
                                                ((b.milesrun + b.milesbiked + b.milesswam > a.milesrun + a.milesbiked + a.milesswam) ? -1 : 0);} );
                    }
                } else {
                    if (filter_other) {
                        // [Run, Bike, Other]
                        data.sort(function(a,b) {return (a.milesrun + a.milesbiked + a.milesswam > b.milesrun + b.milesbiked + b.milesswam) ? 1 : 
                                                ((b.milesrun + b.milesbiked + b.milesswam > a.milesrun + a.milesbiked + a.milesswam) ? -1 : 0);} );
                    }
                }

                // [Run, Bike]
                data.sort(function(a,b) {return (a.milesrun + a.milesbiked > b.milesrun + b.milesbiked) ? 1 : 
                                                ((b.milesrun + b.milesbiked > a.milesrun + a.milesbiked) ? -1 : 0);} );

            } else if (filter_swim) {
                if (filter_other) {
                    // [Run, Swim, Other]
                    data.sort(function(a,b) {return (a.milesrun + a.milesother + a.milesswam > b.milesrun + b.milesother + b.milesswam) ? 1 : 
                                                ((b.milesrun + b.milesother + b.milesswam > a.milesrun + a.milesother + a.milesswam) ? -1 : 0);} );
                } else {
                    // [Run, Swim]
                    data.sort(function(a,b) {return (a.milesswam + a.milesrun > b.milesswam + b.milesrun) ? 1 : 
                                                ((b.milesswam + b.milesrun > a.milesswam + a.milesrun) ? -1 : 0);} );
                }
            } else if (filter_other) {
                // [Run, Other]
                data.sort(function(a,b) {return (a.milesrun + a.milesother > b.milesrun + b.milesother) ? 1 : 
                                                ((b.milesrun + b.milesother > a.milesrun + a.milesother) ? -1 : 0);} );
            }

            // [Run]
            data.sort(function(a,b) {return (a.milesrun > b.milesrun) ? 1 : ((b.milesrun > a.milesrun) ? -1 : 0);} );

        } else if (filter_bike) {
            if (filter_swim) {
                if (filter_other) {
                    // [Bike, Swim, Other]
                    data.sort(function(a,b) {return (a.milesother + a.milesbiked + a.milesswam > b.milesother + b.milesbiked + b.milesswam) ? 1 : 
                                                ((b.milesother + b.milesbiked + b.milesswam > a.milesother + a.milesbiked + a.milesswam) ? -1 : 0);} );
                } else {
                    // [Bike, Swim]
                    data.sort(function(a,b) {return (a.milesbiked + a.milesswam > b.milesbiked + b.milesswam) ? 1 : 
                                                ((b.milesbiked + b.milesswam > a.milesbiked + a.milesswam) ? -1 : 0);} );
                }
            } else if (filter_other) {
                // [Bike, Other]
                data.sort(function(a,b) {return (a.milesbiked + a.milesother > b.milesbiked + b.milesother) ? 1 : 
                                                ((b.milesbiked + b.milesother > a.milesbiked + a.milesother) ? -1 : 0);} );
            }

            // [Bike]
            data.sort(function(a,b) {return (a.milesbiked > b.milesbiked) ? 1 : ((b.milesbiked > a.milesbiked) ? -1 : 0);} );

        } else if (filter_swim) {
            if (filter_other) {
                // [Swim, Other]
                data.sort(function(a,b) {return (a.milesswam + a.milesother > b.milesswam + b.milesother) ? 1 : 
                                                ((b.milesswam + b.milesother > a.milesswam + a.milesother) ? -1 : 0);} );
            }
            // [Swim]
            data.sort(function(a,b) {return (a.milesswam > b.milesswam) ? 1 : ((b.milesswam > a.milesswam) ? -1 : 0);} );
        } else if (filter_other) {
            // [Other]
            data.sort(function(a,b) {return (a.milesother > b.milesother) ? 1 : ((b.milesother > a.milesother) ? -1 : 0);} );
        }
    }
    
});