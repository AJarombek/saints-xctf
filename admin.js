/*
 * Author: Andrew Jarombek
 * Date: 4/3/2017
 * JavaScript for interacting with the admin panel
 */

$(document).ready(function() {

    var groupadminJSON = $('#group_data').val();
    var groupadmindata = JSON.parse(groupadminJSON);

    var members = groupadmindata['members'];
    console.info(members);
    
    for (member in members) {
        if (members[member]['status'] == 'pending') {
            var username = members[member]['username'];
            var first = members[member]['first'];
            var last = members[member]['last'];
            console.info("pending user: " + first + " " + last);
            pendingUser(username, first, last);
        }
    }
});

function pendingUser(username, first, last) {

    var rejectId = 'reject_user' + username;
    var acceptId = 'accept_user' + username;

    $('#addusers').append("<div><h5>" + first + " " + last + "</h5>" + 
        "<input id='" + acceptId + "' class='submit adduserbutton' type='button' value='Accept'>" + 
        "<input id='" + rejectId + "' class='submit removeuserbutton' type='button' value='Reject'></div>");
}