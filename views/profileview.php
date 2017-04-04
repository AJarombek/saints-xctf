<!--
Author: Andrew Jarombek
Date: 8/31/2016 - 2/20/2017
Profile Page HTML Code
Version 0.4 (BETA) - 12/24/2016
Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
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
                    <?php if ($myprofile): ?>
                        <li class='active' id='profile'><a class='headeropt' href='#display'><b>PROFILE</b></a></li>
                    <?php else: ?>
                        <li id='profile'><a class='headeropt' <?php echo 'href=\'profile.php?user=' . 
                            htmlentities($_SESSION['username'], ENT_QUOTES, 'utf-8') . '\''; ?>>PROFILE</a></li>
                    <?php endif; ?>
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
            <input id="week_start" type="hidden" value=<?php echo "'" . htmlentities($weekstart, ENT_QUOTES, 'utf-8') . "'";?>>
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

                    <h2><?php echo htmlentities($name, ENT_QUOTES, 'utf-8'); ?></h2>
                    <?php if ($_GET['user'] == 'andy'): ?>
                        <h4 id='flair'>Site Creator</h4>
                    <?php endif; ?>
                    <h3><?php echo '@' . htmlentities($_GET['user'], ENT_QUOTES, 'utf-8'); ?></h3>

                    <br>
                    <h5>Member Since: <?php $date = strtotime($member_since); 
                                                echo htmlentities(date("M. j, Y", $date), ENT_QUOTES, 'utf-8'); ?><h5>
                    <br>
                    <?php if (empty($groups)): ?>
                        <p class='nofeed'><i>No Groups</i></p>
                    <?php else: ?>
                        <?php foreach ($groups as $group): ?>
                            <?php if ($group['status'] == 'accepted'): ?>
                                <h4 class='teamopt' class='feed'><?php echo $group['group_title']; ?></h4>
                            <?php else: ?>
                                <h4 class='teamopt' class='feed' style="color: #aaa;"><?php echo $group['group_title']; ?></h4>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <br>

                    <?php if(isset($class_year)): ?>
                        <p>Class Year: <?php echo htmlentities($class_year, ENT_QUOTES, 'utf-8'); ?></p>
                    <?php endif; ?>
                    <?php if(isset($favorite_event)): ?>
                        <p>Favorite Event: <?php echo htmlentities($favorite_event, ENT_QUOTES, 'utf-8'); ?></p>
                    <?php endif; ?>
                    <?php if(isset($location)): ?>
                        <p>Location: <?php echo htmlentities($location, ENT_QUOTES, 'utf-8'); ?></p>
                    <?php endif; ?>
                    <br>
                    <?php if(isset($description)): ?>
                        <p><i><?php echo htmlentities($description, ENT_QUOTES, 'utf-8'); ?></i></p>
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
                <div id='userpanels'>
                    <ul id='panelslist'>
                        <li id='panelslistlogs' class='activepanelslist plelement userpl'>LOGS</li>
                        <li id='panelslistmonthly' class='inactivepanelslist plelement userpl'>MONTHLY</li>
                        <li id='panelslistweekly' class='inactivepanelslist plelement userpl'>WEEKLY</li>
                    </ul>
                    <?php if ($myprofile): ?>
                    <div id='activityinput' class='activepanel'>
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
                                <input type='date' id='log_date' class='input' name='date'>
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
                    <div id='activityfeed' class="activepanel">
                        
                    </div><!-- End ActivityFeed -->
                    <div id='monthlycalendar' class='inactivepanel'>
                        <div id='monthyear'>
                            <i class="material-icons md-36">keyboard_arrow_left</i>
                            <p>March 2017</p>
                            <i class="material-icons md-36">keyboard_arrow_right</i>
                        </div>
                        <div id='weekdays'>
                            <div class='wd'>Monday</div>
                            <div class='wd'>Tuesday</div>
                            <div class='wd'>Wednesday</div>
                            <div class='wd'>Thursday</div>
                            <div class='wd'>Friday</div>
                            <div class='wd'>Saturday</div>
                            <div class='wd'>Sunday</div>
                            <div class='wd'>Total</div>
                        </div>
                        <div id='calendar'>

                            <!-- Week 0 -->
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarend'></div>

                            <!-- Week 1 -->
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarend'></div>

                            <!-- Week 2 -->
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarend'></div>

                            <!-- Week 3 -->
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarend'></div>

                            <!-- Week 4 -->
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarend'></div>

                            <!-- Week 5 -->
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarday'></div>
                            <div class='calendarend'></div>

                        </div>
                    </div><!-- End MonthlyCalendar -->
                    <div id='weeklygraph' class='inactivepanel'>
                        <table id="wgraph">
                        <caption>
                            <i class="material-icons md-28">keyboard_arrow_left</i>
                            <p>Weekly Miles</p>
                            <i class="material-icons md-28">keyboard_arrow_right</i>
                        </caption>
                            <tbody>
                                <tr class="day" id="d1">
                                    <th scope="row">Monday</th>
                                    <td class="sent bar" style="height: 0px;"><p></p></td>
                                </tr>
                                <tr class="day" id="d2">
                                    <th scope="row">Tuesday</th>
                                    <td class="sent bar" style="height: 0px;"><p></p></td>
                                </tr>
                                <tr class="day" id="d3">
                                    <th scope="row">Wednesday</th>
                                    <td class="sent bar" style="height: 0px;"><p></p></td>
                                </tr>
                                <tr class="day" id="d4">
                                    <th scope="row">Thursday</th>
                                    <td class="sent bar" style="height: 0px;"><p></p></td>
                                </tr>
                                <tr class="day" id="d5">
                                    <th scope="row">Friday</th>
                                    <td class="sent bar" style="height: 0px;"><p></p></td>
                                </tr>
                                <tr class="day" id="d6">
                                    <th scope="row">Saturday</th>
                                    <td class="sent bar" style="height: 0px;"><p></p></td>
                                </tr>
                                <tr class="day" id="d7">
                                    <th scope="row">Sunday</th>
                                    <td class="sent bar" style="height: 0px;"><p></p></td>
                                </tr>
                            </tbody>
                        </table>

                        <div id="ticks">
                        <div class="tick"></div>
                        <div class="tick"></div>
                        <div class="tick"></div>
                        <div class="tick"></div>
                        <div class="tick"></div>
                        </div>
                    </div><!-- End MessageBoard -->
                </div><!-- End UserPanels -->
            </div><!-- End Display -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script src="date.js"></script>
            <script src="utils.js"></script>
            <script src="header.js"></script>
            <script src="profile.js"></script>
            <script src="calendar.js"></script>
            <script src="weeklyView.js"></script>
            <script src="userpanels.js"></script>
            <script src="log_utils.js"></script>
            <script src="log_input.js"></script>
            <script src="log_display.js"></script>
            <script src="feedback.js"></script>

            <?php if ($myprofile): ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    if ( $('#log_date').prop('type') != 'date' ) {
                        $('#log_date').datepicker();
                    }
                });
            </script>
            <?php endif; ?>
        <?php endif; ?>
    </body>