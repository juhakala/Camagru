<?php

session_start();
require_once('../config/connect.php');
try {
    $stmt = $db->prepare('SELECT * from `users` WHERE email = :email');
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        echo "mail not in use";
        die();
    }
    $stmt = $db->prepare('UPDATE `users` SET hash = :hash, hash = :hash WHERE email = :email');
    $stmt->bindParam(':email', $_POST['email']);
    $hash = md5(rand(0,1000));
    $stmt->bindParam(':hash', $hash);
    if (!$stmt->execute()) {
        $error = $stmt->errorInfo();
        //header('location: ../index.php?error=2&string='.$error[2]);
        echo "error: " . $error;
        die();
    }
} catch( PDOException $Exception ) {
    echo 'Error: '.$Exception->getMessage();
    die();
}

$to = $_POST['email']; // Send email to our user
$subject = 'Reset | passwd'; // Give the email a subject 
$message = '
  
Please click this link to reset your passwd:
http://localhost:8080/Camagru/login/reset.php?email='.$_POST['email'].'&hash='.$hash.'
  
'; // Our message above including the link
                      
$headers = 'From:noreply@camagru.com' . "\r\n"; // Set from headers
if (mail($to, $subject, $message, $headers) === true) { // Send our email
    echo "success: reset email send";
//    header('location: ../index.php?error=2&string=reset_mail_send');
}