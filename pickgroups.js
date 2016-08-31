/*
 * Author: Andrew Jarombek
 * Date: 6/4/2016 - 
 * JavaScript for the picking groups form
 */

$(document).ready(function() {

    // Variable with a boolean value for if the team was picked or not
    var womensxc, mensxc, womenstf, menstf, alumni;

    // Check to see if the user is already a member of any team
    $.get('getmaindetails.php', {alreadypicked : true}, function(response) {
        var teams = JSON.parse(response);
        console.info("teams already picked ", teams);

        womensxc = ($.inArray("Women's Cross Country", teams) !== -1);
        mensxc = ($.inArray("Men's Cross Country", teams) !== -1); 
        womenstf = ($.inArray("Women's Track & Field", teams) !== -1); 
        menstf = ($.inArray("Men's Track & Field", teams) !== -1); 
        alumni = ($.inArray("Alumni", teams) !== -1);

        // Disable appropriate team joining options based on previously picked teams
        if (womensxc) {
            $('#join_womensxc').trigger('click');
            console.info("womensxc already picked");
        }
        if (mensxc) {
            $('#join_mensxc').trigger('click');
            console.info("mensxc already picked");
        }
        if (womenstf) {
            $('#join_womenstf').trigger('click');
            console.info("womenstf already picked");
        }
        if (menstf) {
            $('#join_menstf').trigger('click');
            console.info("menstf already picked");
        }
        if (alumni) {
            $('#join_alumni').trigger('click');
            console.info("alumni already picked");
        }
    });  
    
    // Select or Deselect joining WomensXC
    $('#join_womensxc').on('click', function() {
        var selected = $('#join_womensxc').attr('class');
        if (selected === 'selected') {
            unjoined('#join_womensxc');
            womensxc = false;
            if (womenstf == false && alumni == false) {
                $('#join_mensxc').removeAttr('disabled');
                $('#join_menstf').removeAttr('disabled');
                $('#join_alumni').removeAttr('disabled');
            }
            
        } else {
            joined('#join_womensxc');
            womensxc = true;
            $('#join_mensxc').attr('disabled', 'true');
            $('#join_menstf').attr('disabled', 'true');
            $('#join_alumni').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_mensxc').on('click', function() {
        var selected = $('#join_mensxc').attr('class');
        if (selected === 'selected') {
            unjoined('#join_mensxc');
            mensxc = false;
            if (menstf == false && alumni == false) {
                $('#join_womensxc').removeAttr('disabled');
                $('#join_womenstf').removeAttr('disabled');
                $('#join_alumni').removeAttr('disabled');
            }
            
        } else {
            joined('#join_mensxc');
            mensxc = true;
            $('#join_womensxc').attr('disabled', 'true');
            $('#join_womenstf').attr('disabled', 'true');
            $('#join_alumni').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_womenstf').on('click', function() {
        var selected = $('#join_womenstf').attr('class');
        if (selected === 'selected') {
            unjoined('#join_womenstf');
            womenstf = false;
            if (womensxc == false && alumni == false) {
                $('#join_mensxc').removeAttr('disabled');
                $('#join_menstf').removeAttr('disabled');
                $('#join_alumni').removeAttr('disabled');
            }
            
        } else {
            joined('#join_womenstf');
            womenstf = true;
            $('#join_mensxc').attr('disabled', 'true');
            $('#join_menstf').attr('disabled', 'true');
            $('#join_alumni').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_menstf').on('click', function() {
        var selected = $('#join_menstf').attr('class');
        if (selected === 'selected') {
            unjoined('#join_menstf');
            menstf = false;
            if (mensxc == false && alumni == false) {
                $('#join_womensxc').removeAttr('disabled');
                $('#join_womenstf').removeAttr('disabled');
                $('#join_alumni').removeAttr('disabled');
            }
            
        } else {
            joined('#join_menstf');
            menstf = true;
            $('#join_womensxc').attr('disabled', 'true');
            $('#join_womenstf').attr('disabled', 'true');
            $('#join_alumni').attr('disabled', 'true');
        }
        ready();
    });
    
    // Select or Deselect joining WomensXC
    $('#join_alumni').on('click', function() {
        var selected = $('#join_alumni').attr('class');
        if (selected === 'selected') {
            unjoined('#join_alumni');
            alumni = false;
            if (mensxc == false && menstf == false && womensxc == false && womenstf == false) {
                $('#join_mensxc').removeAttr('disabled');
                $('#join_menstf').removeAttr('disabled');
                $('#join_womensxc').removeAttr('disabled');
                $('#join_womenstf').removeAttr('disabled');
            }
            
        } else {
            joined('#join_alumni');
            alumni = true;
            $('#join_mensxc').attr('disabled', 'true');
            $('#join_menstf').attr('disabled', 'true');
            $('#join_womensxc').attr('disabled', 'true');
            $('#join_womenstf').attr('disabled', 'true');
        }
        ready();
    });

    $('#join').on('click', function() {
        
        // Build an array of all the teams that the user joined
        var joined = [];
        if (mensxc)
            joined.push('mensxc');
        if (womensxc)
            joined.push('wmensxc');
        if (menstf)
            joined.push('menstf');
        if (womenstf)
            joined.push('wmenstf');
        if (alumni)
            joined.push('alumni');
        
        console.info("Joining teams: ", joined);

        // Encode the array of teams to join
        var joinedString = JSON.stringify(joined);

        // Send an AJAX request to subscribe the user to teams in the database
        $.post('addgroups.php', {teams : joinedString}, function(response) {
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
        if (womensxc || mensxc || womenstf || menstf || alumni) {
            $('#join').removeAttr('disabled');
            $('#join').addClass('submitable');
        } else {
            $('#join').attr('disabled', 'true');
            $('#join').removeClass('submitable');
        }
    }
});