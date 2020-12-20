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
        `mailing` int(1) NOT NULL DEFAULT "1",
        `active` int(1) NOT NULL DEFAULT "0"
    )');
    $pass = hash('whirlpool', '123');
    $db->exec("INSERT IGNORE INTO users (login, passwd, email, hash, active) VALUES ('admin', '". $pass ."', 'kalle@smil.com', '123', '1')");
    $db->exec("INSERT IGNORE INTO users (login, passwd, email, hash, active) VALUES ('test', '1234', 'ktest@smil.com', '345', '0')");

    $db->exec('CREATE TABLE IF NOT EXISTS gallery (
        id int(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` varchar(255) NOT NULL,
        `login` varchar(255) NOT NULL
    )');
    $db->exec("INSERT IGNORE INTO gallery (name, login) VALUES ('dog1.jpg', 'admin')");
    $db->exec("INSERT IGNORE INTO gallery (name, login) VALUES ('dog2.jpg', 'admin')");
    $db->exec("INSERT IGNORE INTO gallery (name, login) VALUES ('dog3.jpg', 'admin')");
    $db->exec("INSERT IGNORE INTO gallery (name, login) VALUES ('dog4.jpg', 'admin')");
    $db->exec("INSERT IGNORE INTO gallery (name, login) VALUES ('dog5.jpg', 'admin')");
    $db->exec("INSERT IGNORE INTO gallery (name, login) VALUES ('dog6.jpg', 'admin')");

    $db->exec('CREATE TABLE IF NOT EXISTS `stickers` (
        `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `src` varchar(255) NOT NULL
    )');
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('stick1.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('whatsapp.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('mailmonkey.png')");


    $db->exec('CREATE TABLE IF NOT EXISTS `likes` (
        `id_gallery` int(10) unsigned NOT NULL,
        `id_login` int(10) unsigned NOT NULL,
        UNIQUE KEY `id_gallery` (`id_gallery`,`id_login`)
    )');

    $db->exec('CREATE TABLE IF NOT EXISTS comments (
        id int(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `gallery_id` varchar(255) NOT NULL,
        `author` varchar(255) NOT NULL,
        `text` TEXT NOT NULL
    )');

} catch( PDOException $Exception ) {
    echo 'Error: '.$Exception->getMessage();
    die();
}
echo "success";