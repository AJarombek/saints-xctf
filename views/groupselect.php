<!--
Author: Andrew Jarombek
Date: 5/28/2016 - 12/24/2016
Picking Groups Page HTML Code
Version 0.4 (BETA) - 12/24/2016
-->

    <body>
        <header id='signedoutmenu'>
            <div id='menucontents'>
                <a href='index.php'><img id='sitelogo' src='views/images/logo.jpg' alt='logo'><label id='sitetitle'>SaintsXCTF</label></a>
                <div id='menulinks'>
                    <li class='active' id='home'><a class='headeropt' href='index.php'>HOME</a></li>
                </div>
            </div>
        </header>
        <div id='homedisplay'>
            <div id='mainbody'>
                <div id='forms'>
                    <h1>Select Groups</h1>
                    <h3>Join one or more groups.  You can come back later and join more.</h3>
                    <div id='groupselect'>
                        <input id='join_womensxc' class='select' type='button' name='register' value="Women's Cross Country"><br>
                        <input id='join_mensxc' class='select' type='button' name='register' value="Men's Cross Country"><br>
                        <input id='join_womenstf' class='select' type='button' name='register' value="Women's Track &amp; Field"><br>
                        <input id='join_menstf' class='select' type='button' name='register' value="Men's Track &amp; Field"><br>
                        <input id='join_alumni' class='select' type='button' name='register' value="Alumni"><br>
                        <input id='join' class='submit' type='button' name='register' disabled='true' value="Join Groups"><br>
                    </div><!-- End Groupselect -->
                </div><!-- End Forms -->
            </div><!-- End MainBody -->
        </div><!-- End HomeDisplay -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="pickgroups.js"></script>
    </body>