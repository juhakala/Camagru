<?php
session_start();
require_once('config/run_setup.php');
require_once('server/verifySessionLogin.php');
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Camagru</title>
        <link rel="stylesheet" href="api/css/styleindex.css">
        <link rel="stylesheet" href="api/css/header.css">
        <link rel="stylesheet" href="api/css/edit.css">
        <link rel="stylesheet" href="api/css/gallery.css">
        <link rel="stylesheet" href="api/css/userSettings.css">

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
    <script src='js/index.js'></script>
    <script src='js/header.js'></script>
    <script>
        var login = '<?php echo $_SESSION['login']; ?>';
        var active = '<?php echo $_SESSION['active']; ?>';

        var url = (sessionStorage.getItem('page') == 'null' || sessionStorage.getItem('page') == null || sessionStorage.getItem('page') == 'api/UM/verifyAgain.php') ? 'api/gallery.php' : sessionStorage.getItem('page');
        var form = url == 'api/gallery.php' ? 'js/gallery.js' : sessionStorage.getItem('form');
        window.addEventListener('DOMContentLoaded', (event) => {
            masters(url, form); //for div appending
        });
        function masters(str, form) {
            if (login != '' && active === '0') {//always redirect to verifyAgain if not active
                slaves('api/UM/verifyAgain.php', 'null');
<?php echo "} else if ('{$_SESSION['login']}' != '' && '{$_POST['email']}' != '' && '{$_POST['hash']}' != '') {
                slaves('api/UM/resetPass.php', 'js/forms.js');";?>
            } else
                slaves(str, form);
        }
        var message = '<?php echo $_GET['message']; ?>';
        if (message != "")
            messageBox(message, 'green'); 
    </script>
    <script id="tmpScript"></script>
    </body>
</html>