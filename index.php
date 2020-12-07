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
        var url = sessionStorage.getItem('page') == null ? 'gallery.php' : sessionStorage.getItem('page');
        var form = sessionStorage.getItem('form') == null ? 'js/gallery.js' : sessionStorage.getItem('form')
        masters(url, form); //for reload 

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
    </script>
    <script src='js/index.js'></script>
    </body>
</html>