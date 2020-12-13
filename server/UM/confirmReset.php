<?php
require_once('../../config/connect.php');
session_start();

if (isset($_POST['passwd']) && $_POST['passwd'] === $_POST['passwdAgain']) {
    try {
        $stmt = $db->prepare('SELECT * FROM `users` WHERE email = :email AND hash = :hash');
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':hash', $_POST['hash']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            echo "email and hash did not match";
            die();
        }
        $stmt = $db->prepare('UPDATE `users` SET passwd = :passwd, hash = :hash WHERE email = :email');
        $stmt->bindParam(':email', $_POST['email']);
        $pass = hash('whirlpool', $_POST['passwd']);
        $stmt->bindParam(':passwd', $pass);
        $hash = md5(rand(0,1000));
        $stmt->bindParam(':hash', $hash);
        $stmt->execute();
        header('location: ../../index.php?message=passwd_reset');
    } catch( PDOException $Exception ) {
        echo 'Error: '.$Exception->getMessage();
        die();
    }
}