<?php
if (!isset($_SESSION['login']) || $_SESSION['login'] == "") {
    header('location: index.php');
    die();
}
?>
<form action='login/verifyEmail.php'>
    <input type='email' placeholder='Email' name='email' required>
    <br>
    <input type="submit" name="submit" value="again">
</form>