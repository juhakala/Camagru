<?php
session_start();
//$data = json_decode($_POST['data'], true);
//die();
$data = explode(',', $_POST['url']);
//$size[0] = getimagesize($_POST['url']);
//$size[0] = getimagesize(base64_decode($data[1]));
$size[0] = getimagesize($_POST['url']);


print_r($size);
//print_r($data);
//echo "\nhali\nnali\nkali\n";
//$_POST_obj = explode(',', $_POST['url']);
//echo $_POST_obj[0]. "\n\n\n";
//echo $_POST_obj[1]. "\n\n\n";
//$decoded_data = base64_decode($_POST_obj[1]);
$image = imagecreatetruecolor($size[0][0], $size[0][1]);
die();
if ($base_image = imagecreatefromstring($_POST['url']) === false) {
    echo ' from string failed ';
} else {
    echo ' success ';
    echo 'base image is : ' . $base_image;
}

//imagecopy($image, $base_image, 0, 0, 0, 0, 100, 100);//$size[1][0], $size[1][1]);
//imagejpeg( $image, 'admin.jpg' );


//echo "saved?";
die();
//$base_image = imagecreatefromjpeg($)