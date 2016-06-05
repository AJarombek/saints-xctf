/*
 * Author: Andrew Jarombek
 * Date: 6/4/2016 - 
 * JavaScript for the picking groups form
 */

$(document).ready(function() {
    
    var womensxc = false;
    var mensxc = false;
    var womenstf = false;
    var menstf = false;
    var alumni = false;
    
    // Forms Fade In on Document Ready            
    var forms = $('#forms');
    forms.hide().delay(10).fadeIn(500);
    
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