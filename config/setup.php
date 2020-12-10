<?php
require_once('database.php');

$db = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
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
    $db->exec("INSERT IGNORE INTO users (login, passwd, email, hash, active) VALUES ('admin', '". $pass ."', 'kalle@smil.com', '123', '1')");
    $db->exec("INSERT IGNORE INTO users (login, passwd, email, hash, active) VALUES ('test', '1234', 'ktest@smil.com', '345', '0')");

    $db->exec('CREATE TABLE IF NOT EXISTS gallery (
        id int(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` varchar(255) NOT NULL,
        `login` varchar(255) NOT NULL,
        `likes` int(9) UNSIGNED NOT NULL default 0,
        `width` int(9) UNSIGNED NOT NULL,
        `height` int(9) UNSIGNED NOT NULL
        )');
    $db->exec("INSERT IGNORE INTO gallery (name, login, likes, width, height) VALUES ('dog1.jpg', 'admin', 12, '4000', '5000')");
    $db->exec("INSERT IGNORE INTO gallery (name, login, width, height) VALUES ('dog2.jpg', 'admin', '3024', '4032')");
    $db->exec("INSERT IGNORE INTO gallery (name, login, width, height) VALUES ('dog3.jpg', 'admin', '4978', '3734')");
    $db->exec("INSERT IGNORE INTO gallery (name, login, width, height) VALUES ('dog4.jpg', 'admin', '7375', '4919')");
    $db->exec("INSERT IGNORE INTO gallery (name, login, width, height) VALUES ('dog5.jpg', 'admin', '5184', '3456')");
    $db->exec("INSERT IGNORE INTO gallery (name, login, width, height) VALUES ('dog6.jpg', 'admin', '3648', '5472')");

} catch( PDOException $Exception ) {
    echo 'Error: '.$Exception->getMessage();
    die();
}
echo "success";