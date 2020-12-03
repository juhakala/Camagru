<?php
require_once('database.php');
$db = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
try {
    $stmt = $db->prepare("SELECT * FROM information_schema.tables WHERE 
    table_schema = '".$DB_BASE."' AND table_name = 'users' LIMIT 1");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row)
        require_once('setup.php'); 
} catch( PDOException $Exception ) {
    echo 'Error: '.$Exception->getMessage();
    die();
}