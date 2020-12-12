<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] != "" && $_SESSION['active'] == 0) {
    header('location: api/verifyAgain.php');
    die();
}
?>
<div id="test"></div>
<div id='ontop'>
    <div id="wrapper">
        <div id="content"></div>
    </div>
</div>
<script src='js/tt.js'></script>