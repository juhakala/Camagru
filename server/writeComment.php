<?php
require_once('../config/connect.php');
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == '') {
    echo "need to login to comment";
    die();
} else if (isset($_SESSION['active']) && $_SESSION['active'] === '0') {
    echo "need to verify user to comment";
    die();
}
if (isset($_POST['id']) && $_POST['id'] != '' && isset($_POST['comment']) && trim($_POST['comment']) != '') {
    try {
        $comment = strip_tags($_POST['comment']);
        if (trim($comment) == '') {
            echo "error : after strip_tag comment is empty";
            die();
        }
        $stmt = $db->prepare('INSERT INTO comments (gallery_id, author, text) VALUES (:id, :log, :comment)');
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':log', $_SESSION['login']);
        $stmt->bindParam(':comment', trim($comment));
        $stmt->execute();

        $stmt = $db->prepare('SELECT email, mailing FROM users INNER JOIN gallery ON users.login = gallery.login');
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && $row['mailing'] == 1) {
            $to = $row['email']; // Send email to our user
            $subject = 'Comment on picture'; // Give the email a subject 
            $message = '
              
            user: '.$_SESSION['login'].' commented on your picture(id: '.$_POST['id'].').
            ---------------------
            \''.trim($comment).'\'
            ---------------------
              
            '; // Our message above including the link
                                  
            $headers = 'From:noreply@localhost.com' . "\r\n"; // Set from headers
            mail($to, $subject, $message, $headers);
        }
    } catch (PDOException $msg) {
    	echo 'Error: '.$msg->getMessage();
    	die();
    }
    echo "success comment : " . $comment;
} else {
    echo "error : where is the comment?";
}