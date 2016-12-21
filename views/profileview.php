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
                    <li id='teams'><a class='headeropt' id='dropbtn'>TEAMS</a></li>
                    <li class='active' id='profile'><a class='headeropt' href='#display'><b>PROFILE</b></a></li>
                    <li id='home'><a class='headeropt' href='index.php'>HOME</a></li>
                </div>
            </div>
            <div id='dropdiv'>
                <div class="dropdown-content">
                        <?php foreach ($_SESSION['groups'] as $group => $grouptitle): ?>
                        <a <?php echo 'href="group.php?name=' . $group . '"';?>><?php echo $grouptitle; ?></a>
                        <?php endforeach; ?>
                </div>
            </div>
        </header>
        <?php if ($valid): ?>
            <?php if (!$myprofile): ?>
                <div id='display'>
            <?php else: ?>
                <div id='myprofiledisplay'>
            <?php endif; ?>
                <aside id='profileinfo'>
                    <figure>
                        <?php if (isset($profpic)) { echo '<img id="profilePic" height="160" width="160" src="' . $profpic . '"> '; } else { 
                        echo '<img id="profilePic" src="views/images/runner_2x.png" alt="Profile Picture" width="160" height="160">'; } ?>
                    </figure>
                    <?php if ($myprofile): ?>
                        <input id='edit_profile' class='submit' type='button' name='edit_profile' value='Edit Profile'><br>
                    <?php endif; ?>

                    <h2><?php echo $name; ?></h2>
                    <?php if ($_GET['user'] == 'andy'): ?>
                        <h4 id='creator'>Site Creator</h4>
                    <?php endif; ?>
                    <h3><?php echo '@' . $_GET['user']; ?></h3>

                    <br>
                    <h5>Member Since: <?php echo $member_since; ?><h5>
                    <br>
                    <?php if (empty($groups)): ?>
                        <p class='nofeed'><i>No Groups</i></p>
                    <?php else: ?>
                        <?php foreach ($groups as $group => $group_name): ?>
                            <h4 class='teamopt' class='feed'><?php echo $group_name; ?></h4>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <br>

                    <?php if(isset($class_year)): ?>
                        <p>Class Year: <?php echo $class_year; ?></p>
                    <?php endif; ?>
                    <?php if(isset($favorite_event)): ?>
                        <p>Favorite Event: <?php echo $favorite_event; ?></p>
                    <?php endif; ?>
                    <?php if(isset($location)): ?>
                        <p>Location: <?php echo $location; ?></p>
                    <?php endif; ?>
                    <br>
                    <?php if(isset($description)): ?>
                        <p><i><?php echo $description; ?></i></p>
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
                <?php if ($myprofile): ?>
                <div id='activityinput'>
                <p id='feel_hint'>Average</p>
                    <div id='inputcontents'>
                        <h2>Log Your Run</h2>
                        <p>Run Name: 
                            <input id='log_name' class='input' type='text' maxlength='30' name='name' placeholder='Run Name'><br>
                        </p>
                        <p>Location: 
                            <input id='log_location' class='input' type='text' maxlength='30' name='location' placeholder='Location'><br>
                        </p>
                        <p>Date: 
                            <input id='log_date' class='input' type='date' name='date' placeholder='Date' onfocus="(this.type='date')">
                         Workout Type: 
                            <select id='log_type' class='input'>
                                <option value='run'>Run</option>
                                <option value='bike'>Bike</option>
                                <option value='swim'>Swim</option>
                                <option value='other'>Other</option>
                            </select><br>
                        </p>
                        <p>Distance: 
                            <input id='log_distance' class='input' type='text' maxlength='5' name='distance' placeholder='0'>
                         Metric: 
                            <select id='log_metric' class='input'>
                                <option value='miles'>Miles</option>
                                <option value='kilometers'>Kilometers</option>
                                <option value='meters'>Meters</option>
                            </select>
                         Time: 
                            <input id='log_minutes' class='input' type='text' maxlength='3' name='minutes' placeholder='0'> :
                            <input id='log_seconds' class='input' type='text' maxlength='2' name='seconds' placeholder='0'><br>
                        </p>
                        <p>Feel: 
                            <input id='log_feel' class='input' type='range' min='1' max='10' step='1' value='6'>
                        </p>
                        <p>Description: 
                            <textarea id='log_description' class='input' type='text' maxlength='255' name='last' placeholder='...'></textarea><br>
                        </p>
                        <input id='log_cancel' class='submit' type='button' name='cancel' value='Cancel'>
                        <input id='log_submit' class='submit' type='button' name='submit' value='Submit'><br>
                        <p id='log_error'></p>
                    </div>
                </div>
                <?php endif; ?>
                <div id='activityfeed'>
                    
                </div><!-- End ActivityFeed -->
            </div><!-- End Display -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="header.js"></script>
            <script src="profile.js"></script>
            <script src="log_input.js"></script>
            <script src="log_display.js"></script>

            <?php if ($myprofile): ?>
            <script type="text/javascript">
                document.getElementById('log_date').valueAsDate = new Date();
            </script>
            <?php endif; ?>
        <?php endif; ?>
    </body>