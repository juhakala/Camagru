<?php
session_start();
?>
<form action='login/changePass.php'>
    <input type='password' placeholder='oldPasswd' name='oldPasswd' required>
    <br>
    <input type='password' placeholder='newPasswd' name='newPasswd' required>
    <br>
    <input type='password' placeholder='newPasswdAgain' name='newPasswdAgain' required>
    <br>
    <input type="submit" name="submit" value="OK">
</form>
<br>
<br>
<br>
<form action='login/changeEmail.php'>
    <input type='email' placeholder='newEmail' name='newEmail' required>
    <br>
    <input type='email' placeholder='newEmailAgain' name='newEmailAgain' required>
    <br>
    <input type="submit" name="submit" value="OK">
</form>
<br>
<br>
<br>
<form action='login/changeLogin.php'>
    <input type='text' placeholder='newLogin' name='newLogin' required>
    <br>
    <input type='text' placeholder='newLoginAgain' name='newLoginAgain' required>
    <br>
    <input type="submit" name="submit" value="OK">
</form>