<!--
Author: Andrew Jarombek
Date: 2/5/2017 - 2/20/2017
Edit Log page HTML code
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
        <?php if (isset($logno)): ?>
            <div id='display'>
                <div id='editactivityinput'>
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
                                <input type='date' id='log_date' class='input' name='date' placeholder='Date' onfocus="(this.type='date')">
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
            </div><!-- End Display -->
        <?php endif; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="header.js"></script>
        <script src="log_utils.js"></script>
        <script src="editlog.js"></script>
        <script src="feedback.js"></script>
    </body>