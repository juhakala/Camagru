<?php
session_start();
require_once('../config/connect.php');
if (isset($_GET['newLogin']) && $_GET['newLogin'] === $_GET['newLoginAgain'])
try {
    $stmt = $db->prepare('SELECT * from `users` WHERE login = :log');
    $stmt->bindParam(':log', $_SESSION['login']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        header('location: ../index.php?error=2&string=how');
        die();
    }
    $stmt = $db->prepare('SELECT * from `users` WHERE login = :log');
    $stmt->bindParam(':log', $_GET['newLogin']);
    $stmt->execute();
    $empty = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($empty) {
        header('location: ../index.php?error=2&string=login_in_use');
        die();
    } else if ($row['passwd'] !== hash('whirlpool', $_GET['passwd'])) {
        header('location: ../index.php?error=2&string=passwd_wrong');
        die();
    }
    $stmt = $db->prepare('UPDATE `users` SET login = :logi WHERE login = :log');
    $stmt->bindParam(':log', $_SESSION['login']);
    $stmt->bindParam(':logi', $_GET['newLogin']);
    $stmt->execute();
    $_SESSION['login'] = $_GET['newLogin'];
    header('location: ../index.php?error=2&string=newLogin_updated');
} catch( PDOException $Exception ) {
    echo 'Error: '.$Exception->getMessage();
    die();
}