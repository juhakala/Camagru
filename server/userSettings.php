<?php
session_start();
require_once('../config/connect.php');
if (isset($_GET['submit']) && isset($_SESSION['login']) && $_SESSION['login'] != "" && isset($_GET['passwd'])) {
    if ($_GET['submit'] === 'changePasswd' && $_GET['newPasswd'] === $_GET['newPasswdAgain']) {
        try {
            $stmt = $db->prepare('SELECT * from `users` WHERE login = :log');
            $stmt->bindParam(':log', $_SESSION['login']);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                header('location: ../index.php?error=2&string=how');
                die();
            } else if ($row['passwd'] !== hash('whirlpool', $_GET['passwd'])) {
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
    } else if ($_GET['submit'] === 'changeEmail' && isset($_GET['newEmail']) && $_GET['newEmail'] === $_GET['newEmailAgain']) {
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
    } else if ($_GET['submit'] === 'changeLogin' && isset($_GET['newLogin']) && $_GET['newLogin'] === $_GET['newLoginAgain']) {
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
    } else if ($_GET['submit'] === 'deleteLogin' && isset($_GET['login']) && isset($_GET['passwd']) && $_GET['login'] === $_SESSION['login']) {
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
            $_SESSION['login'] = "";
            header('location: ../index.php?error=2&string=login_deleted');
        } catch( PDOException $Exception ) {
            echo 'Error: '.$Exception->getMessage();
            die();
        }
    }
}