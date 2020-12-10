<?php
require_once('../config/connect.php');
session_start();
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
