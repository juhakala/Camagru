<?php
require_once('../../config/connect.php');
session_start();
if (isset($_POST['passwd']) && isset($_POST['passwdAgain']) && isset($_SESSION['login']) && $_SESSION['login'] != '' && $_POST['passwd'] === $_POST['passwdAgain']) {
    try {
        $stmt = $db->prepare('SELECT * FROM `users` WHERE login = :log');
        $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            echo "error : email and hash did not match";
            die();
        }
        $stmt = $db->prepare('UPDATE `users` SET passwd = :passwd, hash = :hash WHERE login = :log');
        $stmt->bindParam(':log', $_SESSION['login']);
        $pass = hash('whirlpool', $_POST['passwd']);
        $stmt->bindParam(':passwd', $pass);
        $hash = md5(rand(0,1000));
        $stmt->bindParam(':hash', $hash);
        $stmt->execute();
        echo "success : passwd reset";
    } catch( PDOException $Exception ) {
        echo 'Error: '.$Exception->getMessage();
        die();
    }
} else
    echo "error : value error";