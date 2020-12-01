<?php
require_once('../config/connect.php');
session_start();
if ($_GET['passwd'] == $_GET['passwdAgain']) {
    try {
    	$stmt = $db->prepare('SELECT * FROM `users` WHERE login = :log');
    	$stmt->bindParam(':log', $_GET['login']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            header('location: ../index.php?error=2&string='.$_GET['login'].'_in_use');
        } else {
            $stmt = $db->prepare('INSERT INTO users (login, passwd, email, hash) VALUES (:log, :passwd, :mail, :hash)');
            $stmt->bindParam(':log', $_GET['login']);
            $stmt->bindParam(':passwd', hash('whirlpool', $_GET['passwd']));
            $stmt->bindParam(':mail', $_GET['email']);
            $hash = md5(rand(0,1000));
            $stmt->bindParam(':hash', $hash);
            if(!$stmt->execute()) {
                $error = $stmt->errorInfo();
                echo "here";
                header('location: ../index.php?error=2&string='.$error[2]);
                die();
            }
            $_SESSION['login'] = $_GET['login'];
            include('verifyEmail.php');
            $_SESSION['active'] = '0';
            echo "he1re\n";
            header('location: ../index.php');
        }
    } catch (PDOException $msg) {
    	echo 'Error: '.$msg->getMessage();
    	die();
    }
}
else {
    header('location: ../index.php?error=2&string=passwd_and_passwd_no_match');
}