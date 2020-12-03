<?php
session_start();
require_once('../config/connect.php');
if ($_GET['newPasswd'] === $_GET['newPasswdAgain']) {
    try {
        $stmt = $db->prepare('SELECT * from `users` WHERE login = :log');
        $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            header('location: ../index.php?error=2&string=how');
            die();
        } else if ($row['passwd'] !== hash('whirlpool', $_GET['oldPasswd'])) {
            header('location: ../index.php?error=2&string=oldPasswd_wrong');
            die();
        }
        $stmt = $db->prepare('UPDATE `users` SET passwd = :pass WHERE login = :log');
        $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->bindParam(':pass', hash('whirlpool', $_GET['newPasswd']));
        $stmt->execute();
        header('location: ../index.php?error=2&string=newPasswd_updated');
    } catch( PDOException $Exception ) {
        echo 'Error: '.$Exception->getMessage();
        die();
    }
}