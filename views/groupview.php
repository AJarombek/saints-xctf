<!--
Author: Andrew Jarombek
Date: 12/8/2016 - 2/20/2017
Group Page HTML Code
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
                    <li id='teams'><a class='headeropt' href='#display'><b>TEAMS</b></a></li>
                    <li class='active' id='profile'><a class='headeropt' <?php echo 'href=\'profile.php?user=' . htmlentities($_SESSION['username'], ENT_QUOTES, 'utf-8') . '\''; ?>>PROFILE</a></li>
                    <li id='home'><a class='headeropt' href='index.php'>HOME</a></li>
                </div>
            </div>
            <div id='dropdiv'>
                <div class="dropdown-content">
                    <?php foreach ($_SESSION['groups'] as $group): ?>
                        <?php if ($group['status'] == 'accepted'): ?>
                            <a <?php echo 'href="group.php?name=' . $group['group_name'] . '"';?>><?php echo $group['group_title']; ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </header>
        <?php if ($valid): ?>
        <input id="group_data" type="hidden" value=<?php echo "'" . htmlentities($groupJSON, ENT_QUOTES, 'utf-8') . "'";?>>
        <input id="mygroup" type="hidden" value=<?php echo "'" . $mygroup . "'";?>>
        <input id="isadmin" type="hidden" value=<?php echo "'" . $admin . "'";?>>
        <div id='display'>
            <aside id='profileinfo'>
                <figure>
                    <?php if (isset($grouppic)) { echo '<img id="profilePic" height="160" width="160" src="' . $grouppic . '"> '; } else { 
                    echo '<img id="profilePic" src="views/images/runner_2x.png" alt="Group Picture" width="160" height="160">'; } ?>
                </figure>
                <?php if ($admin): ?>
                    <input id='edit_profile' class='submit' type='button' name='edit_profile' value='Edit Team'><br>
                <?php endif; ?>

                <h2><?php echo $group_title; ?></h2>
                <br>

                <?php if(isset($membercount)): ?>
                    <p><?php echo "Members: " . $membercount; ?></p>
                <?php endif; ?>
                <br>
                <?php if(isset($description)): ?>
                    <p><i><?php echo htmlentities($description, ENT_QUOTES, 'utf-8'); ?></i></p>
                <?php else: ?>
                    <p><i>No Description</i></p>
                <?php endif; ?>

                <br><br>

                <h3>Workout Mileage Statistics</h3>
                <h4><?php echo 'Career: ' . $statistics['miles'] ?></h4>
                <h4><?php echo 'Past Year: ' . $statistics['milespastyear'] ?></h4>
                <h4><?php echo 'Past Month: ' . $statistics['milespastmonth'] ?></h4>
                <h4><?php echo 'Past Week: ' . $statistics['milespastweek'] ?></h4>

                <br>
                <h5>Running Mileage Statistics</h5>
                <h6><?php echo 'Career: ' . $statistics['runmiles'] ?></h6>
                <h6><?php echo 'Past Year: ' . $statistics['runmilespastyear'] ?></h6>
                <h6><?php echo 'Past Month: ' . $statistics['runmilespastmonth'] ?></h6>
                <h6><?php echo 'Past Week: ' . $statistics['runmilespastweek'] ?></h6>

                <br>
                <h5>Body Feel</h5>
                <h6><?php echo 'Career: ' . $statistics['alltimefeel'] ?></h6>
                <h6><?php echo 'Past Year: ' . $statistics['yearfeel'] ?></h6>
                <h6><?php echo 'Past Month: ' . $statistics['monthfeel'] ?></h6>
                <h6><?php echo 'Past Week: ' . $statistics['weekfeel'] ?></h6>
            </aside>
            <div id='grouppanels'>
                <ul id='panelslist'>
                    <li id='panelslistlogs' class='activepanelslist plelement'>LOGS</li>
                    <li id='panelslistleaderboards' class='inactivepanelslist plelement'>LEADERBOARDS</li>

                    <?php if ($mygroup): ?>
                        <?php if (isset($newmessage)): ?>
                            <li id='panelslistmessageboard' class='inactivepanelslist plelement' style="padding-left: 6px; padding-right: 6px;">MESSAGE BOARD
                                    <i id='notification' class="material-icons md-16">fiber_new</i></li>
                        <?php else: ?>
                            <li id='panelslistmessageboard' class='inactivepanelslist plelement'>MESSAGE BOARD</li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li id='panelslistmessageboard' class='disabledpanelslist plelement'>MESSAGE BOARD</li>
                    <?php endif; ?>

                    <li id='panelslistmembers' class='inactivepanelslist plelement'>MEMBERS</li>

                    <?php if ($mygroup && $admin): ?>
                        <li id='panelslistadmin' class='inactivepanelslist plelement'>ADMIN</li>
                    <?php else: ?>
                        <li id='panelslistadmin' class='disabledpanelslist plelement'>ADMIN</li>
                    <?php endif; ?>
                </ul>
                <div id='activityfeed' class='activepanel'>
                    
                </div><!-- End ActivityFeed -->
                <div id='leaderboards' class='inactivepanel'>
                    <dl id='leaderboardchart'>  
                        <dt id='leaderboardtitle'>Miles All Time</dt>  
                    </dl>
                    <ul id='leaderboardlist'>
                        <li id='milesalltime' class='activeleaderboard lelement'>Miles All Time</li>
                        <li id='milespastyear' class='inactiveleaderboard lelement'>Miles Past Year</li>
                        <li id='milespastmonth' class='inactiveleaderboard lelement'>Miles Past Month</li>
                        <li id='milespastweek' class='inactiveleaderboard lelement'>Miles Past Week</li>
                    </ul>
                </div><!-- End Leaderboards -->
                <div id='messageboard' class='inactivepanel'>
                    <div id='messageinput'>
                        <h3>New Message</h3>
                        <textarea id='new_message' class='input' type='text' maxlength='1000' rows="10" placeholder='...'></textarea>
                    </div>
                    <div id='messagefeed'>
                    
                    </div><!-- End MessageFeed -->
                </div><!-- End MessageBoard -->
                <div id='members' class='inactivepanel'>
                    <?php foreach ($members as $member): ?>
                        <a href=<?php echo 'profile.php?user=' . htmlentities($member['username'], ENT_QUOTES, 'utf-8') ?>>
                            <div class='memberlist'>
                                <p><?php echo htmlentities($member['first'] . ' ' . $member['last'], ENT_QUOTES, 'utf-8'); ?></p>
                                <p>Member Since: <?php $date = strtotime($member['member_since']); 
                                                echo htmlentities(date("M. j, Y", $date), ENT_QUOTES, 'utf-8'); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div><!-- End Members -->
                <div id='admin' class='inactivepanel'>
                    <br>
                    <h3>Add Users</h3>
                    <br>
                    <div id='addusers'>
                        
                    </div>
                    <br>
                    <h3>Send Requests</h3>
                    <br>
                    <div>
                        <input id='email_input' class='submit' type='input' placeholder="Email">
                        <input id='send_email' class='submit' type='button' value='Send Email'>
                    </div>
                    <br>
                    <h3>Give Flair</h3>
                    <br>
                    <div id='giveflair'>
                        <select id='flair_username' class='input'>
                            <option value='first last'>First Last</option>
                        </select>
                        <input id='flair_input' class='submit' type='input' placeholder="Flair">
                        <input id='give_flair' class='submit' type='button' value='Give Flair'>
                    </div>
                    <br>
                </div><!-- End Admin -->
            </div><!-- End GroupPanels -->
        </div><!-- End Display -->
        <?php endif ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="date.js"></script>
        <script src="utils.js"></script>
        <script src="header.js"></script>
        <script src="group.js"></script>
        <script src="grouppanels.js"></script>
        <script src="leaderboardpanel.js"></script>
        <script src="log_display.js"></script>
        <script src="message_display.js"></script>
        <script src="message_input.js"></script>
        <script src="admin.js"></script>
        <script src="feedback.js"></script>
    </body>