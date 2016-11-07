<!--
Author: Andrew Jarombek
Date: 11/7/2016 - 
Main Signed In Page HTML Code
-->

    <body>
        <header id='signedoutmenu'>
            <div id='menucontents'>
                <a href='index.php'><img id='sitelogo' src='views/images/logo.jpg' alt='logo'><label id='sitetitle'>SaintsXCTF</label></a>
                <div id='menulinks'>
                    <li id='signout'><a class='headeropt' href='#display'>SIGN OUT</a></li>
                    <li id='teams'><a class='headeropt' href='index.php'>TEAMS</a></li>
                    <li id='profile'><a class='headeropt' <?php echo 'href=\'profile.php?user=' . $username . '\''; ?>>PROFILE</a></li>
                    <li id='home'><a class='headeropt' href='index.php'><b>HOME</b></a></li>
                </div>
            </div>
        </header>
        <div id='display'>
            <div id='editdisplay'>
                <div id='editprofiledetails'>
                    <h2>Profile Details</h2><br>
                    <input id='edit_first' class='input' type='text' maxlength='30' name='first' placeholder='First Name'><br>
                    <input id='edit_last' class='input' type='text' maxlength='30' name='last' placeholder='Last Name'><br>
                    <input id='edit_year' class='input' type='text' maxlength='30' name='year' placeholder='Class Year'><br>
                    <input id='edit_location' class='input' type='text' maxlength='30' name='location' placeholder='Location'><br>
                    <input id='edit_event' class='input' type='text' maxlength='30' name='event' placeholder='Favorite Event'><br>
                    <textarea id='edit_description' class='input' type='text' maxlength='255' name='description' placeholder='...'></textarea><br>
                </div><!-- End EditProfileDetails -->
                <div id='editprofilepicture'>
                    <h2>Profile Picture</h2><br>
                    
                </div><!-- End EditProfilePicture -->
                <div id='editgroups'>
                    <h2>Pick Groups</h2><br>
                    
                </div><!-- End EditProfilePicture -->
            </div><!-- End EditDisplay -->
        </div><!-- End Display -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="header.js"></script>
    </body>