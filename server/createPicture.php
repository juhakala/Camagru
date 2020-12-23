<?php
require_once('../config/connect.php');
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] == '' || $_SESSION['active'] != '1') {
    echo "error : need to be logged in as activated user";
    die();
}
if (!isset($_POST['width']) || !isset($_POST['height'])) {
    echo "error : \$_POST value_error ";
    die();
}
if (isset($_POST['canvas'])) {
    $imageFileType = 'png';
    $size[0] = [$_POST['width'], $_POST['height']];
    $img = $_POST['canvas'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    file_put_contents('admin1.png', $fileData);
} else {
    $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
    $size[0] = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'admin1.' . $imageFileType);
}
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "error : only JPG, JPEG, PNG & GIF files are allowed.";
    die();
}

$image = imagecreatetruecolor($_POST['width'], $_POST['height']);

$base_image = imagecreatefromstring(file_get_contents('admin1.' . $imageFileType));

imagecopyresized($image, $base_image, 0, 0, 0, 0, $_POST['width'], $_POST['height'], $size[0][0], $size[0][1]);
$stick_arr = json_decode($_POST['stickers']);
for ($i = 0; $stick_arr[$i]; $i++) {
    $stic1 = imagecreatefrompng($stick_arr[$i]->name);
    imagecopyresized($image, $stic1, $stick_arr[$i]->x, $stick_arr[$i]->y, 0, 0, $stick_arr[$i]->width, $stick_arr[$i]->height, imagesx($stic1), imagesy($stic1));
}
try {
    $stmt = $db->prepare('INSERT INTO gallery (name, login) VALUES ("tmp.jpg", :log)');
    $stmt->bindParam(':log', $_SESSION['login']);
    $stmt->execute();
    $last_id = $db->lastInsertId();
    $stmt = $db->prepare('UPDATE `gallery` SET name = :name WHERE id = :last_id');
    $stmt->bindParam(':last_id', $last_id, PDO::PARAM_INT);
    $name = $last_id . '.jpg';
    $stmt->bindParam(':name', $name);
    $stmt->execute();
} catch (PDOException $msg) {
  echo 'Error: '.$msg->getMessage();
  die();
}
imagejpeg( $image, '../img/' . $last_id . '.jpg' );

echo "success : saved to => img/" . $last_id . ".jpg";
