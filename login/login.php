<?php
require_once('../config/connect.php');
session_start();
try {
	$stmt = $db->prepare('SELECT * FROM `users` WHERE login = :log');
	$stmt->bindParam(':log', $_GET['login']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($stmt);
    print_r($row);
    if ($row && hash('whirlpool', $_GET['passwd']) ===  $row['passwd']) {
        echo "success\n";
        $_SESSION['login'] = $row['login'];
        header('location: ../index.php');
    }
    else 
        echo "no match\n";
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	die();
}
