<?php
session_start();
require_once('config/run_setup.php');
require_once('login/verifySessionLogin.php');
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Camagru</title>
        <link rel="stylesheet" href="css/styleindex.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/edit.css">

    </head>
    <body>
        <div class='head'>
            <?php include('header.php'); ?>
            <!-- header part -->
        </div>
        <div id='hello' class='middle'>
            <!-- middle part -->
        </div>
        <div class='footer'>
            <?php include('footer.php'); ?>
            <!-- footer part -->
        </div>
    <script>

        // ajaxify request, no ajax! put in own .js file and make it function load('url') // maybe add id or class fetch to company url 
        var request = new XMLHttpRequest();
        request.open('GET', 'api/edit.php', true);
        request.onload = function() {
            if (request.status >= 200 && request.status < 400) {
                var resp = request.responseText;
                document.getElementsByClassName('middle')[0].innerHTML = resp;
            }
        };
        request.send();

        function galleryPage() {
            var request = new XMLHttpRequest();
            request.open('GET', 'gallery.php', true);
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    document.getElementsByClassName('middle')[0].innerHTML = resp;
                }
            };
            request.send();
            var xhr = new XMLHttpRequest();
            doc = document;
            xhr.responseType = 'blob';
            xhr.open('GET', 'test.js', true);
            xhr.onload = function () {
                var script = doc.createElement('script'),
                src = URL.createObjectURL(xhr.response);

                script.src = src;
                doc.body.appendChild(script);
            };
            xhr.send();
        }


        function userLoginPage() {
            var request = new XMLHttpRequest();
            request.open('GET', 'api/login.php', true);
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    document.getElementsByClassName('middle')[0].innerHTML = resp;
                }
            };
            request.send();
        }
        function userLogoutPage() {
            var request = new XMLHttpRequest();
            request.open('GET', 'login/logout.php', true);
            request.onload = function() {};
            request.send();
            document.location.reload(true);
        }


        function newUserPage() {
            var request = new XMLHttpRequest();
            request.open('GET', 'api/newUser.php', true);
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    document.getElementsByClassName('middle')[0].innerHTML = resp;
                }
            };
            request.send();
        }
        function forgotPassPage() {
            var request = new XMLHttpRequest();
            request.open('GET', 'api/forgotPass.php', true);
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    document.getElementsByClassName('middle')[0].innerHTML = resp;
                }
            };
            request.send();
        }
        function userSettingsPage() {
            var request = new XMLHttpRequest();
            request.open('GET', 'api/userSettings.php', true);
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    document.getElementsByClassName('middle')[0].innerHTML = resp;
                }
            };
            request.send();
        }

        var login = '<?php echo $_SESSION['login']; ?>';
        var active = '<?php echo $_SESSION['active']; ?>';
        if (login != '' && active == 0) {
            var request = new XMLHttpRequest();
            request.open('GET', 'api/verifyAgain.php', true);
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    document.getElementsByClassName('middle')[0].innerHTML = resp;
                }
            };
            request.send();
        }
        var page = '<?php echo $_GET['error']; ?>';
        if (page == 2) {
            var str = "<?php echo $_GET['string']; ?>";
            var request = new XMLHttpRequest();
            request.open('GET', 'api/error/error2.php?string='+str, true);
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    document.getElementsByClassName('middle')[0].innerHTML = resp;
                }
            };
            request.send();
        }
        var page = '<?php echo $_GET['reset']; ?>';
        if (page == 'yes') {
            var email = "<?php echo $_GET['email']; ?>";
            var hash = "<?php echo $_GET['hash']; ?>";
            var request = new XMLHttpRequest();
            request.open('GET', 'api/resetPass.php?email='+email+'&hash='+hash, true);
            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    document.getElementsByClassName('middle')[0].innerHTML = resp;
                }
            };
            request.send();
        }
        window.addEventListener('load', (event) => {
            console.log('index page is fully loaded');
        });
    </script>

    </body>
</html>