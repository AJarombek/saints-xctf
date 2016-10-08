<!--
Author: Andrew Jarombek
Date: 8/31/2016 - 
Profile Page HTML Code
-->

    <body>
        <header id='signedoutmenu'>
            <div id='menucontents'>
                <a href='index.php'><img id='sitelogo' src='views/images/logo.jpg' alt='logo'><label id='sitetitle'>SaintsXCTF</label></a>
                <div id='menulinks'>
                    <li id='signout'><a class='headeropt' href='#display'>SIGN OUT</a></li>
                    <li id='teams'><a class='headeropt' href='index.php'>TEAMS</a></li>
                    <li class='active' id='profile'><a class='headeropt' href='#display'><b>PROFILE</b></a></li>
                    <li id='home'><a class='headeropt' href='index.php'>HOME</a></li>
                </div>
            </div>
        </header>
        <div id='display'>
            <aside id='profileinfo'>
                <figure>
                    <?php if (isset($profpic)) { echo '<img id="profilePic" height="160" width="160" src="data:image;base64,' . $profpic . ' "> '; } else { 
                    echo '<img id="profilePic" src="views/images/runner_2x.png" alt="Profile Picture" width="160" height="160">'; } ?>
                </figure>
                <h2><?php echo $name; ?></h2>
                <h3><?php echo '@' . $_GET['user']; ?></h3>
                <br>
                <?php if (empty($teams)): ?>
                    <p class='nofeed'><i>No Teams</i></p>
                <?php else: ?>
                    <?php foreach ($teams as $team): ?>
                        <?php foreach ($team as $t): ?>
                            <h4 class='teamopt' class='feed'><?php echo $t; ?></h4>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <br><br>

                <h3>Workout Mileage Statistics</h3>
                <h4><?php echo 'Career: ' . $alltime ?></h4>
                <h4><?php echo 'Past Year: ' . $yearly ?></h4>
                <h4><?php echo 'Past Month: ' . $monthly ?></h4>
                <h4><?php echo 'Past Week: ' . $weekly ?></h4>
            </aside>
            <div id='activityinput'>
                <h2>Log Your Run</h2>
                <input id='log_name' class='input' type='text' maxlength='30' name='name' placeholder='Run Name'><br>
                <input id='log_date' class='input' type='date' name='date' placeholder='Date' onfocus="(this.type='date')"><br>
                <input id='log_location' class='input' type='text' maxlength='30' name='location' placeholder='Location'><br>
                <select id='log_type' class='input'>
                    <option value='run'>Run</option>
                    <option value='bike'>Bike</option>
                    <option value='swim'>Swim</option>
                    <option value='other'>Other</option>
                </select><br>
                <input id='log_distance' class='input' type='text' maxlength='5' name='distance' placeholder='0'>
                <select id='log_metric' class='input'>
                    <option value='miles'>Miles</option>
                    <option value='kilometers'>Kilometers</option>
                    <option value='meters'>Meters</option>
                </select><br>
                <input id='log_minutes' class='input' type='text' maxlength='3' name='minutes' placeholder='0'>
                <input id='log_seconds' class='input' type='text' maxlength='2' name='seconds' placeholder='0'><br>
                <input id='log_description' class='input' type='text' maxlength='255' name='last' placeholder='...'><br>
                <input id='log_cancel' class='submit' type='button' name='cancel' disabled='true' value='Cancel'><br>
                <input id='log_submit' class='submit' type='button' name='submit' disabled='true' value='Submit'><br>
                <p id='log_error'></p>
            </div>
            <div id='activityfeed'>
                <?php if (empty($logs)): ?>
                    <p class='nofeed'><i>No Activity</i></p>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <div class='log' class='feed' <?php echo 'class= ' . $log['feel']; ?>>
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
        </div><!-- End Display -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="header.js"></script>
        <script src="profile.js"></script>
    </body>