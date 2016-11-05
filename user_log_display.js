/*
 * Author: Andrew Jarombek
 * Date: 11/5/2016 - 
 * JavaScript for displaying logs on profile pages, group pages, or the main page
 */

$(document).ready(function() {

    // Array of Objects for the different feel parameters
    const FEEL_COLORS = {
        1: {color: 'rgba(204, 0, 0, .4)', name: 'Terrible', class: 'terrible_feel'},
        2: {color: 'rgba(255, 51, 0, .4)', name: 'Very Bad', class: 'very_bad_feel'},
        3: {color: 'rgba(204, 102, 0, .4)', name: 'Bad', class: 'bad_feel'},
        4: {color: 'rgba(255, 153, 0, .4)', name: 'Pretty Bad', class: 'pretty_bad_feel'},
        5: {color: 'rgba(187, 187, 187, .4)', name: 'Mediocre', class: 'mediocre_feel'},
        6: {color: 'rgba(255, 255, 51, .4)', name: 'Average', class: 'average_feel'},
        7: {color: 'rgba(115, 230, 0, .4)', name: 'Fairly Good', class: 'fairly_good_feel'},
        8: {color: 'rgba(0, 153, 0, .4)', name: 'Good', class: 'good_feel'},
        9: {color: 'rgba(0, 102, 0, .4)', name: 'Great', class: 'great_feel'},
        10: {color: 'rgba(26, 26, 255, .4)', name: 'Fantastic', class: 'fantastic_feel'}
    }; 

    var paramtype = "user";
    var sortparam = get('user');
    var limit = 10;
    var offset = 0;

    getLogFeed(paramtype, sortparam, limit, offset);

    function getLogFeed(paramtype, sortparam, limit, offset) {

        // Build an object of the logfeed parameters
        var params = new Object();
        params.paramtype = paramtype;
        params.sortparam = sortparam;
        params.limit = limit;
        params.offset = offset;

        // Encode the array of logfeed parameters
        var paramString = JSON.stringify(params);

        $.get('logdetails.php', {getlogs : paramString}, function(response) {

            var logfeed = JSON.parse(response);
            console.info(logfeed);
            if (logfeed.hasOwnProperty('logs') && Object.keys(logfeed.logs).length) {
                console.info("Populating the LogFeed...");
                populate(logfeed);
            } else {
                console.info("User has no logs to display.");
                $('#activityfeed').html('').append("<p class='nofeed'><i>No Activity</i></p>");
            }
        });
    }

    // Get the HTTP GET URI Parameters
    function get(name) {
       if ( name= (new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
          return decodeURIComponent(name[1]);
    }

    function populate(logfeed) {
        console.info(logfeed["logs"]["1"]["name"]);

        for (log in logfeed.logs) {
            var feel = String(logfeed["logs"][log]["feel"]);
            var log_id = "logid_" + log;
            var log_ident = "#" + log_id;

            $('#activityfeed').append("<div id='" + log_id + "' class='log' class='feed'>" +
                                "<p>" + String(logfeed["logs"][log]["name"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["date"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["location"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["type"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["distance"]) + " " + String(logfeed["logs"][log]["metric"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["time"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["description"]) + "</p>" +
                                "</div>");

            var background_color = FEEL_COLORS[feel]["color"];
            console.info(background_color);
            $(log_ident).css('background', background_color);
        }
        
    } 
});