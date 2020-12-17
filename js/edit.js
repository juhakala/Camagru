var toggle = true;

document.getElementById('loadpic').addEventListener('click', function() {pickLoad(true)});
document.getElementById('camera').addEventListener('click', function() {pickLoad(false)});

function pickLoad(evt) {
    if (evt == false) {
        document.getElementById('loadpic').style.background = '#f2dede';
        document.getElementById('camera').style.background = 'blue';
        //document.getElementById('loadedpicture').style.display = 'none';
        //document.getElementById('camerapicture').style.display = 'block';
    } else {
        document.getElementById('loadpic').style.background =  'blue';
        document.getElementById('camera').style.background = '#f2dede';
        //document.getElementById('loadedpicture').style.display = 'block';
        //document.getElementById('camerapicture').style.display = 'none';
    }
}

//document.getElementById('filetoedit').addEventListener('change', pickPicture);

function pickPicture() {
    //console.log('changed');
    //console.log(document.getElementById('filetoedit').value);
    if (document.getElementById('filetoedit').value != null) {
        document.getElementById('filetoedit').style.margin = 0;
        showImage(src,target);
    } else
        console.log('not changed');
    document.getElementById('filetoedit').value = null;
}

function showImage(src,target) {
    //console.log('here');
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
//var src = document.getElementById("filetoedit");
//var target = document.getElementById("imagetoedit");

/*
function detectMob() {
    const toMatch = [
        /Android/i,
        /webOS/i,
        /iPhone/i,
        /iPad/i,
        /iPod/i,
        /BlackBerry/i,
        /Windows Phone/i
    ];

    return toMatch.some((toMatchItem) => {
        return navigator.userAgent.match(toMatchItem);
    });
}
console.log('is it' + detectMob());
*/

function child_to_parent(parent, child_type, class_names, attributes, content) {
    var child = document.createElement(child_type);
    if (class_names != null) {
        for (z = 0; class_names[z]; z++)
            child.classList.add(class_names[z]);
    }
    if (attributes != null) {
        for (z = 0; attributes[z]; z += 2)
            child.setAttribute(attributes[z], attributes[z + 1]);
    }
    if (content != null)
        child.innerHTML = content;
    if (parent != null)
        parent.appendChild(child);
    return (child);
}

function add_thumbnail(resp) {
    var parent = document.getElementsByClassName('thumbnail')[0];
    i = 0;
    for (i = 0; resp[i]; i++) {
        var cont = child_to_parent(parent, 'div', ['minicontainer'], null, null);
        child_to_parent(cont, 'img', ['minipicture'], ['src', 'img/' + resp[i]['name']], null);
    }
}

function fetch_thumbnails() {
    var xhr = new XMLHttpRequest();
    xhr.open("post", 'server/fetchGallery.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(event){ 
        if (!event.target.response.startsWith('error')) {
            resp = JSON.parse(event.target.response);
            add_thumbnail(resp);
            //console.log(resp);
            //messageBox(resp, 'green');
        } else
            messageBox(event.target.response, 'red');

    }
    xhr.send("pic_owner=yes");
}
fetch_thumbnails();


var scroll = 0;
var moving = false;

document.getElementsByClassName('main')[0].addEventListener('scroll', (event) => {
    scroll = event.target.scrollTop + event.target.offsetHeight - event.target.clientHeight
});

var diment = document.getElementById('my-image').getBoundingClientRect();
function move(e){
    //console.log(image.clientWidth);
    var newX = e.clientX - diment['x'] - image.clientWidth / 2;
    var newY = e.clientY - diment['y'] - image.clientHeight / 2 + scroll;
    image.style.left = newX + "px";
    image.style.top = newY + "px";
}

function initialClick(e) {
    if(moving){
        document.removeEventListener("mousemove", move);
        moving = !moving;
        return;
    }
    moving = !moving;
    image = this;
    document.addEventListener("mousemove", move, false);
}

function add_sticker_to_image(src) {
    //console.log(src);
    var parent = document.getElementById('my-image');
    var child = child_to_parent(parent, 'div', null, ['id', 'stic'], null);
    child_to_parent(child, 'img', null, ['src', src, 'style', 'max-width: 10vw; max-height: 10vh;'], null);
    child.addEventListener("mousedown", initialClick, false);
}

function add_sticker(resp) {
    var parent = document.getElementsByClassName('stickers')[0];
    i = 0;
    for (i = 0; resp[i]; i++) {
        var cont = child_to_parent(parent, 'div', ['minicontainer'], null, null);
        var child = child_to_parent(cont, 'img', ['minipicture', 'stickerpicture'], ['src', 'stickers/' + resp[i]['src']], null);
        child.addEventListener('click', (event) => {
            add_sticker_to_image(event.target.src);
        });
    }
}

function fetch_stickers() {
    var xhr = new XMLHttpRequest();
    xhr.open("post", 'server/fetchGallery.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(event){ 
        if (!event.target.response.startsWith('error')) {
            resp = JSON.parse(event.target.response);
            add_sticker(resp);
        } else
            messageBox(event.target.response, 'red');

    }
    xhr.send("stickers=yes");
}
fetch_stickers();


/* mousemovement for sticker positioning */

//function mvImg(e) {
//    var valueX = (e.pageX * -1 / 12);
//    var valueY = (e.pageY * -1 / 12);
//    this.style.backgroundPositionX = valueX + "px"
//    this.style.backgroundPositionY = valueY + "px"
//    //console.log(this.style.backgroundPositionX +', ' + this.style.backgroundPositionY);
//}
//var im = document.getElementById("my-image");
//if (im) {
//    im.addEventListener("mousemove",mvImg,false);
//}