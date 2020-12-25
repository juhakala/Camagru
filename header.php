<div class="navbar">
    <div class='login' onclick='masters("api/gallery.php", "js/gallery.js")'>Gallery</div>
    <div class="filler"></div>
    <?php if (isset($_SESSION['login']) && $_SESSION['login'] != "") { ?>
        <div class='login' onclick='masters("api/edit.php", "js/edit.js")'>Edit</div>
        <div class='login' onclick='masters("api/UM/userSettings.php", "js/userSettings.js")'><?php echo $_SESSION['login']; ?> &#9881;</div>
        <div class='login' onclick='userLogoutPage()'>Logout</div>
    <?php } else { ?>
        <div class='login' onclick='masters("api/UM/forgotPass.php", "js/forms.js")'>Forgot Passwd</div>
        <div class='login' onclick='masters("api/UM/newUser.php", "js/forms.js")'>Create New User</div>
        <div class='login' onclick='masters("api/UM/login.php", "js/forms.js")'>Login</div>
    <?php } ?>
</div>