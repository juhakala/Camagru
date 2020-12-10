<?php
require_once('../config/connect.php');
session_start();
if (isset($_POST['passwd']) && $_POST['passwd'] == $_POST['passwdAgain']) {
    try {
    	$stmt = $db->prepare('SELECT * FROM `users` WHERE login = :log OR email = :email');
        $stmt->bindParam(':log', $_POST['login']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            //header('location: ../index.php?error=2&string=login_or_email_in_use');
            echo "login or email in use already";
        } else {
            $stmt = $db->prepare('INSERT IGNORE INTO users (login, passwd, email, hash) VALUES (:log, :passwd, :mail, :hash)');
            $stmt->bindParam(':log', $_POST['login']);
            $stmt->bindParam(':passwd', hash('whirlpool', $_POST['passwd']));
            $stmt->bindParam(':mail', $_POST['email']);
            $hash = md5(rand(0,1000));
            $stmt->bindParam(':hash', $hash);
            $stmt->execute();
            $_SESSION['login'] = $_POST['login'];
            include('verifyEmail.php');
            $_SESSION['active'] = '0';
            //header('location: ../index.php');
            echo "success: verify email";
        }
    } catch (PDOException $msg) {
    	echo 'Error: '.$msg->getMessage();
    	die();
    }
}
else {
    //header('location: ../index.php?error=2&string=passwd_and_passwdAgain_no_match');
    echo "passwds did not match";
}