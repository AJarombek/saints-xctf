<!--
Author: Andrew Jarombek
Date: 4/2/2017
Edit Group Details Page HTML Code
-->

    <body>
        <header id='signedoutmenu'>
            <div id='menucontents'>
                <a href='index.php'><img id='sitelogo' src='views/images/logo.jpg' alt='logo'><label id='sitetitle'>SaintsXCTF</label></a>
                <h5>BETA</h5>
                <div id="mobilemenu">
                    <i class="material-icons md-48 md-light">menu</i>
                </div>
                <div id='menulinks'>
                    <li id='signout'><a class='headeropt' href='#display'>SIGN OUT</a></li>
                    <li id='teams'><a class='headeropt' href='index.php'>TEAMS</a></li>
                    <li id='profile'><a class='headeropt' <?php echo 'href=\'profile.php?user=' . 
                            htmlentities($_SESSION['username'], ENT_QUOTES, 'utf-8') . '\''; ?>>PROFILE</a></li>
                    <li id='home'><a class='headeropt' href='index.php'>HOME</a></li>
                </div>
            </div>
            <div id='dropdiv'>
                <div class="dropdown-content">
                    <?php foreach ($_SESSION['groups'] as $group): ?>
                    <a <?php echo 'href="group.php?name=' . $group['group_name'] . '"';?>><?php echo $group['group_title']; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </header>
        <div id='longerdisplay'>
            <div id='editdisplay'>
                <div id='editprofiledetails'>
                    <h2>Team Details</h2><br>
                    <p>Description: 
                        <textarea id='edit_description' class='input' type='text' maxlength='255' name='description' placeholder='...'></textarea><br>
                    </p>
                    <p id='week_start'>Week Start:
                        <input class="radio" type="radio" name="week_start" value="sunday"> Sunday
                        <input class="radio" type="radio" name="week_start" value="monday"> Monday
                    </p>
                </div><!-- End EditProfileDetails -->
                <div id='editprofilepicture'>
                    <h2>Team Picture</h2><br>
                    <figure>
                        <?php if (isset($profpic)) { echo '<img id="teamPic" height="160" width="160" src="' . $profpic . ' "> '; } else { 
                        echo '<img id="teamPic" src="views/images/runner_2x.png" alt="Profile Picture" width="160" height="160">'; } ?>
                    </figure>
                    <aside>
                        <label>Upload a Team Picture:</label><br>
                        <input id="file" multiple accept="image/*" type="file" name="image">
                    </aside>
                </div><!-- End EditProfilePicture -->
            </div><!-- End EditDisplay -->
        </div><!-- End Display -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="header.js"></script>
        <script src="editgroup.js"></script>
        <script src="feedback.js"></script>
    </body>