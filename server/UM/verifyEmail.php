<?php
if (isset($_POST['verifyAgain']) && $_POST['verifyAgain'] == 'again') {
    session_start();
    require_once('../../config/connect.php');
    try {
        $stmt = $db->prepare('SELECT * from `users` WHERE email = :email');
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && $row['login'] != $_SESSION['login']) {
            echo "error : email in use";
            die();
        }
        $stmt = $db->prepare('UPDATE `users` SET email = :email, hash = :hash WHERE login = :log');
        $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->bindParam(':email', $_POST['email']);
        $hash = md5(rand(0,1000));
        $stmt->bindParam(':hash', $hash);
        $stmt->execute();
    } catch( PDOException $Exception ) {
        echo 'Error: '.$Exception->getMessage();
        die();
    }
}

$to = $_POST['email']; // Send email to our user
$subject = 'Signup | Verification'; // Give the email a subject 
$message = '
  
Thanks for signing up!
Your account has been created, you can login after you have activated your account by pressing the url below.
  
------------------------
Username: '.$_SESSION['login'].'
------------------------
  
Please click this link to activate your account:
http://localhost:8080/Camagru/server/UM/verify.php?email='.$_POST['email'].'&hash='.$hash.'
  
'; // Our message above including the link
                      
$headers = 'From:noreply@localhost.com' . "\r\n"; // Set from headers
if (mail($to, $subject, $message, $headers) === true) { // Send our email
    if (isset($_POST['verifyAgain']) && $_POST['verifyAgain'] == 'again')
        echo "success : new verify email send to: " . $_POST['email'];
} else {
    echo "error :verifycation email not send";
}
?>