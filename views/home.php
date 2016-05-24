<!--
Author: Andrew Jarombek
Date: 5/23/2016 - 
Main Signed Out Page HTML Code
-->

    <body>
        <header id='signedoutmenu'>
            <a href='index.php'><img id='sitelogo' src='views/images/logo.jpg' alt='logo'><label id='sitetitle'>SaintsXCTF</label></a>
        </header>
        <div id='mainbody'>
            <h1>Saints XC Running Logs</h1>
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
    </body>