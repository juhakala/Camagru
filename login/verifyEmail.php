<?php
if (isset($_GET['submit']) && $_GET['submit'] == 'again') {
    session_start();
    require_once('../config/connect.php');
    $stmt = $db->prepare('UPDATE `users` SET email = :email, hash = :hash WHERE login = :log');
    $stmt->bindParam(':log', $_SESSION['login']);
    $stmt->bindParam(':email', $_GET['email']);
    $hash = md5(rand(0,1000));
    $stmt->bindParam(':hash', $hash);
    $stmt->execute();
}
$to = $_GET['email']; // Send email to our user
$subject = 'Signup | Verification'; // Give the email a subject 
$message = '
  
Thanks for signing up!
Your account has been created, you can login after you have activated your account by pressing the url below.
  
------------------------
Username: '.$_SESSION['login'].'
------------------------
  
Please click this link to activate your account:
http://localhost:8888/Camagru/login/verify.php?email='.$_GET['email'].'&hash='.$hash.'
  
'; // Our message above including the link
                      
$headers = 'From:noreply@camagru.com' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email
if (isset($_GET['submit']) && $_GET['submit'] == 'again')
    header('location: ../index.php');
?>