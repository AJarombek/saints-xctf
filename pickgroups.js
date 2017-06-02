/*
 * Author: Andrew Jarombek
 * Date: 6/4/2016 - 6/2/2017
 * JavaScript for the picking groups form
 * Version 0.4 (BETA) - 12/24/2016
 * Version 1.0 (OFFICIAL RELEASE) - 6/2/2017
 */

// Variable with a boolean value for if the team was picked or not
// These need to be of global visibility to use in other files
var wmensxc, mensxc, wmenstf, menstf, alumni = null;

var wmensxc_admin = 'user';
var mensxc_admin = 'user';
var wmenstf_admin = 'user';
var menstf_admin = 'user';
var alumni_admin = 'user';

var wmensxc_status = 'pending';
var mensxc_status = 'pending';
var wmenstf_status = 'pending';
var menstf_status = 'pending'; 
var alumni_status = 'pending';

$(document).ready(function() {

    // Check to see if the user is already a member of any team
    $.get('getmaindetails.php', {alreadypicked : true}, function(response) {
        var teams = JSON.parse(response);
        console.info("Teams already picked ", teams);

        for (i in teams) {
            var teamName = teams[i]['group_name'];
            var teamStatus = teams[i]['status'];
            var teamAdmin = teams[i]['admin'];

            if (teamName == 'mensxc') {
                mensxc = true;
                mensxc_status = teamStatus;
                mensxc_admin = teamAdmin;
            }
            if (teamName == 'wmensxc') {
                wmensxc = true;
                wmensxc_status = teamStatus;
                wmensxc_admin = teamAdmin; 
            }
            if (teamName == 'menstf') {
                menstf = true; 
                menstf_status = teamStatus;
                menstf_admin = teamAdmin;
            }
            if (teamName == 'wmenstf') {
                wmenstf = true; 
                wmenstf_status = teamStatus;
                wmenstf_admin = teamAdmin;
            }
            if (teamName == 'alumni') {
                alumni = true;
                alumni_status = teamStatus;
                alumni_admin = teamAdmin;
            }
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
        if (selected === 'selected' || selected === 'selected_pending') {
            unjoined('#join_womensxc');
            wmensxc = null;
            if (wmenstf == null) {
                $('#join_mensxc').removeAttr('disabled');
                $('#join_menstf').removeAttr('disabled');
            }
            
        } else {
            joined('#join_womensxc', wmensxc_status);
            wmensxc = true;
            $('#join_mensxc').attr('disabled', 'true');
            $('#join_menstf').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_mensxc').on('click', function() {
        var selected = $('#join_mensxc').attr('class');
        if (selected === 'selected' || selected === 'selected_pending') {
            unjoined('#join_mensxc');
            mensxc = null;
            if (menstf == null) {
                $('#join_womensxc').removeAttr('disabled');
                $('#join_womenstf').removeAttr('disabled');
            }
            
        } else {
            joined('#join_mensxc', mensxc_status);
            mensxc = true;
            $('#join_womensxc').attr('disabled', 'true');
            $('#join_womenstf').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_womenstf').on('click', function() {
        var selected = $('#join_womenstf').attr('class');
        if (selected === 'selected' || selected === 'selected_pending') {
            unjoined('#join_womenstf');
            wmenstf = null;
            if (wmensxc == null) {
                $('#join_mensxc').removeAttr('disabled');
                $('#join_menstf').removeAttr('disabled');
            }
            
        } else {
            joined('#join_womenstf', wmenstf_status);
            wmenstf = true;
            $('#join_mensxc').attr('disabled', 'true');
            $('#join_menstf').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_menstf').on('click', function() {
        var selected = $('#join_menstf').attr('class');
        if (selected === 'selected' || selected === 'selected_pending') {
            unjoined('#join_menstf');
            menstf = null;
            if (mensxc == null) {
                $('#join_womensxc').removeAttr('disabled');
                $('#join_womenstf').removeAttr('disabled');
            }
            
        } else {
            joined('#join_menstf', menstf_status);
            menstf = true;
            $('#join_womensxc').attr('disabled', 'true');
            $('#join_womenstf').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_alumni').on('click', function() {
        var selected = $('#join_alumni').attr('class');
        if (selected === 'selected' || selected === 'selected_pending') {
            unjoined('#join_alumni');
            alumni = null;
        } else {
            joined('#join_alumni', alumni_status);
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
    function joined(selector, status) {
        $(selector).removeClass('select');

        if (status == 'pending') {
            $(selector).addClass('selected_pending');
        } else {
            $(selector).addClass('selected');
        }
    }
    
    // Deselect a group to join
    function unjoined(selector) {
        $(selector).removeClass('selected');
        $(selector).removeClass('selected_pending');
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