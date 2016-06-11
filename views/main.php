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
                    <li id='signout'><a class='headeropt' href='/'>SIGN OUT</a></li>
                    <li id='teams'><a class='headeropt' href='/'>TEAMS</a></li>
                    <li id='profile'><a class='headeropt' href='/'>PROFILE</a></li>
                    <li class='active' id='home'><a class='headeropt' href='/'>HOME</a></li>
                </div>
            </div>
        </header>
        <aside id='teamfeed'>
            <h2>Your Teams</h2>
        </aside>
        <div id='activityfeed'>
            <h1>Main Page Feed</h1>
            <?php if ()?>
        </div>
        <aside id='eventfeed'>
            <h2>Events</h2>
        </aside>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="signout.js"></script>
        <script src="teams.js"></script>
        <script src="profile.js"></script>
    </body>