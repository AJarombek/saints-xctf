/*
 * Author: Andrew Jarombek
 * Date: 11/5/2016 - 
 * JavaScript for displaying logs on profile pages, group pages, or the main page
 */

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

const monthNames = [
    "Jan.", "Feb.", "Mar.",
    "Apr.", "May", "Jun.", "Jul.",
    "Aug.", "Sep.", "Oct.",
    "Nov.", "Dec."
]; 

$(document).ready(function() {

    var path = window.location.pathname;
    console.info("Current Page: " + path);

    var paramtype, sortparam, limit, offset, page;

    limit = 10;
    offset = 0;

    // Set the API GET parameters based on which page we are on
    if (path == "/saints-xctf/profile.php") {
        page = "profile";
        paramtype = "user";
        sortparam = get('user');
    } else if (path == "/saints-xctf/index.php") {
        page = "main";
        paramtype = "all";
        sortparam = "all";
    } else if (path == "/saints-xctf/group.php") {
        page = "group";
        paramtype = "group";
        sortparam = get('group');
    }

    getLogFeed(paramtype, sortparam, limit, offset);

    $('#load_more_logs').on("click", function() {
        offset = offset + 10;
        getLogFeed(paramtype, sortparam, limit, offset);
    });

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
        log_count = 0;

        for (log in logfeed.logs) {
            log_count++;
            var feel = String(logfeed["logs"][log]["feel"]);
            var log_id = "logid_" + log;
            var log_ident = "#" + log_id;

            var dateString = String(logfeed["logs"][log]["date"]);
            var date = new Date(dateString);

            var day = date.getDate();
            var monthIndex = date.getMonth();
            var year = date.getFullYear();

            var formattedDate = monthNames[monthIndex] + ' ' + day + ' ' + year;

            var usernameDisplay;
            var username = String(logfeed["logs"][log]["username"]);

            // If this log is on the main page or a group page, display the username
            if (page == "group" || page == "main") {
                usernameDisplay = "<a class='loglink' href='profile.php?user=" + username + "'>" + username + "</a>"
            } else {
                usernameDisplay = "<h4></h4>";
            }

            $('#activityfeed').prepend("<div id='" + log_id + "' class='log' class='feed'>" + usernameDisplay +
                                "<p>" + String(logfeed["logs"][log]["name"]) + "</p>" +
                                "<p>" + formattedDate + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["type"]).toUpperCase() + "</p>" +
                                "<p>Location: " + String(logfeed["logs"][log]["location"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["distance"]) + " " + String(logfeed["logs"][log]["metric"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["time"]) + " (0:00/mi)</p>" +
                                "<p>" + String(logfeed["logs"][log]["description"]) + "</p>" +
                                "</div>");

            var background_color = FEEL_COLORS[feel]["color"];
            console.info(background_color);
            $(log_ident).css('background', background_color);
        }

        // If there are (probably) more logs to load from the database, add a button to load more
        if (log_count == 10) {
            $('#activityfeed').append("<input id='load_more_logs' class='submit' type='button' name='load_more' value='Load More'>");
        }
        
    }
});

function populateLog(log) {
    var feel = String(log["feel"]);
    var log_id = "logid_" + log;
    var log_ident = "#" + log_id;

    var dateString = String(log["date"]);
    var date = new Date(dateString);

    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();

    var formattedDate = monthNames[monthIndex] + ' ' + day + ' ' + year;

    var usernameDisplay = "<h4></h4>";
    var username = String(log["username"]);

    $('#activityfeed').prepend("<div id='" + log_id + "' class='log' class='feed'>" + usernameDisplay +
                        "<p>" + String(log["name"]) + "</p>" +
                        "<p>" + formattedDate + "</p>" +
                        "<p>" + String(log["type"]).toUpperCase() + "</p>" +
                        "<p>Location: " + String(log["location"]) + "</p>" +
                        "<p>" + String(log["distance"]) + " " + String(log["metric"]) + "</p>" +
                        "<p>" + String(log["time"]) + " (0:00/mi)</p>" +
                        "<p>" + String(log["description"]) + "</p>" +
                        "</div>");

    var background_color = FEEL_COLORS[feel]["color"];
    console.info(background_color);
    $(log_ident).css('background', background_color);
} 