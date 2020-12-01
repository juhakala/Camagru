<?php 
if (isset($_SESSION['login']) && $_SESSION['login'] != "") {
    echo "<p>{$_SESSION['login']}</p>";
} else { ?>
    <form action='login.php'>
        <input type='text' placeholder='Login' name='login' required>
        <input type='password' placeholder='Password' name='passwd' required>
        <input type="submit" value="ok">
    </form>
<?php
}

