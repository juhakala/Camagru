<?php
require_once('../../config/connect.php');
session_start();
if (isset($_GET['email']) && $_GET['email'] != '' && isset($_GET['hash']) && $_GET['hash'] != '') {
    try {
    	$stmt = $db->prepare('SELECT * FROM `users` WHERE email = :email');
    	$stmt->bindParam(':email', $_GET['email']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && $row['hash'] === $_GET['hash']) {
            $stmt = $db->prepare('UPDATE `users` SET active = "1", hash = :hash WHERE email = :email');
            $stmt->bindParam(':email', $_GET['email']);
            $hash = md5(rand(0,1000));
            $stmt->bindParam(':hash', $hash);
            $stmt->execute();
            $_SESSION['login'] = $row['login'];
        }
        else {
            echo "no match\n";
            die();
        }
    } catch (PDOException $msg) {
    	echo 'error: '.$msg->getMessage();
    	die();
    }
    header('location: ../../index.php');
}