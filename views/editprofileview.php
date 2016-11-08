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
        <div id='longerdisplay'>
            <div id='editdisplay'>
                <div id='editprofiledetails'>
                    <h2>Profile Details</h2><br>
                    <p>First Name: 
                        <input id='edit_first' class='input' type='text' maxlength='30' name='first' placeholder='First Name'><br>
                    </p>
                    <p>Last Name: 
                        <input id='edit_last' class='input' type='text' maxlength='30' name='last' placeholder='Last Name'><br>
                    </p>
                    <p>Class Year: 
                        <input id='edit_year' class='input' type='text' maxlength='4' name='year' placeholder='Class Year'><br>
                    </p>
                    <p>Location: 
                        <input id='edit_location' class='input' type='text' maxlength='30' name='location' placeholder='Location'><br>
                    </p>
                    <p>Favorite Event: 
                        <input id='edit_event' class='input' type='text' maxlength='30' name='event' placeholder='Favorite Event'><br>
                    </p>
                    <p>Description: 
                        <textarea id='edit_description' class='input' type='text' maxlength='255' name='description' placeholder='...'></textarea><br>
                    </p>
                </div><!-- End EditProfileDetails -->
                <div id='editprofilepicture'>
                    <h2>Profile Picture</h2><br>
                    <figure>
                        <?php if (isset($profpic)) { echo '<img id="profilePic" height="160" width="160" src="data:image;base64,' . $profpic . ' "> '; } else { 
                        echo '<img id="profilePic" src="views/images/runner_2x.png" alt="Profile Picture" width="160" height="160">'; } ?>
                    </figure>
                    <aside>
                        <label>Upload a Profile Picture:</label><br>
                        <input id="file" type="file" name="image">
                    </aside>
                </div><!-- End EditProfilePicture -->
                <div id='editgroups'>
                    <h2>Pick Groups</h2><br>
                    <input id='join_womensxc' class='select' type='button' name='register' value="Women's Cross Country"><br>
                    <input id='join_mensxc' class='select' type='button' name='register' value="Men's Cross Country"><br>
                    <input id='join_womenstf' class='select' type='button' name='register' value="Women's Track &amp; Field"><br>
                    <input id='join_menstf' class='select' type='button' name='register' value="Men's Track &amp; Field"><br>
                    <input id='join_alumni' class='select' type='button' name='register' value="Alumni"><br>
                </div><!-- End EditProfilePicture -->
                <div id='submitprofilechanges'>
                    <input id='edit_cancel' class='submit' type='button' name='cancel' value='Cancel'>
                    <input id='edit_submit' class='submit' type='button' name='submit' value='Submit'>
                </div><!-- End SubmitProfileChanges -->
            </div><!-- End EditDisplay -->
        </div><!-- End Display -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="header.js"></script>
        <script src="pickgroups.js"></script>
        <script src="editprofile.js"></script>
    </body>