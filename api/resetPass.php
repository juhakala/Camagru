<form action='login/reset.php'>
    <input type='email' value='<?php echo $_GET['email']; ?>' name='email' readonly>
    <br>
    <input type='password' value='<?php echo $_GET['hash']; ?>' name='hash' readonly>
    <br>
    <input type='password' placeholder='Passwd' name='passwd' required>
    <br>
    <input type='password' placeholder='PasswdAgain' name='passwdAgain' required>
    <br>
    <input type="submit" name="submit" value="OK">
</form>