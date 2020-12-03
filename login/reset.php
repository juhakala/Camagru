<?php
require_once('../config/connect.php');
session_start();

if (isset($_GET['passwd']) && $_GET['passwd'] === $_GET['passwdAgain']) {
    try {
        $stmt = $db->prepare('SELECT * FROM `users` WHERE email = :email AND hash = :hash');
        $stmt->bindParam(':email', $_GET['email']);
        $stmt->bindParam(':hash', $_GET['hash']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            header('location: ../index.php?error=2&string=cheater');
            die();
        }
        $stmt = $db->prepare('UPDATE `users` SET passwd = :passwd WHERE email = :email');
        $stmt->bindParam(':email', $_GET['email']);
        $pass = hash('whirlpool', $_GET['passwd']);
        $stmt->bindParam(':passwd', $pass);
        $stmt->execute();
        header('location: ../index.php?error=2&string=passwd_reset');
    } catch( PDOException $Exception ) {
        echo 'Error: '.$Exception->getMessage();
        die();
    }
}