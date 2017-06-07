<!--
Author: Andrew Jarombek
Date: 6/6/2017
Single Log view page HTML code
-->

    <body>
        <header id='signedoutmenu'>
            <div id='menucontents'>
                <a href='index.php'><img id='sitelogo' src='views/images/logo.jpg' alt='logo'><label id='sitetitle'>SaintsXCTF</label></a>
                <div id="mobilemenu">
                    <i class="material-icons md-48 md-light">menu</i>
                </div>
                <div id='menulinks'>
                    <li id='signout'><a class='headeropt' href='#display'>SIGN OUT</a></li>
                    <li id='teams'><a class='headeropt' href='index.php'>TEAMS</a></li>
                    <li id='profile'><a class='headeropt' <?php echo 'href=\'profile.php?user=' . htmlentities($_SESSION['username'], ENT_QUOTES, 'utf-8') . '\''; ?>>PROFILE</a></li>
                    <li id='home'><a class='headeropt' href='index.php'>HOME</a></li>
                </div>
            </div>
            <div id='dropdiv'>
                <div class="dropdown-content">
                    <?php foreach ($_SESSION['groups'] as $group => $grouptitle): ?>
                        <?php if ($group['status'] == 'accepted'): ?>
                            <a <?php echo 'href="group.php?name=' . $group['group_name'] . '"';?>><?php echo $group['group_title']; ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </header>
        <?php if (true): ?>
            <div id='display'>
                <div id='activityfeed' class='singlelogfeed'>
                
                </div><!-- End ActivityFeed -->
            </div><!-- End Display -->
        <?php endif; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="date.js"></script>
        <script src="utils.js"></script>
        <script src="header.js"></script>
        <script src="log_display.js"></script>
        <script src="log.js"></script>
        <script src="feedback.js"></script>
    </body>