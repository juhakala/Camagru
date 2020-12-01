<?php
session_start();
require_once('login/verifySessionLogin.php');
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Camagru</title>
        <link rel="stylesheet" href="css/index.css">
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
    </script>
    </body>
</html>