<div class='main outer-layer'>
    <div class='content-wrapper'>
        <div id='my-image' class='image'>

        </div>
        <div class='stickers'>

        </div>
        <div class='thumbnail'>
        
        </div>
        <div class='controls'>
            <div id='loadedpicture' class='minicontainer controls-here'>
                <input id='filetoedit' name='fileToUpload' type='file' accept="image/*">
                <img id='imagetoedit' src=''>
            </div>
            <div class='minicontainer controls-here'>
                <form action='server/createPicture.php' class='thisform' method='post' enctype='multipart/form-data'>
                    <input class='ctrl-button middle_thumbnail' type='submit' value='Upload Image' id='loadable_sub' name='submit'>
                </form>
            </div>
            <div class='minicontainer controls-here'>
                <input type='button' id='startstream' class='ctrl-button middle_thumbnail' value='start'>
            </div>
        </div>
    </div>
</div>

