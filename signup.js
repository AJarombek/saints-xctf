$(document).ready(function() {
                
    var username, first, last, password, cpassword;
    var regexUsername = new RegExp("^[a-zA-Z0-9]+$");
    var regexName = new RegExp("^[a-zA-Z\-']+$");
    
    var username_ok = false;
    var first_ok = false;
    var last_ok = false;
    var password_ok = false;
    var cpassword_ok = false;
    
    // When Username Is Altered, check if it is in a valid format
    $('#su_username').keyup(function() {
        username = $('#su_username').val().trim();
        
        $.post('authenticate_username.php', {un : username}, function(response) {
            
            if (response === 'false' && regexUsername.test(username)) {
                // Valid Username
                $('#su_username').css('border', '1px solid');
                $('#su_username').css('border-color', 'green');
                $('#su_username').css('box-shadow', '0 0 7px #00ee00');
                username_ok = true;
                checkReady();
            } else {
                // Inalid Username
                $('#su_username').css('border-color', 'red');
                $('#su_username').css('box-shadow', '0 0 7px #ee0000');
                username_ok = false;
                checkReady();
            }
        });
    });
    
    // When First Name Is Altered, check if it is in a valid format
    $('#su_first').keyup(function() {
        first = $('#su_first').val().trim();
        if (regexName.test(first)) {
            // Valid First Name
            $('#su_first').css('border', '1px solid');
            $('#su_first').css('border-color', 'green');
            $('#su_first').css('box-shadow', '0 0 7px #00ee00');
            first_ok = true;
            checkReady();
        } else {
            // Invalid First Name
            $('#su_first').css('border-color', 'red');
            $('#su_first').css('box-shadow', '0 0 7px #ee0000');
            first_ok = false;
            checkReady();
        }
    });
    
    // When Last Name Is Altered, check if it is in a valid format
    $('#su_last').keyup(function() {
        last = $('#su_last').val().trim();
        if (regexName.test(last)) {
            // Valid Last Name
            $('#su_last').css('border', '1px solid');
            $('#su_last').css('border-color', 'green');
            $('#su_last').css('box-shadow', '0 0 7px #00ee00');
            last_ok = true;
            checkReady();
        } else {
            // Invalid Last Name
            $('#su_last').css('border-color', 'red');
            $('#su_last').css('box-shadow', '0 0 7px #ee0000');
            last_ok = false;
            checkReady();
        }
    });
    
    // When Password Is Altered, check if it is in a valid format
    $('#su_password').keyup(function() {
        
        password = $('#su_password').val().trim();
        if (password.length > 5) {
            // Valid Password
            $('#su_password').css('border', '1px solid');
            $('#su_password').css('border-color', 'green');
            $('#su_password').css('box-shadow', '0 0 7px #00ee00');
            
            // check if it matches the confirmed password
            if (password == cpassword) {
                $('#su_cpassword').css('border', '1px solid');
                $('#su_cpassword').css('border-color', 'green');
                $('#su_cpassword').css('box-shadow', '0 0 7px #00ee00');
                cpassword_ok = true;
            }
            password_ok = true;
            checkReady();
        } else {
            // Invalid Password
            $('#su_password').css('border-color', 'red');
            $('#su_password').css('box-shadow', '0 0 7px #ee0000');
            password_ok = false;
            checkReady();
        }
    });
    
    // When Confirm Password Is Altered, check if it is in a valid format
    $('#su_cpassword').keyup(function() {
        cpassword = $('#su_cpassword').val().trim();
        if (cpassword.length > 5 && password == cpassword) {
            // Valid Confirmed Password
            $('#su_cpassword').css('border', '1px solid');
            $('#su_cpassword').css('border-color', 'green');
            $('#su_cpassword').css('box-shadow', '0 0 7px #00ee00');
            cpassword_ok = true;
            checkReady();
        } else {
            // Invalid Confirmed Password
            $('#su_cpassword').css('border-color', 'red');
            $('#su_cpassword').css('box-shadow', '0 0 7px #ee0000');
            c_password_ok = false;
            checkReady();
        }
    });
    
    // Try to Add a User and Make Them Pick Groups
    $('#su_submit').on('click', function(event) {
        $.post('adduser.php', {userDetails : [username,first,last,password]}, function(response) {
            
            if (response === 'true') {
                window.location = 'pickgroups.php';
            } else {
                window.location = 'index.php';
            }
        });
    });
    
    // If all the values are submitted properly
    function checkReady() {
        if (username_ok && first_ok && last_ok && password_ok && cpassword_ok) {
            $('#su_submit').removeAttr('disabled');
            $('#su_submit').css('border-color', 'black');
        } else {
            $('#su_submit').attr('disabled','true');
            $('#su_submit').css('border-color', '#999');
        }
    }
    
});