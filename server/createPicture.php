<?php
session_start();
print_r($_POST);
echo "<br>";
print_r($_FILES);
echo "<br>";
print_r($_FILES['fileToUpload']);
echo "<br>";
echo $_FILES['fileToUpload']['name'];
echo "<br>";
echo $_FILES['fileToUpload']['tmp_name'];
echo "<br>";

$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
$size[0] = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    die();
}
$target_file = $target_dir . $_SESSION['login'] . "." . $imageFileType;

$image = imagecreatetruecolor($size[0][0], $size[0][1]);

move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'admin1.jpg');
$base_image = imagecreatefromstring(file_get_contents('admin1.jpg'));

imagecopy($image, $base_image, 0, 0, 0, 0, $size[0][0], $size[0][1]);
echo "<br> copied";
$stick_arr = [['name' => '../stickers/mailmonkey.png', 'width' => 300, 'height' => 500, 'x' => 200, 'y' => 400],
              ['name' => '../stickers/stick1.png', 'width' => 500, 'height' => 500, 'x' => 1000, 'y' => 1000],
              ['name' => '../stickers/whatsapp.png', 'width' => 500, 'height' => 500, 'x' => 1400, 'y' => 1400],
              ];
echo "<br> start stickers<br>";
//print_r($stick_arr);
foreach ($stick_arr as $sticker) {
    $stic1 = imagecreatefrompng($sticker['name']);
    imagecopyresized($image, $stic1, $sticker['x'], $sticker['y'], 0, 0, $sticker['width'], $sticker['height'], imagesx($stic1), imagesy($stic1));
    echo "<br>sticker added";
}
imagejpeg( $image, 'admin.jpg' );

echo "<br> at end";