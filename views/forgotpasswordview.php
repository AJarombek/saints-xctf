<!--
Author: Andrew Jarombek
Date: 5/28/2016 - 1/9/2017
Forgot Password Page HTML Code
-->

    <body>
        <header id='signedoutmenu'>
            <div id='menucontents'>
                <a href='index.php'><img id='sitelogo' src='views/images/logo.jpg' alt='logo'><label id='sitetitle'>SaintsXCTF</label></a>
                <div id='menulinks'>
                    <li class='active' id='home'><a class='headeropt' href='index.php'>HOME</a></li>
                </div>
            </div>
        </header>
        <div id='homedisplay'>
            <div id='mainbody'>
                <div id='forms'>
                    <h1>Forgot Password</h1>
                    <h3 class='first_verify'>Enter Your Email Address:</h3>
                    <h3 class='second_verify'>Create A New Password:</h3>
                    <h3 class='third_verify'>Your Password Has Been Changed.  Redirecting...</h3>
                    <div id='groupselect'>
                        <input id='fpw_email' class='input first_verify' type='text' maxlength='40' placeholder="Email"><br>
                        <input id='fpw_password' class='input second_verify' type='text' maxlength='40' placeholder="Password"><br>
                        <input id='fpw_cpassword' class='input second_verify' type='text' maxlength='40' placeholder="Confirm Password"><br>
                        <input id='fpw_password' class='input second_verify' type='text' maxlength='8' placeholder="Verification Code"><br>
                        <input id='fpw_submit_email' class='submit first_verify' type='button' disabled='true' value="Submit Email"><br>
                        <input id='fpw_submit_new_passowrd' class='submit second_verify' type='button' disabled='true' value="Submit New Password"><br>
                    </div><!-- End Groupselect -->
                </div><!-- End Forms -->
            </div><!-- End MainBody -->
        </div><!-- End HomeDisplay -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="forgotpassword.js"></script>
    </body>