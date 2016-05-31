<!--
Author: Andrew Jarombek
Date: 5/23/2016 - 
Main Signed Out Page HTML Code
-->

    <body>
        <header id='signedoutmenu'>
            <div id='menucontents'>
                <a href='index.php'><img id='sitelogo' src='views/images/logo.jpg' alt='logo'><label id='sitetitle'>SaintsXCTF</label></a>
                <div id='menulinks'>
                    <li id='aboutus'><a href='#aboutusdisplay'>ABOUT US</a></li>
                    <li id='features'><a href='#featuresdisplay'>FEATURES</a></li>
                    <li class='active' id='home'><a href='#homedisplay'>HOME</a></li>
                </div>
            </div>
        </header>
        <div id='homedisplay'>
            <div id='mainbody'>
                <div id='forms'>
                    <h1>Saints XC Running Logs</h1>
                    <div id=register>
                        <h2>Register</h2>
                        <input id='su_username' class='input' type='text' maxlength='30' name='username' placeholder='Username'><br>
                        <input id='su_first' class='input' type='text' maxlength='30' name='first' placeholder='First Name'><br>
                        <input id='su_last' class='input' type='text' maxlength='30' name='last' placeholder='Last Name'><br>
                        <input id='su_password' class='input' type='password' maxlength='40' name='password' placeholder='Password'><br>
                        <input id='su_cpassword' class='input' type='password' maxlength='40' name='confirmpassword' placeholder='Confirm Password'><br>
                        <input id='su_submit' class='submit' type='button' name='register' disabled='true' value='Register'><br>
                    </div><!-- End Register -->
                    <div id=signin>
                        <h2>Sign In</h2>
                        <input id='si_username' class='input' type='text' maxlength='30' name='username' placeholder='Username'><br>
                        <input id='si_password' class='input' type='password' maxlength='40' name='password' placeholder='Password'><br>
                        <input id='si_submit' class='submit' type='button' name='signin' disabled='true' value='Sign In'><br>
                    </div><!-- End SignIn -->
                </div><!-- End Forms -->
            </div><!-- End MainBody -->
        </div><!-- End HomeDisplay -->
        <div id='featuresdisplay'>
            <h1>Features</h1>
        </div>
        <div id='aboutusdisplay'>
            <h1>About Us</h1>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>
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
                    if (regexUsername.test(username)) {
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
                
                $('#su_submit').on('click', function(event) {
                    
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
        </script>
        <script>
            $(document).ready(function() {
                
                $('#si_submit').on('click', function(event) {
                    var username = $('#su_username').val.trim();
                    var password = $('#su_password').val.trim();
                });
            });
        </script>
    </body>