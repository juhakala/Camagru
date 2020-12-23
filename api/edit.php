<div class='main outer-layer'>
    <div class='content-wrapper'>
        <div id='my-image' class='image'>

        </div>
        <div class='stickers'>

        </div>
        <div class='thumbnail'>
        
        </div>
        <div class='controls'>
            <input type='button' id='startstream' value='start'>
        </div>
    </div>
</div>
<div id='loadedpicture'>
    <input id='filetoedit' name='fileToUpload' type='file'>
    <img id='imagetoedit' src=''>
</div>
<form action='server/createPicture.php' class='thisform' method='post' enctype='multipart/form-data' style='position: absolute;'>
    <input type='submit' value='Upload Image' id='loadable_sub' name='submit'>
</form>