<!--
Author: Andrew Jarombek
Date: 6/11/2016 - 
Main Signed In Page HTML Code
-->

    <body>
        <header id='signedoutmenu'>
            <div id='menucontents'>
                <a href='index.php'><img id='sitelogo' src='views/images/logo.jpg' alt='logo'><label id='sitetitle'>SaintsXCTF</label></a>
                <div id='menulinks'>
                    <li id='signout'><a class='headeropt' href='#display'>SIGN OUT</a></li>
                    <li id='teams'><a class='headeropt' href='index.php'>TEAMS</a></li>
                    <li id='profile'><a class='headeropt' <?php echo 'href=\'profile.php?user=' . $_SESSION['username'] . '\''; ?>>PROFILE</a></li>
                    <li class='active' id='home'><a class='headeropt' href='index.php'><b>HOME</b></a></li>
                </div>
            </div>
        </header>
        <div id='display'>
            <aside id='teamfeed'>
                <h2>Your Teams</h2>
                <br>
                <?php if (empty($groups)): ?>
                    <p class='nofeed'><i>No Teams</i></p>
                <?php else: ?>
                    <?php foreach ($groups as $group): ?>
                        <input class='submit' type='button' name='edit_profile' value=<?php echo "'" . $group . "'"; ?>><br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </aside>
            <div id='activityfeed'>
                
            </div><!-- End ActivityFeed -->
        
            <aside id='eventfeed'>
                <h2>Events</h2>
                <p class='nofeed'><i>Coming Soon!</i></p>
            </aside>
        </div><!-- End Display -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="header.js"></script>
        <script src="log_display.js"></script>
        <!-- JavaScript for Future Use
        <script src="teams.js"></script>
        <script src="profile.js"></script>
        -->
    </body>