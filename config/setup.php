<?php
require_once('database.php');

$db = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ERRMODE_EXCEPTION);
try {
    $db->exec('CREATE DATABASE IF NOT EXISTS ' . $DB_BASE);
    $db->exec('use ' . $DB_BASE);
    $db->exec('CREATE TABLE IF NOT EXISTS users (
        id int(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `login` varchar(255) NOT NULL unique,
        `passwd` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL unique,
        `hash` varchar(32) NOT NULL,
        `active` int(1) NOT NULL DEFAULT "0"
        )');
    $pass = hash('whirlpool', '123');
    $db->exec("INSERT INTO users (login, passwd, email, hash, active) VALUES ('admin', '". $pass ."', 'kalle@smil.com', '123', '1')");
    $db->exec("INSERT INTO users (login, passwd, email, hash, active) VALUES ('test', '1234', 'ktest@smil.com', '345', '0')");

    $db->exec('CREATE TABLE IF NOT EXISTS gallery (
        id int(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `login` varchar(255) NOT NULL,
        `likes` int(9) UNSIGNED NOT NULL
        )');
}
catch( PDOException $Exception ) {
    echo 'Error: '.$Exception->getMessage();
    die();
}
echo "success";