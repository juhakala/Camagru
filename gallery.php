<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] != "" && $_SESSION['active'] == 0) {
    header('location: api/verifyAgain.php');
    die();
}
?>
<div id="test"></div>
<div id="wrapper" style="height: 60vh; margin: 10vh; overflow: auto;">
    <div id="content">
    </div>
</div>
