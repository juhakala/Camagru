<?php
require_once('../config/connect.php');
session_start();
if ($_GET['passwd'] == $_GET['passwdAgain']) {
    try {
    	$stmt = $db->prepare('SELECT * FROM `users` WHERE login = :log');
    	$stmt->bindParam(':log', $_GET['login']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            header('location: ../index.php');
            echo "noo\n";
        }
        else {
            echo "hello\n";
            $stmt = $db->prepare('INSERT INTO users (login, passwd, email) VALUES (:log, :passwd, :mail)');
            $stmt->bindParam(':log', $_GET['login']);
            $stmt->bindParam(':passwd', hash('whirlpool', $_GET['passwd']));
            $stmt->bindParam(':mail', $_GET['email']);
            $stmt->execute();
            $_SESSION['login'] = $_GET['login'];
            header('location: ../index.php');
        }
    } catch (PDOException $msg) {
    	echo 'Error: '.$msg->getMessage();
    	die();
    }
}
else
    header('location: ../index.php');