<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == "" || $_SESSION['active'] == 0) {
    //header('location: verifyAgain.php');
    die();
}
?>
<div class='container'>
    <div class='inner'>
        <div class="navbar">
            <div class='change' onclick='createForm("passChange")'>ChangePassw</div>
            <div class='change' onclick='createForm("emailChange")'>ChangeEmail</div>
            <div class='change' onclick='createForm("loginChange")'>ChangeLogin</div>
            <div class='change' onclick='createForm("loginDelete")'>DeleteLogin</div>
        </div>
        <div class='formParent'>
        </div>
    </div>
</div>