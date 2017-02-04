<!--
Author: Andrew Jarombek
Date: 6/11/2016 - 12/24/2016
Main Signed In Page HTML Code
Version 0.4 (BETA) - 12/24/2016
-->

    <body>
        <header id='signedoutmenu'>
            <div id='menucontents'>
                <a href='index.php'><img id='sitelogo' src='views/images/logo.jpg' alt='logo'><label id='sitetitle'>SaintsXCTF</label></a>
                <h5>BETA</h5>
                <div id='menulinks'>
                    <li id='signout'><a class='headeropt' href='#display'>SIGN OUT</a></li>
                    <li id='teams'><a class='headeropt' id='dropbtn'>TEAMS</a></li>
                    <li id='profile'><a class='headeropt' <?php echo 'href=\'profile.php?user=' . htmlentities($_SESSION['username'], ENT_QUOTES, 'utf-8') . '\''; ?>>PROFILE</a></li>
                    <li class='active' id='home'><a class='headeropt' href='index.php'><b>HOME</b></a></li>
                </div>
            </div>
            <div id='dropdiv'>
                <div class="dropdown-content">
                    <?php foreach ($groups as $group => $grouptitle): ?>
                    <a <?php echo 'href="group.php?name=' . $group . '"';?>><?php echo $grouptitle; ?></a>
                    <?php endforeach; ?>
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
                    <?php foreach ($groups as $group => $grouptitle): ?>
                        <form <?php echo 'action="group.php?name=' . $group . '" method="post"';?>>
                            <input class='submit' type='submit' value=<?php echo "\"" . $grouptitle . "\""; ?>>
                        </form>
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
        <script src="feedback.js"></script>
        <!-- JavaScript for Future Use
        <script src="teams.js"></script>
        <script src="profile.js"></script>
        -->
    </body>