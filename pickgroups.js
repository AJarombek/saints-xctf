/*
 * Author: Andrew Jarombek
 * Date: 6/4/2016 - 12/24/2016
 * JavaScript for the picking groups form
 * Version 0.4 (BETA) - 12/24/2016
 */

// Variable with a boolean value for if the team was picked or not
// These need to be of global visibility to use in other files
var wmensxc, mensxc, wmenstf, menstf, alumni = null;

$(document).ready(function() {

    // Check to see if the user is already a member of any team
    $.get('getmaindetails.php', {alreadypicked : true}, function(response) {
        var teams = JSON.parse(response);
        console.info("teams already picked ", teams);

        for (i in teams) {
            var teamName = teams[i]['group_name'];
            if (teamName == 'mensxc')
                mensxc = true;
            if (teamName == 'wmensxc')
                wmensxc = true; 
            if (teamName == 'menstf')
                menstf = true; 
            if (teamName == 'wmenstf')
                wmenstf = true; 
            if (teamName == 'alumni')
                alumni = true;
        }

        // Disable appropriate team joining options based on previously picked teams
        if (wmensxc != null) {
            $('#join_womensxc').trigger('click');
            console.info("womensxc already picked");
        }
        if (mensxc != null) {
            $('#join_mensxc').trigger('click');
            console.info("mensxc already picked");
        }
        if (wmenstf != null) {
            $('#join_womenstf').trigger('click');
            console.info("womenstf already picked");
        }
        if (menstf != null) {
            $('#join_menstf').trigger('click');
            console.info("menstf already picked");
        }
        if (alumni != null) {
            $('#join_alumni').trigger('click');
            console.info("alumni already picked");
        }
    });  
    
    // Select or Deselect joining WomensXC
    $('#join_womensxc').on('click', function() {
        var selected = $('#join_womensxc').attr('class');
        if (selected === 'selected') {
            unjoined('#join_womensxc');
            wmensxc = null;
            if (wmenstf == null && alumni == null) {
                $('#join_mensxc').removeAttr('disabled');
                $('#join_menstf').removeAttr('disabled');
            }
            
        } else {
            joined('#join_womensxc');
            wmensxc = true;
            $('#join_mensxc').attr('disabled', 'true');
            $('#join_menstf').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_mensxc').on('click', function() {
        var selected = $('#join_mensxc').attr('class');
        if (selected === 'selected') {
            unjoined('#join_mensxc');
            mensxc = null;
            if (menstf == null && alumni == null) {
                $('#join_womensxc').removeAttr('disabled');
                $('#join_womenstf').removeAttr('disabled');
            }
            
        } else {
            joined('#join_mensxc');
            mensxc = true;
            $('#join_womensxc').attr('disabled', 'true');
            $('#join_womenstf').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_womenstf').on('click', function() {
        var selected = $('#join_womenstf').attr('class');
        if (selected === 'selected') {
            unjoined('#join_womenstf');
            wmenstf = null;
            if (wmensxc == null && alumni == null) {
                $('#join_mensxc').removeAttr('disabled');
                $('#join_menstf').removeAttr('disabled');
            }
            
        } else {
            joined('#join_womenstf');
            wmenstf = true;
            $('#join_mensxc').attr('disabled', 'true');
            $('#join_menstf').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_menstf').on('click', function() {
        var selected = $('#join_menstf').attr('class');
        if (selected === 'selected') {
            unjoined('#join_menstf');
            menstf = null;
            if (mensxc == null && alumni == null) {
                $('#join_womensxc').removeAttr('disabled');
                $('#join_womenstf').removeAttr('disabled');
            }
            
        } else {
            joined('#join_menstf');
            menstf = true;
            $('#join_womensxc').attr('disabled', 'true');
            $('#join_womenstf').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_alumni').on('click', function() {
        var selected = $('#join_alumni').attr('class');
        if (selected === 'selected') {
            unjoined('#join_alumni');
            alumni = null;
        } else {
            joined('#join_alumni');
            alumni = true;
        }
        ready();
    });

    $('#join').on('click', function() {
        
        // Build an object of all the teams that the user joined
        var joined = new Object();
        if (mensxc != null)
            joined.mensxc = "Men's Cross Country";
        if (wmensxc != null)
            joined.wmensxc = "Women's Cross Country";
        if (menstf != null)
            joined.menstf = "Men's Track & Field";
        if (wmenstf != null)
            joined.wmenstf = "Women's Track & Field";
        if (alumni != null)
            joined.alumni = "Alumni";

        // Encode the array of teams to join
        var joinedString = JSON.stringify(joined);

        console.info("Joining teams: ", joinedString);

        // Send an AJAX request to subscribe the user to teams in the database
        $.post('addgroups.php', {groups : joinedString}, function(response) {
            console.info("The response to add teams is ", response);
            if (response == 'true') {
                console.info("Successfully picked teams, proceed to main.php");
                window.location = 'index.php';
            } else {
                console.error("Failed to add teams");
                window.location = 'pickgroups.php';
            }
        });
    });
    
    // Select a group to join
    function joined(selector) {
        $(selector).removeClass('select');
        $(selector).addClass('selected');
    }
    
    // Deselect a group to join
    function unjoined(selector) {
        $(selector).removeClass('selected');
        $(selector).addClass('select');
    }
    
    // Check if the form is ready to submit
    function ready() {
        if (wmensxc || mensxc || wmenstf || menstf || alumni) {
            $('#join').removeAttr('disabled');
            $('#join').addClass('submitable');
        } else {
            $('#join').attr('disabled', 'true');
            $('#join').removeClass('submitable');
        }
    }
});