<?php 
if (isset($_SESSION['login']) && $_SESSION['login'] != "") { ?>
    <p> <?php echo $_SESSION['login']; ?></p>
    <form action='login/logout.php'>
        <input type="submit" value="logout">
    </form>
    <input onclick='userSettingsPage()' type="submit" value="userSettings">
    <?php
} else { ?>
    <form action='login/login.php'>
        <input type='text' placeholder='Login' name='login' required>
        <input type='password' placeholder='Password' name='passwd' required>
        <input type="submit" value="ok">
    </form>
    <input onclick='newUserPage()' type="submit" value="CreateNewUser">
    <br>
    <input onclick='forgotPassPage()' type="submit" value="ForgotPasswd">
<?php
} ?>
