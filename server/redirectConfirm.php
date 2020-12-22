<?php
session_start();
$logged_in = ['api/edit.php', 'api/UM/userSettings.php', 'api/UM/resetPass.php'];
$logged_out = ['api/UM/forgotPass.php"', 'api/UM/newUser.php', 'api/UM/login.php'];
if (isset($_POST['email']) && $_POST['email'] != '' && isset($_POST['hash']) && $_POST['hash'] != '') {
    if (!isset($_SESSION['login']) || $_SESSION['login'] == '') {
        require_once('../api/cheater.php');
        $_SESSION['aredirectConfirm'] = 0;
    } else {
        require_once('../api/UM/resetPass.php');
        $_SESSION['aredirectConfirm'] = 2;
    }
    die();
}
if (isset($_POST['url']) && $_POST['url'] != '') {
    if (!isset($_SESSION['login']) || $_SESSION['login'] == '') {
        if (in_array($_POST['url'], $logged_in)) {
            require_once('../api/cheater.php');
            $_SESSION['aredirectConfirm'] = 0;
        } else {
            require_once('../' . $_POST['url']);
            $_SESSION['aredirectConfirm'] = 1;
        }
    } else if ($_SESSION['active'] != '1') {
        require_once('../api/UM/verifyAgain.php');
        $_SESSION['aredirectConfirm'] = 2;
    } else {
        if (in_array($_POST['url'], $logged_out)) {
            require_once('../api/cheater.php');
            $_SESSION['aredirectConfirm'] = 0;
        } else {
            require_once('../' . $_POST['url']);
            $_SESSION['aredirectConfirm'] = 1;
        }
    }
} else if (isset($_POST['data']) && $_POST['data'] != '') {
    if (isset($_SESSION['aredirectConfirm']) && $_SESSION['aredirectConfirm'] == 1) {
        require_once('../' . $_POST['data']);
    } else if (isset($_SESSION['aredirectConfirm']) && $_SESSION['aredirectConfirm'] == 2) {
        require_once('../js/forms.js');
    } else {
        echo "";
    }
} else {
    echo "\$_POST['url/data'] missing";
}