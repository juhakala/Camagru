<form action='../../server/UM/confirmReset.php' method='post'>
    <input type='hidden' value='<?php echo $_POST['email']; ?>' name='email' readonly>
    <input type='hidden' value='<?php echo $_POST['hash']; ?>' name='hash' readonly>
    <input type='password' placeholder='Passwd' name='passwd' required>
    <br>
    <input type='password' placeholder='PasswdAgain' name='passwdAgain' required>
    <br>
    <input type="submit" value="ok">
</form>
