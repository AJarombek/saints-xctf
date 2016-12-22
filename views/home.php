<!--
Author: Andrew Jarombek
Date: 5/23/2016 - 
Main Signed Out Page HTML Code
-->

    <body>
        <header id='signedoutmenu'>
            <div id='menucontents'>
                <a href='index.php'><img id='sitelogo' src='views/images/logo.jpg' alt='logo'><label id='sitetitle'>SaintsXCTF</label></a>
                <h5>BETA</h5>
                <div id='menulinks'>
                    <li id='aboutus'><a class='headeropt' href='#aboutusdisplay'>ABOUT US</a></li>
                    <li id='features'><a class='headeropt' href='#featuresdisplay'>FEATURES</a></li>
                    <li class='active' id='home'><a class='headeropt' href='#homedisplay'>HOME</a></li>
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
                        <input id='su_code' class='input' type='text' maxlength='6' name='activationcode' placeholder='Activation Code'><br>
                        <input id='su_submit' class='submit' type='button' name='register' disabled='true' value='Register'><br>
                        <p id='su_error'></p>
                    </div><!-- End Register -->
                    <div id=signin>
                        <h2>Sign In</h2>
                        <input id='si_username' class='input' type='text' maxlength='30' name='username' placeholder='Username'><br>
                        <input id='si_password' class='input' type='password' maxlength='40' name='password' placeholder='Password'><br>
                        <input id='si_submit' class='submit' type='button' name='signin' disabled='true' value='Sign In'><br>
                        <p id='si_error'></p>
                    </div><!-- End SignIn -->
                </div><!-- End Forms -->
            </div><!-- End MainBody -->
        </div><!-- End HomeDisplay -->
        <div id='featuresdisplay'>
            <h1>Features</h1>
            <br>
            <ul>
                <li>In Depth Workout Logging</li>
                <li>Team Pages</li>
                <li>Personal and Team Stat Tracking</li>
            </ul>
            <br><br><br><br>
            <h2>Testimonials</h2>
            <br><br>
            <figure>
                <img class="img-circle" src="views/images/tom.jpg" alt="Tom" width="91" height="125">
                <figcaption>Yeah I guess this website is pretty cool -<i>Thomas Caulfield</i></figcaption>
            </figure>
            <figure>
                <img class="img-circle" src="views/images/lisa.jpg" alt="Lisa" width="91" height="125">
                <figcaption>I love it!!  I wish there was a place for me to log kale consumption though.. -<i>Lisa Grohn</i></figcaption>
            </figure>
            <figure>
                <img class="img-circle" src="views/images/garvey.jpg" alt="Evan" width="91" height="125">
                <figcaption>What Lisa said. -<i>Evan Garvey</i></figcaption>
            </figure>
            <figure>
                <img class="img-circle" src="views/images/bibb.jpg" alt="Bibb" width="91" height="125">
                <figcaption>Yeeeeeeeeehawwwwwwww -<i>Trevor Bibb</i></figcaption>
            </figure>
        </div>
        <div id='aboutusdisplay'>
            <h1>About Us</h1>
            <br><br>
            <p>SaintsXCTF is a response to the lack of an adequate team based running log website.  An application was needed to keep the team together and focused
                throughout summer training and the season.  One crucial part of summer training is seeing what all your teammates are doing for their training on a daily basis.
                SaintsXCTF responds to these needs with an elegant user interface accompanied by an in depth logging system.  Never before has it been this easy
                to view your teams training progression.</p>
            <br>
            <p>I hope you enjoy the site.  At the moment it is a work in progress, and I would love to hear your feedback on ways the website can be improved.
                Since it is in such an early stage, bugs are also likely.  Please report any that you encounter to me so I can fix them as soon as possible.</p>
            <br><br>
            <p><b>Contact Information</b><br>Andrew Jarombek<br>abjaro13@stlawu.edu</p>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="signup.js"></script>
        <script src="signin.js"></script>
        <script type="footer.js"></script>
    </body>