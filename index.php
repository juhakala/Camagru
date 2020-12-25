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
        <link rel="stylesheet" href="api/css/default.css">
        <link rel="stylesheet" href="api/css/styleindex.css">
        <link rel="stylesheet" href="api/css/header.css">
        <link rel="stylesheet" href="api/css/footer.css">
        <link rel="stylesheet" href="api/css/edit.css">
        <link rel="stylesheet" href="api/css/gallery.css">
        <link rel="stylesheet" href="api/css/userSettings.css">

    </head>
    <body>
        <div class='head'>
            <?php include('header.php'); ?>
        </div>
        <div class='middle'>
            <!-- middle part with xmlhttprequests mainly by masters and slaves functions-->
        </div>
        <div class='footer'>
            <?php include('footer.php'); ?>
        </div>
    <script src='js/index.js'></script>
    <script src='js/header.js'></script>
    <script src='js/footer.js'></script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            masters( sessionStorage.getItem('page'), sessionStorage.getItem('form'));
        });
        function masters(str, form) {
            slaves( str, form, '<?php echo $_POST['email']; ?>', '<?php echo $_POST['email']; ?>');
        }
        var message = '<?php echo $_GET['message']; ?>';
        if (message != "")
            messageBox(message, 'green'); 
    </script>
    <script src="js/themes.js"></script>
    <script id="tmpScript"></script>
    </body>
</html>