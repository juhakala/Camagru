<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == "" || $_SESSION['active'] == 0) {
    header('location: verifyAgain.php');
    die();
}
?>
<p>change Password</p>
<form action='login/userSettings.php'>
    <input type='password' placeholder='oldPasswd' name='passwd' required>
    <br>
    <input type='password' placeholder='newPasswd' name='newPasswd' required>
    <br>
    <input type='password' placeholder='newPasswdAgain' name='newPasswdAgain' required>
    <br>
    <input type="submit" name="submit" value="changePasswd">
</form>
<br>
<br>
<br>
<p>change Email</p>
<form action='login/userSettings.php'>
    <input type='email' placeholder='newEmail' name='newEmail' required>
    <br>
    <input type='email' placeholder='newEmailAgain' name='newEmailAgain' required>
    <br>
    <input type='password' placeholder='passwd' name='passwd' required>
    <br>
    <input type="submit" name="submit" value="changeEmail">
</form>
<br>
<br>
<br>
<p>change Login</p>
<form action='login/userSettings.php'>
    <input type='text' placeholder='newLogin' name='newLogin' required>
    <br>
    <input type='text' placeholder='newLoginAgain' name='newLoginAgain' required>
    <br>
    <input type='password' placeholder='passwd' name='passwd' required>
    <br>
    <input type="submit" name="submit" value="changeLogin">
</form>
<br>
<br>
<br>
<p>delete Login</p>
<form action='login/userSettings.php'>
    <input type='text' placeholder='login' name='login' required>
    <br>
    <input type='password' placeholder='passwd' name='passwd' required>
    <br>
    <input type="submit" name="submit" value="deleteLogin">
</form>