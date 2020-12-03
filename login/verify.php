<?php
require_once('../config/connect.php');
session_start();
try {
	$stmt = $db->prepare('SELECT * FROM `users` WHERE email = :email');
	$stmt->bindParam(':email', $_GET['email']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && $row['hash'] === $_GET['hash']) {
        $stmt = $db->prepare('UPDATE `users` SET active = "1" WHERE email = :email');
	    $stmt->bindParam(':email', $_GET['email']);
        $stmt->execute();
        $_SESSION['login'] = $row['login'];
    }
    else 
        echo "no match\n";
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	die();
}
header('location: ../index.php');