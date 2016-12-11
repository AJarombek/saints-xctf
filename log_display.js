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
    var loc = null;

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
        sortparam = get('name');
    }

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
                populate(logfeed, loc);
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

    function populate(logfeed, loc) {
        log_count = 0;

        for (log in logfeed.logs) {
            log_count++;
            var feel = String(logfeed["logs"][log]["feel"]);
            var log_id = "logid_" + log;
            var comment_id = "logcommentid_" + log;
            var comment_ident = "#" + comment_id;
            var log_ident = "#" + log_id;

            var dateString = String(logfeed["logs"][log]["date"]);
            var date = new Date(dateString);

            // Javascript Bug calculating the date from string so just add one day
            date.setDate(date.getDate() + 1);

            var day = date.getDate();
            var monthIndex = date.getMonth();
            var year = date.getFullYear();

            var formattedDate = monthNames[monthIndex] + ' ' + day + ' ' + year;

            var usernameDisplay;
            var fullname = String(logfeed["logs"][log]["first"]) + " " + String(logfeed["logs"][log]["last"]);
            var username = String(logfeed["logs"][log]["username"]);

            var pace = String(logfeed["logs"][log]["pace"]);
            for (var i = 0; i < pace.length; i++) {
                c = pace.charAt(i);
                if (c != '0' && c != ':') {
                    pace = pace.substring(i, pace.length);
                    break;
                }
            }

            var description = String(logfeed["logs"][log]["description"]);
            if (description == 'null') {
                description = "";
            }

            // If this log is on the main page or a group page, display the username
            if (page == "group" || page == "main") {
                usernameDisplay = "<a class='loglink' href='profile.php?user=" + username + "'>" + fullname + "</a>"
            } else {
                usernameDisplay = "<h4></h4>";
            }

            var comments_display = "";
            var comments = logfeed["logs"][log]["comments"];

            console.info("Comments:");
            console.info(comments);

            for (comment in comments) {
                comment_username = String(logfeed["logs"][log]['comments'][comment]['username']);
                comment_first = String(logfeed["logs"][log]['comments'][comment]['first']);
                comment_last = String(logfeed["logs"][log]['comments'][comment]['last']);
                comment_time = String(logfeed["logs"][log]['comments'][comment]['time']);
                comment_content = String(logfeed["logs"][log]['comments'][comment]['content']);

                comments_display += "<div class='commentdisplay'>" + 
                                    "<p>" + comment_first + " " + comment_last + "</p>" +
                                    "<p>" + comment_time + "</p>" +
                                    "<p>" + comment_content + "</p>" +
                                    "</div>"
            }

            // Decide whether to append the log or insert it at the beginning
            if (loc == null) {

                $('#activityfeed').append("<div id='" + log_id + "' class='log' class='feed'>" + usernameDisplay +
                                "<p>" + String(logfeed["logs"][log]["name"]) + "</p>" +
                                "<p>" + formattedDate + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["type"]).toUpperCase() + "</p>" +
                                "<p>Location: " + String(logfeed["logs"][log]["location"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["distance"]) + " " + String(logfeed["logs"][log]["metric"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["time"]) + " (" + pace + "/mi)</p>" +
                                "<p>" + description + "</p>" +
                                "<input id='" + log_id + "' class='comment' class='input' type='text' maxlength='255' name='comment' placeholder='Comment'>" +
                                comments_display +
                                "</div>");

            } else {

                $("<div id='" + log_id + "' class='log' class='feed'>" + usernameDisplay +
                                "<p>" + String(logfeed["logs"][log]["name"]) + "</p>" +
                                "<p>" + formattedDate + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["type"]).toUpperCase() + "</p>" +
                                "<p>Location: " + String(logfeed["logs"][log]["location"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["distance"]) + " " + String(logfeed["logs"][log]["metric"]) + "</p>" +
                                "<p>" + String(logfeed["logs"][log]["time"]) + " (" + pace + "/mi)</p>" +
                                "<p>" + description + "</p>" +
                                "<input id='" + comment_id + "' class='comment' class='input' type='text' maxlength='255' name='comment' placeholder='Comment'>" +
                                comments_display +
                                "</div>").insertBefore(loc);
            }

            // Trigger event if the enter key is pressed when entering a comment
            $(comment_ident).keyup(function(e) {
                if (e.keyCode == 13) {
                    var comment_content = $(this).val().trim();
                    $(this).val('');
                    var commentid = $(this).attr('id');
                    commentid = commentid.substring(13, commentid.length);
                    submitComment(commentid, comment_content);
                }
            });

            var background_color = FEEL_COLORS[feel]["color"];
            console.info(background_color);
            $(log_ident).css('background', background_color);
            loc = log_ident;
        }

        // If there are (probably) more logs to load from the database, add a button to load more
        if (log_count == 10) {
            loc = '#load_more_logs';
            var loadLogs = $("<input id='load_more_logs' class='submit' type='button' name='load_more' value='Load More'>");
            $('#activityfeed').append(loadLogs);

            $('#load_more_logs').on("click", function() {
                $('#load_more_logs').remove();
                offset = offset + 10;
                getLogFeed(paramtype, sortparam, limit, offset);
            });
        }
        
    }
});

function populateLog(logobject) {

    for (log in logobject) {
        var feel = String(logobject[log]["feel"]);
        var log_id = "logid_" + log;
        var comment_id = "commentid_" + log;
        var log_ident = "#" + log_id;

        var dateString = String(logobject[log]["date"]);
        var date = new Date(dateString);
        date.setDate(date.getDate() + 1);

        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();

        var formattedDate = monthNames[monthIndex] + ' ' + day + ' ' + year;

        var pace = String(logobject[log]["pace"]);
        for (var i = 0; i < pace.length; i++) {
            c = pace.charAt(i);
            if (c != '0' && c != ':') {
                pace = pace.substring(i, pace.length);
                break;
            }
        }

        var description = String(logobject[log]["description"]);
        if (description == 'null') {
            description = "";
        }

        var usernameDisplay = "<h4></h4>";

        $('#activityfeed').prepend("<div id='" + log_id + "' class='log' class='feed'>" + usernameDisplay +
                            "<p>" + String(logobject[log]["name"]) + "</p>" +
                            "<p>" + formattedDate + "</p>" +
                            "<p>" + String(logobject[log]["type"]).toUpperCase() + "</p>" +
                            "<p>Location: " + String(logobject[log]["location"]) + "</p>" +
                            "<p>" + String(logobject[log]["distance"]) + " " + String(logobject[log]["metric"]) + "</p>" +
                            "<p>" + String(logobject[log]["time"]) + " (" + pace + "/mi)</p>" +
                            "<p>" + description + "</p>" +
                            "<input id='" + comment_id + "' class='comment' class='input' type='text' maxlength='255' name='comment' placeholder='Comment'>" +
                            "</div>");

        var background_color = FEEL_COLORS[feel]["color"];
        console.info(background_color);
        $(log_ident).css('background', background_color);
    }
} 

function submitComment(id, content) {    

    // Build an object of the comment parameters
    var commentObject = new Object();
    commentObject.content = content;
    commentObject.log_id = id;

    // Encode the array of comment parameters
    var commentString = JSON.stringify(commentObject);

    $.post('logdetails.php', {submitcomment : commentString}, function(response) {

        var newcomment = JSON.parse(response);
        console.info(newcomment);
        if (newcomment != 'false') {
            console.info("Populating new Comment...");

            for (newcom in newcomment) {
                var addTo = "#logid_" + id;
                console.info(addTo);

                $(addTo).append("<div class='commentdisplay'>" + 
                            "<p>" + newcomment[newcom]['first'] + " " + newcomment[newcom]['last'] + "</p>" +
                            "<p>" + newcomment[newcom]['time'] + "</p>" +
                            "<p>" + newcomment[newcom]['content'] + "</p>" +
                            "</div>");
            }
        } else {
            console.error("Added Comment Failed.");
        }
    });
}