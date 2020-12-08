<?php
require_once('../config/connect.php');
session_start();
try {
	$stmt = $db->prepare('SELECT * FROM `users` WHERE email = :email AND hash = :hash');
    $stmt->bindParam(':email', $_GET['email']);
	$stmt->bindParam(':hash', $_GET['hash']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
?>
        <form id='its' action="../api/resetPass.php" method="post">
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" readonly>
            <input type="hidden" name="hash" value="<?php echo $_GET['hash']; ?>" readonly>
        </form>
        <?php //echo "something"; //die(); ?>
        <script type="text/javascript">
            //sessionStorage.setItem('page', 'api/resetPass.php');
            //sessionStorage.setItem('form', 'js/forms.js');
            console.log('reset.php');
            document.getElementById('its').submit();
        </script>
<?php

    }
    else 
        echo "no hash or email wrong\n";
} catch (PDOException $msg) {
	echo 'Error: '.$msg->getMessage();
	die();
}
