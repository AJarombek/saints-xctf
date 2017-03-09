/*
 * Author: Andrew Jarombek
 * Date: 3/9/2017 -
 * JavaScript for maintaining local storage
 */

if (localStorage) {
    var username = localStorage.getItem("username");
    console.info("The locally stored username: ", username);

    if (username != undefined && username != null) {

        var a = function(callback) {

            // Make a Synchronous AJAX call because the rest of the webpage depends on it
            $.ajax({type: 'GET', 
                url: "signin.php", 
                async: false, 
                data: {localUser : username}, 
                success : callback
            });
        }

        a(function(response) {
            console.log(response);
            if (response === 'true') {
                console.info("Local Storage User Session Restored!");
            } else {
                console.info("FAILED to Restore Local User Session!");

                // Debug = False means final version, True means localhost version
                var debug = false;

                // Check if this is the final website version or not
                if (debug) {
                    if (window.location.pathname != '/saints-xctf/index.php' && 
                        window.location.pathname != '/saints-xctf/forgotpassword.php')
                        window.location = "index.php";
                } else {
                    if (window.location.pathname != '/index.php' && 
                        window.location.pathname != '/forgotpassword.php')
                        window.location = "index.php";
                }
            }
        });
    }
}

