<?php
require_once('../config/connect.php');
session_start();

if (isset($_POST['login']) && isset($_POST['passwd'])) {
    try {
    	$stmt = $db->prepare('SELECT * FROM `users` WHERE login = :log');
    	$stmt->bindParam(':log', $_POST['login']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            if (hash('whirlpool', $_POST['passwd']) ===  $row['passwd']) {
                $_SESSION['login'] = $row['login'];
                $_SESSION['active'] = $row['active'];
                echo "success";
            } else {
                echo "error: passwd did not match";
                die();
            }
        }
        else {
            echo "error: no user named: " . $_POST['login'];
        }
    } catch (PDOException $msg) {
    	echo 'Error: '.$msg->getMessage();
    	die();
    }
} else
    echo "genericreturn value";
?>
