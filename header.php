<div class="navbar">
    <div class='choose' onclick='masters("gallery.php", "js/gallery.js")'>Gallery</div>
    <div class='choose' onclick=''>Placeholder</div>
    <div class="dropdown">
        <button class="dropbtn" onclick="dropdown()">Dropdown
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content" id="myDropdown">
            <div class='choose' onclick=''>Placeholder</div>
            <div class='choose' onclick=''>Placeholder</div>
            <div class='choose' onclick=''>Placeholder</div>
        </div>
    </div> 
    <?php if (isset($_SESSION['login']) && $_SESSION['login'] != "") { ?>
        <div class='login' onclick='userLogoutPage()'>Logout</div>
        <div class='login' onclick='masters("api/userSettings.php", null)'><?php echo $_SESSION['login']; ?> &#9881;</div>
        <div class='login' onclick='masters("api/edit.php", null)'>Edit</div>
    <?php } else { ?>
        <div class='login' onclick='masters("api/login.php", "js/forms.js")'>Login</div>
        <div class='login' onclick='masters("api/newUser.php", null)'>Create New User</div>
        <div class='login' onclick='masters("api/forgotPass.php", null)'>Forgot Passwd</div>
    <?php } ?>
</div>
