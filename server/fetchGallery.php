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
        echo 'Error: '.$msg->getMessage();
        die();
    }
}
if (isset($_POST['gallery_id'])) {
    try {
        $stmt = $db->prepare('SELECT * FROM `comments` WHERE gallery_id = :gallery_id');
        $stmt->bindValue(':gallery_id', (int) $_POST['gallery_id'], PDO::PARAM_INT); 
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
            echo "error : no comments";
        }
    } catch (PDOException $msg) {
        echo 'Error: '.$msg->getMessage();
        die();
    }
}