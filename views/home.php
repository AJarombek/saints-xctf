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
        <script src="signup.js"></script>
        <script src="signin.js"></script>
    </body>