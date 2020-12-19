<?php
session_start();
echo "start ";
print_r($_POST);
echo "<br>";
//print_r($_POST);
//echo "<br>";
//print_r($_FILES);
//echo "<br>";
//print_r($_FILES['fileToUpload']);
//echo "<br>";
//echo $_FILES['fileToUpload']['name'];
//echo "<br>";
//echo $_FILES['fileToUpload']['tmp_name'];
//echo "<br>";

$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
$size[0] = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    die();
}
$target_file = $target_dir . $_SESSION['login'] . "." . $imageFileType;

$image = imagecreatetruecolor($_POST['width'], $_POST['height']);

move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'admin1.jpg');
$base_image = imagecreatefromstring(file_get_contents('admin1.jpg'));

imagecopyresized($image, $base_image, 0, 0, 0, 0, $_POST['width'], $_POST['height'], $size[0][0], $size[0][1]);
//echo "<br> copied";
/*
name => sticker name (daa)
widht, height => how big and what scale you want sticker to be
x, y => starting coordinates for placing the sticker to $image
*/
$stick_arr = [['name' => '../stickers/mailmonkey.png', 'width' => 300, 'height' => 500, 'x' => -100, 'y' => 400],
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

//new image is in server/admin.jpg
// with tmp admin1.jpg
imagejpeg( $image, 'admin.jpg' );

echo "<br> at end";