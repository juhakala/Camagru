<?php
require_once('../../config/connect.php');
session_start();
if (isset($_POST['passwd']) && isset($_POST['passwdAgain']) && isset($_SESSION['login']) && $_SESSION['login'] != '' && $_POST['passwd'] === $_POST['passwdAgain']) {
    if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $_POST['passwd'])) {
        echo "error : not valid passwd";
        die();
    }
    try {
        $stmt = $db->prepare('SELECT * FROM `users` WHERE login = :log');
        $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            echo "error : check hash and/or email";
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