/*
 * Author: Andrew Jarombek
 * Date: 11/8/2016 - 2/20/2017
 * JavaScript for the edit profile page form
 * Version 0.4 (BETA) - 12/24/2016
 * Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
 * Version 0.6 (GROUPS UPDATE) - 2/20/2017
 */

$(document).ready(function() {

    var group,description,week_start,grouppic,grouppic_name;
    var grouppic_error;

    // First get the profile details to fill in current details
    var groupJSON = getGroupInfo();

    // When the group finishes uploading a file for the profile picture
    $('#file').on('change', function() {
        var v = this.value;
        grouppic_name = v.replace(/.*[\/\\]/, '');
        var size;

        var files = this.files;

        // If there are no uploaded files
        if (!files) {
            grouppic_error = "File upload not supported by your browser.";
        }

        if (files && files[0]) {
            var file = files[0];
            size = file.size;
            console.info("File Uploaded: ", file);

            // Make sure that the filename ends in .png, .jpeg, .jpg, or .gif
            if ((/\.(png|jpeg|jpg|gif)$/i).test(file.name)) {
                readImage(file);
            } else {
                grouppic_error = file.name +" Unsupported Image extension.";  
            }
        }

        console.info('Selected file: ' + grouppic_name);
        console.info('Selected file size: ' + size);
    });

    // Helper function to read the image with a fileReader and load it to the page
    function readImage(file) {
        var reader = new FileReader();
        reader.readAsDataURL(file);

        // At this point the file has been read
        reader.addEventListener("load", function() {
            $('#groupPic').attr("src", this.result);
            grouppic = this.result;
        });
    }

    // Function for when you want to cancel the edit profile changes
    $('#edit_cancel').on('click', function() {
        // Go back to the profile page
        window.history.back();
    });

    // Function for when you want to submit the edit profile changes
    $('#edit_submit').on('click', function() {

        if (description === undefined || (description = getDescription()).length != 0)
            group.description = description;
        if (week_start === undefined || (week_start = getWeekStart()).length != 0)
            group.week_start = week_start;

        if (grouppic != null)
            group.grouppic = grouppic;
        if (grouppic_name != null)
            group.grouppic_name = grouppic_name;

        // Encode the array of group information
        var groupString = JSON.stringify(group);

        console.info("New Group Info: ", groupString);

        // Send an AJAX request to update the group profile information
        $.post('editgroupdetails.php', {updategroupinfo : groupString}, function(response) {
            if (response == 'true') {
                window.history.back();
            } else {
                $("#edit_error").html('').append("<i class='material-icons md-18 error'>error</i><b>Server Error: Unable to Edit Group</b>");
            }
        });
    });

    // Get the Profile Details to fill in form values
    function getGroupInfo() {
        var groupJSON;
        var groupname = get('name');
        console.info(groupname);

        $.get('editgroupdetails.php', {getgroupinfo : groupname}, function(response) {
            if (response != null) {
                console.info("Group Info: ", response);
                groupJSON = response;
                group = JSON.parse(groupJSON);
                setValues(group);
            } else {
                console.error("FAILED to get Group Information.");
            }
        });
        return group;
    }

    // Sets the current values for the fields if they exist
    function setValues(group) {
        console.info("Group:", group);
        description = String(group['description']);
        week_start = String(group['week_start']);

        if (description != 'null' && description != 'undefined') {
            setDescription(description);
        }
        if (week_start != 'null' && week_start != 'undefined') {
            setWeekStart(week_start);
        }
    }

    // GETTERS AND SETTERS FOR THE FORM

    // Get the value in the Description input
    function getDescription() {
        var description = $('#edit_description').val().trim();
        return description;
    }

    // Set the value in the Description input
    function setDescription(description) {
        console.info("Setting the Current Description: ", description);
        $('#edit_description').val(description);
    }

    // Get the value in the Week Start Radio Button
    function getWeekStart() {
        var week_start = $('input[name=week_start]:checked').val();
        return week_start;
    }

    // Set the value in the Week Start Radio Button
    function setWeekStart(week_start) {
        console.info("Setting the Current Week Start: ", week_start);
        $("input[name=week_start][value='" + week_start + "']").prop("checked", true);
    }
});