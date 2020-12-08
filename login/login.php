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
                //header('location: ../index.php');
                echo "success";
            } else {
                echo "error: passwd did not match";
                die();
            }
        }
        else {
    //        header('location: ../index.php?error=2&string=no_match');
            //header('location: ../index.php');
            //echo "<script>console.log('hello');</script>";
            //echo "<script type='text/javascript' src='js/index.js'>messageBox('not_match');</script>";
            echo "error: no user named: " . $_POST['login'];
        }
    } catch (PDOException $msg) {
    	echo 'Error: '.$msg->getMessage();
    	die();
    }
} else
    echo "genericreturn value";
?>
