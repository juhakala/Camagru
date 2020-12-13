<?php
session_start();
require_once('../../config/connect.php');

if (isset($_POST['name']) && isset($_SESSION['login']) && $_SESSION['login'] != "" && isset($_SESSION['active']) && $_SESSION['active'] === '1' && isset($_POST['passwd'])) {
    try {
        $stmt = $db->prepare('SELECT * from `users` WHERE login = :log');
        $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            echo "error : Cheater!";
        } else if ($row['passwd'] !== hash('whirlpool', $_POST['passwd'])) {
            echo "error : passwd did not match one in database";
        } else if ($_POST['name'] === 'passChange' && isset($_POST['newPasswd']) && isset($_POST['newPasswdAgain']) && $_POST['newPasswd'] === $_POST['newPasswdAgain']) {
            $stmt = $db->prepare('UPDATE `users` SET passwd = :pass WHERE login = :log');
            $stmt->bindParam(':log', $_SESSION['login']);
            $stmt->bindParam(':pass', hash('whirlpool', $_POST['newPasswd']));
            $stmt->execute();
            echo "success : passwd changed";
        } else if ($_POST['name'] === 'emailChange' && isset($_POST['newEmail']) && isset($_POST['newEmailAgain']) && $_POST['newEmail'] === $_POST['newEmailAgain']) {
            $stmt = $db->prepare('SELECT * from `users` WHERE email = :email');
            $stmt->bindParam(':email', $_POST['newEmail']);
            $stmt->execute();
            $empty = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($empty) {
                echo "error : email in use";
            } else {
                $stmt = $db->prepare('UPDATE `users` SET email = :email WHERE login = :log');
                $stmt->bindParam(':log', $_SESSION['login']);
                $stmt->bindParam(':email', $_POST['newEmail']);
                $stmt->execute();
                echo "success : email changed";
            }
        } else if ($_POST['name'] === 'loginChange' && isset($_POST['newLogin']) && isset($_POST['newLoginAgain']) && $_POST['newLogin'] === $_POST['newLoginAgain']) {
            $stmt = $db->prepare('SELECT * from `users` WHERE login = :log');
            $stmt->bindParam(':log', $_POST['newLogin']);
            $stmt->execute();
            $empty = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($empty) {
                echo "error : login in use";
            } else {
                $stmt = $db->prepare('UPDATE `users` SET login = :logi WHERE login = :log');
                $stmt->bindParam(':log', $_SESSION['login']);
                $stmt->bindParam(':logi', $_POST['newLogin']);
                $stmt->execute();
                $_SESSION['login'] = $_POST['newLogin'];
                echo "success : login changed";
            }
        } else if ($_POST['name'] === 'loginDelete' && isset($_POST['login']) && $_POST['login'] === $_SESSION['login']) {
            $stmt = $db->prepare('DELETE FROM `users` WHERE login = :log');
            $stmt->bindParam(':log', $_SESSION['login']);
            $stmt->execute();
            $_SESSION['login'] = "";
            echo "success : login deleted";
        } else {
            echo "error : check values";
        }
    } catch( PDOException $Exception ) {
        echo 'Error: '.$Exception->getMessage();
        die();
    }
}