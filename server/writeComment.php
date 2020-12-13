<?php
require_once('../config/connect.php');
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == '') {
    echo "need to login to comment";
    die();
} else if (isset($_SESSION['active']) && $_SESSION['active'] === '0') {
    echo "need to verify user to comment";
    die();
}
if (isset($_POST['id']) && $_POST['id'] != '' && isset($_POST['comment']) && trim($_POST['comment']) != '') {
    try {
        $stmt = $db->prepare('INSERT INTO comments (gallery_id, author, text) VALUES (:id, :log, :comment)');
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->bindParam(':comment', trim($_POST['comment']));
        $stmt->execute();
        //$row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $msg) {
    	echo 'Error: '.$msg->getMessage();
    	die();
    }
    echo "success comment : " . $_POST['comment'];
} else {
    echo "error : where is the comment?";
}