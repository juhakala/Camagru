<?php
require_once('../config/connect.php');
session_start();

$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
$size[0] = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "error : only JPG, JPEG, PNG & GIF files are allowed.";
    die();
}
$target_file = $target_dir . $_SESSION['login'] . "." . $imageFileType;

$image = imagecreatetruecolor($_POST['width'], $_POST['height']);

move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'admin1.jpg');
$base_image = imagecreatefromstring(file_get_contents('admin1.jpg'));

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
echo $db->lastInsertId();