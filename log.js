/*
 * Author: Andrew Jarombek
 * Date: 6/6/2017
 * JavaScript for the single log view
 * Functions and variables are in log_utils.js
 */

$(document).ready(function() {

    // Use the get parameter logno to get log details
    var query = window.location.search.substring(1);
    query = query.substring(6, query.length);
    console.info(query);

    $.get('editlogdetails.php', {getlog : query}, function(response) {

        var log = JSON.parse(response);
        console.info(log);
        populateLog(log);
    });
});