<div class="navbar">
    <div class='choose' onclick='galleryPage()'>Gallery</div>
    <div class='choose' onclick=''>Placeholder</div>
    <div class="dropdown">
        <button class="dropbtn" onclick="myFunction()">Dropdown
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
        <div class='login' onclick='userSettingsPage()'><?php echo $_SESSION['login']; ?> &#9881;</div>
    <?php } else { ?>
        <div class='login' onclick='userLoginPage()'>Login</div>
        <div class='login' onclick='newUserPage()'>Create New User</div>
        <div class='login' onclick='forgotPassPage()'>Forgot Passwd</div>
    <?php } ?>
</div>

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {
  var myDropdown = document.getElementById("myDropdown");
    if (myDropdown.classList.contains('show')) {
      myDropdown.classList.remove('show');
    }
  }
}
</script>
