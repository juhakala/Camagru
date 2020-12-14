<?php
require_once('../config/connect.php');
session_start();

if (isset($_POST['start'])) {
    try {
        $stmt = $db->prepare('SELECT * FROM `gallery` LIMIT 4 OFFSET :start');
        $stmt->bindValue(':start', (int) $_POST['start'], PDO::PARAM_INT); 
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $res_array = array();
            $i = 0;
            for ($i = 0; $row; $i++) {
                $res_array[$i] = $row;
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            echo json_encode($res_array);
            die();
        } else {
            echo "error : no pics left";
            die();
        }
    } catch (PDOException $msg) {
        echo 'error : '.$msg->getMessage();
        die();
    }
} else if (isset($_POST['gallery_id'])) {
    try {
        $stmt = $db->prepare('SELECT * FROM `comments` WHERE gallery_id = :gallery_id');
        $stmt->bindValue(':gallery_id', (int) $_POST['gallery_id'], PDO::PARAM_INT); 
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $res_array = array();
        $i = 0;
        if ($row) {
            for ($i = 0; $row; $i++) {
                $res_array[$i] = $row;
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
        $like_count = $db->prepare('SELECT COUNT(*) FROM `likes` WHERE id_gallery = :gallery_id');
        $like_count->bindValue(':gallery_id', (int) $_POST['gallery_id'], PDO::PARAM_INT);
        $like_count->execute();
        $res_array[$i]['likes'] = $like_count->fetchColumn();
        $res_array[$i]['comments'] = $i;
        echo json_encode($res_array);
    } catch (PDOException $msg) {
        echo 'error : '.$msg->getMessage();
        die();
    }
} else if (isset($_POST['like_id'])) {
    if (!isset($_SESSION['login']) || $_SESSION['login'] == '') {
        echo "error : need to login to like";
        die();
    }
    try {
        $stmt = $db->prepare('INSERT IGNORE INTO likes (id_gallery, id_login) VALUES (:id_gallery, (SELECT id FROM users WHERE login = :log))');
        $stmt->bindValue(':id_gallery', (int) $_POST['like_id'], PDO::PARAM_INT);
        $stmt->bindValue(':log', $_SESSION['login']);
        if ($stmt->execute() && $stmt->rowCount() > 0)
            echo "success : liked picture";
        else
            echo "error : already liked this picture";
    } catch (PDOException $msg) {
        echo 'error : '.$msg->getMessage();
        die();
    }
}
