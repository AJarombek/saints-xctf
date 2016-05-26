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
                    <li id='link'><a href='aboutus.php'>ABOUT US</a></li>
                    <li id='link'><a href='features.php'>FEATURES</a></li>
                    <li id='link' class='active'><a href='index.php'>HOME</a></li>
                </div>
            </div>
        </header>
        <div id='background'>
            <div id='mainbody'>
                <h1>Saints XC Running Logs</h1>
                <div id='forms'>
                    <div id=register>
                        <h2>Register</h2>
                        <input id='input' type='text' name='username' placeholder='Username'><br>
                        <input id='input' type='text' name='first' placeholder='First Name'><br>
                        <input id='input' type='text' name='last' placeholder='Last Name'><br>
                        <input id='input' type='password' name='password' placeholder='Password'><br>
                        <input id='input' type='password' name='confirmpassword' placeholder='Confirm Password'><br>
                        <input id='submit' type='button' name='register' disabled='true' value='Register'><br>
                    </div>
                    <div id=signin>
                        <h2>Sign In</h2>
                        <input id='input' type='text' name='username' placeholder='Username'><br>
                        <input id='input' type='password' name='password' placeholder='Password'><br>
                        <input id='submit' type='button' name='signin' disabled='true' value='Sign In'><br>
                    </div>
                </div>
            </div>
        </div>
    </body>