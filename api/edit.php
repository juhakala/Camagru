<div class='main'>
    <div id='loadedpicture'>
        <input id='filetoedit' type="file">
        <br>
        <img id='imagetoedit' src=''>
        <!--<canvas id="imagetoedit" width="100px" height="100px"></canvas>-->
    </div>
    <div id='camerapicture'>
    </div>
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

<div class='pick'>
    <div class='switchposs'>
        <span id='loadpic' class='picturebutton'>load picture</span><span id='camera' class='picturebutton'>take picture</span>
    </div>
</div>