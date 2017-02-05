/*
 * Author: Andrew Jarombek
 * Date: 2/5/2017 - 
 * JavaScript for the edit log form
 */

$(document).ready(function() {

    // Array of Objects for the different feel parameters
    var feel = {
        1: {color: 'rgba(204, 0, 0, .4)', name: 'Terrible', class: 'terrible_feel'},
        2: {color: 'rgba(255, 51, 0, .4)', name: 'Very Bad', class: 'very_bad_feel'},
        3: {color: 'rgba(204, 102, 0, .4)', name: 'Bad', class: 'bad_feel'},
        4: {color: 'rgba(255, 153, 0, .4)', name: 'Pretty Bad', class: 'pretty_bad_feel'},
        5: {color: 'rgba(255, 255, 51, .4)', name: 'Mediocre', class: 'mediocre_feel'},
        6: {color: 'rgba(187, 187, 187, .4)', name: 'Average', class: 'average_feel'},
        7: {color: 'rgba(115, 230, 0, .4)', name: 'Fairly Good', class: 'fairly_good_feel'},
        8: {color: 'rgba(0, 153, 0, .4)', name: 'Good', class: 'good_feel'},
        9: {color: 'rgba(0, 102, 0, .4)', name: 'Great', class: 'great_feel'},
        10: {color: 'rgba(26, 26, 255, .4)', name: 'Fantastic', class: 'fantastic_feel'}
    };

    // Use the get parameter logno to get log details
    var query = window.location.search.substring(1);
    query = query.substring(6, query.length);
    console.info(query);

    $.get('editlogdetails.php', {getlog : query}, function(response) {

        var log = JSON.parse(response);
        console.info(log);
        populate(log);
    });

    // Populate the initial form values
    function populate(log) {

        setName(log['name']);
        setLocation(log['location']);
        setDate(log['date']);
        setType(log['type']);
        setDistance(log['distance']);
        setMetric(log['metric']);
        setFeel(log['feel']);
        setDescription(log['description']);
        
        if (distance != null) {
            $('#log_distance').val(distance);
        }
    }

    // Setters for the input forms

    function setName(name) {
        $('#log_name').val(name);
    }

    function setLocation(location) {
        if (location != null) {
            $('#log_location').val(location);
        }
    }

    function setDate(date) {
        $('#log_date').val(date);
    }

    function setType(type) {
        $('#log_type').val(type);
    }

    function setDistance(distance) {
        if (distance != null && distance != 0) {
            $('#log_distance').val(distance);
        }
    }

    function setMetric(metric) {
        $('#log_metric').val(metric);
    }

    function setTime(time) {
        hours = parseInt(time.substring(0,2));
        minutes = parseInt(time.substring(3,5) + (hours * 60));
        seconds = time.substring(6,8);

        $('#log_minutes').val(minutes);
        $('#log_seconds').val(seconds);
    }

    function setFeel(logfeel) {
        $('#log_feel').val(logfeel);
        var feel_params = feel[logfeel];
        rangeBackground(feel_params);
        rangeTag(feel_params);
    }

    function setDescription(description) {
        if (description != null) {
            $('#log_description').val(description);
        }
    }

    function getValues() {
        // Get all of the log form inputs
        var log_name = $('#log_name').val().trim();
        var log_location = $('#log_location').val().trim();
        var log_date = $('#log_date').val().trim();
        var log_type = $('#log_type').val().trim();
        var log_distance = $('#log_distance').val().trim();
        var log_metric = $('#log_metric').val().trim();
        var log_minutes = $('#log_minutes').val().trim();
        var log_seconds = $('#log_seconds').val().trim();
        var log_feel = $('#log_feel').val().trim();
        var log_description = $('#log_description').val().trim();

        var log = {
            name: log_name,
            location: log_location,
            date: log_date,
            type: log_type,
            distance: log_distance,
            metric: log_metric,
            time: log_time,
            feel: log_feel,
            description: log_description
        };

        return log;
    }

    // Function for when you want to cancel the edit log changes
    $('#log_cancel').on('click', function() {
        // Go back to the previous page
        window.history.back();
    });

    // function for when the user submits the log changes
    $('#log_submit').on('click', function() {
        log = getValues();
    });

    // When the log feel is changed, get its value and call rangeBackground and rangeTag
    $('#log_feel').on("change mousemove", function() {
        log_feel = $(this).val().trim();
        var feel_params = feel[log_feel];
        rangeBackground(feel_params);
        rangeTag(feel_params);
    });

    // Changes the color of the log input form background depending on the feel 
    function rangeBackground(feel_params) {
        var background_color = feel_params.color;
        $('#editactivityinput').css('background', background_color);
    }

    // Changes the text in the feel tag in the log input from 
    function rangeTag(feel_params) {
        $('#feel_hint').html('').append(feel_params.name);
    }
});