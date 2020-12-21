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
            if ($_POST['name'] === 'commentMail') {
                if (isset($_POST['changeMail']) && $_POST['changeMail'] == 'change')
                    $stmt = $db->prepare('UPDATE `users` SET mailing = 1 WHERE login = :log');
                else
                    $stmt = $db->prepare('UPDATE `users` SET mailing = 0 WHERE login = :log');
                $stmt->bindParam(':log', $_SESSION['login']);
                $stmt->execute();
                echo "success : mailing preference changed";
            } else if ($_POST['name'] == 'checked') {
                if ($row['mailing'] == 1)
                    echo "success : 1";
                else
                    echo " success : 0";
            } else
                echo "error : passwd did not match one in database";
        } else if ($_POST['name'] === 'passChange' && isset($_POST['newPasswd']) && isset($_POST['newPasswdAgain']) && $_POST['newPasswd'] === $_POST['newPasswdAgain']) {
            if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $_POST['newPasswd'])) {
                echo "error : not a valid passwd";
                die();
            }
            $stmt = $db->prepare('UPDATE `users` SET passwd = :pass WHERE login = :log');
            $stmt->bindParam(':log', $_SESSION['login']);
            $stmt->bindParam(':pass', hash('whirlpool', $_POST['newPasswd']));
            $stmt->execute();
            echo "success : passwd changed";
        } else if ($_POST['name'] === 'emailChange' && isset($_POST['newEmail']) && isset($_POST['newEmailAgain']) && $_POST['newEmail'] === $_POST['newEmailAgain']) {
            if (!preg_match('/^\S+@\S+\.\S+$/', $_POST['newEmail'])) {
                echo "error : not a valid email";
                die();
            } 
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
            if (!preg_match('/^[A-Z][a-z]{2,}$/' , $_POST['newLogin'])) {
                echo "error : not a valid login";
                die();
            }   
            $stmt = $db->prepare('SELECT * from `users` WHERE login = :log');
            $stmt->bindParam(':log', $_POST['newLogin']);
            $stmt->execute();
            $empty = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($empty) {
                echo "error : login in use";
            } else {
                $stmt = $db->prepare('UPDATE `comments` SET author = :new WHERE author = :log');
                $stmt->bindParam(':log', $_SESSION['login']);
                $stmt->bindParam(':new', $_POST['newLogin']);
                $stmt->execute();

                $stmt = $db->prepare('UPDATE `gallery` SET login = :new WHERE login = :log');
                $stmt->bindParam(':log', $_SESSION['login']);
                $stmt->bindParam(':new', $_POST['newLogin']);
                $stmt->execute();

                $stmt = $db->prepare('UPDATE `users` SET login = :logi WHERE login = :log');
                $stmt->bindParam(':log', $_SESSION['login']);
                $stmt->bindParam(':logi', $_POST['newLogin']);
                $stmt->execute();
                $_SESSION['login'] = $_POST['newLogin'];
                echo "success : login changed";
            }
        } else if ($_POST['name'] === 'loginDelete' && isset($_POST['login']) && $_POST['login'] === $_SESSION['login']) {
            $id = $row['id'];
            $stmt = $db->prepare('DELETE FROM `likes` WHERE id_login = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt = $db->prepare('UPDATE `comments` SET author = :new WHERE author = :log');
            $stmt->bindParam(':log', 'deleted['.$id.']');
            $stmt->bindParam(':log', $_SESSION['login']);
            $stmt->execute();

            $stmt = $db->prepare('SELECT * FROM `gallery` WHERE login = :log');
            $stmt->bindParam(':log', $_SESSION['login']);
            $stmt->execute();
            $row = $row = $stmt->fetch(PDO::FETCH_ASSOC);
            while ($row) {
                unlink('../img/' . $row['name']);
                $row = $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            $stmt = $db->prepare('DELETE FROM `gallery` WHERE login = :log');
            $stmt->bindParam(':log', $_SESSION['login']);
            $stmt->execute();

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