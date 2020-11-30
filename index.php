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

        var request = new XMLHttpRequest();
        request.open('GET', 'edit.php', true);
        request.onload = function() {
            if (request.status >= 200 && request.status < 400) {
                var resp = request.responseText;
                document.getElementsByClassName('middle')[0].innerHTML = resp;
            }
        };
        request.send();
    </script>
    </body>
</html>