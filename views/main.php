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
                    <li id='signout'><a class='headeropt' href='index.php'>SIGN OUT</a></li>
                    <li id='teams'><a class='headeropt' href='index.php'>TEAMS</a></li>
                    <li id='profile'><a class='headeropt' href='index.php'>PROFILE</a></li>
                    <li class='active' id='home'><a class='headeropt' href='index.php'>HOME</a></li>
                </div>
            </div>
        </header>
        <div id='display'>
            <aside id='teamfeed'>
                <h2>Your Teams</h2>
                <?php if (empty($teams)): ?>
                    <p class='nofeed'><i>No Teams</i></p>
                <?php else: ?>
                    <?php foreach ($teams as $team): ?>
                        <a class='teamopt'><?php echo $team; ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </aside>
            <div id='activityfeed'>
                <?php if (empty($logs)): ?>
                    <p class='nofeed'><i>No Activity</i></p>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <div class='log' <?php echo 'class= ' . $log['feel']; ?>>
                            <p><?php echo $log['name']; ?></p>
                            <p><?php echo $log['date']; ?></p>
                            <p><?php echo $log['location']; ?></p>
                            <p><?php echo $log['type']; ?></p>
                            <p><?php echo $log['distance'] . $log['metric']; ?></p>
                            <p><?php echo 'Time: ' . $log['time']; ?></p>
                            <p><?php echo $log['description']; ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div><!-- End ActivityFeed -->
        
            <aside id='eventfeed'>
                <h2>Events</h2>
                <p class='nofeed'><i>Coming Soon!</i></p>
            </aside>
        </div><!-- End Display -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- JavaScript for Future Use
        <script src="signout.js"></script>
        <script src="teams.js"></script>
        <script src="profile.js"></script>
        -->
    </body>