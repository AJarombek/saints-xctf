<!--
Author: Andrew Jarombek
Date: 6/11/2016 - 2/20/2017
Main Signed In Page HTML Code
Version 0.4 (BETA) - 12/24/2016
Version 0.6 (GROUPS UPDATE) - 2/20/2017
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
                    <li id='teams'><a class='headeropt' id='dropbtn'>TEAMS</a></li>
                    <li id='profile'><a class='headeropt' <?php echo 'href=\'profile.php?user=' . 
                            htmlentities($_SESSION['username'], ENT_QUOTES, 'utf-8') . '\''; ?>>PROFILE</a></li>
                    <li class='active' id='home'><a class='headeropt' href='index.php'><b>HOME</b></a></li>
                </div>
            </div>
            <div id='dropdiv'>
                <div class="dropdown-content">
                    <?php foreach ($groups as $group): ?>
                        <?php if ($group['status'] == 'accepted'): ?>
                            <a <?php echo 'href="group.php?name=' . $group['group_name'] . '"';?>><?php echo $group['group_title']; ?></a>
                        <?php endif; ?>
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
                    <?php foreach ($groups as $group): ?>
                        <?php if ($group['status'] == 'accepted'): ?>
                            <?php unset($allgroups[$group['group_name']]); ?>
                            <form class='group_link' id=<?php echo $group['group_name'] ?> 
                                <?php echo 'action="group.php?name=' . $group['group_name'] . '" method="post"';?>>

                                <!-- Either Enable or Disable the Notification for the Group Link -->
                                <?php if (isset($_SESSION['notifications'][$group['group_name']]['logs'])): ?>
                                    <?php if ($_SESSION['notifications'][$group['group_name']]['logs'] == true || 
                                                $_SESSION['notifications'][$group['group_name']]['messages'] == true): ?>
                                        <div>
                                            <p><?php echo $group['group_title'] . ' '; ?><i id='notification' class="material-icons md-24">fiber_new</i></p>
                                        </div>
                                    <?php else: ?>
                                        <div><?php echo $group['group_title']; ?></div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div><?php echo $group['group_title']; ?></div>
                                <?php endif; ?>

                            </form>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <br>
                <h2>Other Teams</h2>
                <br>
                <?php foreach ($allgroups as $group): ?>
                    <form class='group_link' id=<?php echo $group['group_name'] ?> 
                        <?php echo 'action="group.php?name=' . $group['group_name'] . '" method="post"';?>>
                        <div><?php echo $group['group_title']; ?></div>
                    </form>
                <?php endforeach; ?>
                <br>
            </aside>
            <div id='activityfeed'>
                
            </div><!-- End ActivityFeed -->
        </div><!-- End Display -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="date.js"></script>
        <script src="utils.js"></script>
        <script src="header.js"></script>
        <script src="log_display.js"></script>
        <script src="feedback.js"></script>
        <script src="main.js"></script>
    </body>