<?php
session_start();
require_once('../config/connect.php');
if (isset($_GET['login']) && isset($_GET['passwd']) && $_GET['login'] === $_SESSION['login']) {
    try {
        $stmt = $db->prepare('SELECT * from `users` WHERE login = :log');
        $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            header('location: ../index.php?error=2&string=how');
            die();
        } else if ($row['passwd'] !== hash('whirlpool', $_GET['passwd'])) {
            header('location: ../index.php?error=2&string=passwd_wrong');
            die();
        }
        $stmt = $db->prepare('DELETE FROM `users` WHERE login = :log');
        $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->execute();
//        $_SESSION['login'];
        header('location: ../index.php?error=2&string=login_deleted');
    } catch( PDOException $Exception ) {
        echo 'Error: '.$Exception->getMessage();
        die();
    }
}