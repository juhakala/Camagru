<?php
session_start();
$target_dir = "uploads/";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
$target_file = $target_dir . $_SESSION['login'] . "." . $imageFileType;
//echo $imageFileType."<br>";
//echo basename($_FILES["fileToUpload"]["name"]) . "<br>";
//echo $_FILES["fileToUpload"]["name"] . "<br>";

if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false)
    $uploadOk = 1;
  else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}
$target_file = $target_dir . $_SESSION['login'] . "." . $imageFileType;

if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
} else {
  move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}
?>