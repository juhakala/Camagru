<?php
session_start();
require_once('../config/connect.php');
if (isset($_GET['newEmail']) && $_GET['newEmail'] === $_GET['newEmailAgain'])
try {
    $stmt = $db->prepare('SELECT * from `users` WHERE login = :log');
    $stmt->bindParam(':log', $_SESSION['login']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        header('location: ../index.php?error=2&string=how');
        die();
    }
    $stmt = $db->prepare('SELECT * from `users` WHERE email = :email');
    $stmt->bindParam(':email', $_SESSION['newEmail']);
    $stmt->execute();
    $empty = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($empty) {
        header('location: ../index.php?error=2&string=email_in_use');
        die();
    } else if ($row['passwd'] !== hash('whirlpool', $_GET['passwd'])) {
        header('location: ../index.php?error=2&string=passwd_wrong');
        die();
    }
    $stmt = $db->prepare('UPDATE `users` SET email = :email WHERE login = :log');
    $stmt->bindParam(':log', $_SESSION['login']);
    $stmt->bindParam(':email', $_GET['newEmail']);
    $stmt->execute();
    header('location: ../index.php?error=2&string=newEmail_updated');
} catch( PDOException $Exception ) {
    echo 'Error: '.$Exception->getMessage();
    die();
}