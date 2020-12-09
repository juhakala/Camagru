var toggle = true;

document.getElementById('loadpic').addEventListener('click', function() {pickLoad(true)});
document.getElementById('camera').addEventListener('click', function() {pickLoad(false)});

function pickLoad(evt) {
    if (evt == false) {
        document.getElementById('loadpic').style.background = '#f2dede';
        document.getElementById('camera').style.background = 'blue';
        document.getElementById('loadedpicture').style.display = 'none';
        document.getElementById('camerapicture').style.display = 'block';
    } else {
        document.getElementById('loadpic').style.background =  'blue';
        document.getElementById('camera').style.background = '#f2dede';
        document.getElementById('loadedpicture').style.display = 'block';
        document.getElementById('camerapicture').style.display = 'none';
    }
}

document.getElementById('filetoedit').addEventListener('change', pickPicture);

function pickPicture() {
    console.log('changed');
    console.log(document.getElementById('filetoedit').value);
    if (document.getElementById('filetoedit').value != null) {
        document.getElementById('filetoedit').style.margin = 0;
        showImage(src,target);
    } else
        console.log('not changed');
    document.getElementById('filetoedit').value = null;
}

function showImage(src,target) {
    console.log('here');
    var fr=new FileReader();
    fr.onload = function(e) {
        target.src = this.result;
        //console.log(target.src);
        //drawDataURIOnCanvas(target.src, target);
    };
    fr.readAsDataURL(src.files[0]);
    target.style.display = 'block';
  }
/*
function drawDataURIOnCanvas(strDataURI, canvas) {
    "use strict";
    var img = new window.Image();
    img.addEventListener("load", function () {
        canvas.getContext("2d").ctx.drawImage(img, 0, 0, 500, 457, 0, 0, canvas.width, canvas.height); // destination rectangle
    });
    img.setAttribute("src", strDataURI);
    console.log(img.width);
}
*/
  var src = document.getElementById("filetoedit");
  var target = document.getElementById("imagetoedit");
