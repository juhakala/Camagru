<?php
require_once('config/connect.php');

if (isset($_SESSION['login']) && $_SESSION['login'] != "") {
    try {
        $stmt = $db->prepare('SELECT (active) FROM `users` WHERE login = :log');
	    $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row)
            $_SESSION['active'] = $row['active'];
        else {
            $_SESSION['login'] = "";
        }
    } catch( PDOException $Exception ) {
        echo 'Error: '.$Exception->getMessage();
        die();
    }
} else
    $_SESSION['login'] = "";