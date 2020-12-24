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
    $db->exec("INSERT IGNORE INTO users (login, passwd, email, hash, active) VALUES ('Admin', '". $pass ."', 'kalle@smil.com', '1234567890123345567789', '1')");

    $db->exec('CREATE TABLE IF NOT EXISTS gallery (
        id int(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` varchar(255) NOT NULL,
        `login` varchar(255) NOT NULL
    )');
    $db->exec("INSERT IGNORE INTO gallery (name, login) VALUES ('dog1.jpg', 'admin')");
    $db->exec("INSERT IGNORE INTO gallery (name, login) VALUES ('dog2.jpg', 'admin')");
    $db->exec("INSERT IGNORE INTO gallery (name, login) VALUES ('dog3.jpg', 'admin')");

    $db->exec('CREATE TABLE IF NOT EXISTS `stickers` (
        `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `src` varchar(255) NOT NULL
    )');
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('stick1.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('whatsapp.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('mailmonkey.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('rolrs.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('wies.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('pors.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('mase.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('knight.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('hat-top.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('hat-russia.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('hat-cook.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('hat-cowboy.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('hat-pirate.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('eye1.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('eye2.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('we-know.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('panda.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('ani-cat.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('cat.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('cat2.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('dog1.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('dog2.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('dog3.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('dog4.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('fire.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('100.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('fail.png')");
    $db->exec("INSERT IGNORE INTO stickers (src) VALUES ('heart.png')");





    




















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