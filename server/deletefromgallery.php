<?php
require_once('../config/connect.php');
session_start();
if (isset($_POST['delete']) && $_POST['delete'] != '' && isset($_POST['name']) && $_POST['name'] != '' && isset($_SESSION['login']) && $_SESSION['login'] != '') {
    try {
        $stmt = $db->prepare('DELETE FROM gallery WHERE id = :id AND login = :log');
        $stmt->bindParam(':id', $_POST['delete'], PDO::PARAM_INT);
        $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $stmt = $db->prepare('DELETE FROM comments WHERE gallery_id = :id');
            $stmt->bindParam(':id', $_POST['delete'], PDO::PARAM_INT);
            $stmt->execute();
            $stmt = $db->prepare('DELETE FROM likes WHERE id_gallery = :id');
            $stmt->bindParam(':id', $_POST['delete'], PDO::PARAM_INT);
            $stmt->execute();
            unlink('../img/' . $_POST['name']);
            echo "success : picture deleted";
        } else {
            echo "error : picture not deleted";
        }
    } catch( PDOException $Exception ) {
        echo 'Error: '.$Exception->getMessage();
        die();
    }
}