<?php
require_once('../config/connect.php');
session_start();
if (isset($_GET['passwd']) && $_GET['passwd'] == $_GET['passwdAgain']) {
    try {
    	$stmt = $db->prepare('SELECT * FROM `users` WHERE login = :log OR email = :email');
        $stmt->bindParam(':log', $_GET['login']);
        $stmt->bindParam(':email', $_GET['email']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            header('location: ../index.php?error=2&string=login_or_email_in_use');
        } else {
            $stmt = $db->prepare('INSERT IGNORE INTO users (login, passwd, email, hash) VALUES (:log, :passwd, :mail, :hash)');
            $stmt->bindParam(':log', $_GET['login']);
            $stmt->bindParam(':passwd', hash('whirlpool', $_GET['passwd']));
            $stmt->bindParam(':mail', $_GET['email']);
            $hash = md5(rand(0,1000));
            $stmt->bindParam(':hash', $hash);
            $stmt->execute();
            $_SESSION['login'] = $_GET['login'];
            include('verifyEmail.php');
            $_SESSION['active'] = '0';
            header('location: ../index.php');
        }
    } catch (PDOException $msg) {
    	echo 'Error: '.$msg->getMessage();
    	die();
    }
}
else {
    header('location: ../index.php?error=2&string=passwd_and_passwdAgain_no_match');
}