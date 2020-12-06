<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == "" || $_SESSION['active'] == 0)
    die();
?>
<div class='main'>
    <!-- main part -->
</div>
<div class='side'>
    <div class='upload'>
        <form action="uploadFile.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" required>
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </div>
    <div class='stickers'>
        <!-- side part -->
    </div>
</div>
