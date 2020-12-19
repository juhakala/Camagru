function pickPicture() {
    if (document.getElementById('filetoedit').value != null) {
        if (document.getElementById('loadable_file'))
            document.getElementById('loadable_file').remove();
        var src = document.getElementById("filetoedit");
        var clone = src.cloneNode(true);
        clone.id = 'loadable_file';
        clone.hidden = true;
        document.getElementsByClassName('thisform')[0].appendChild(clone);
        showImage(src);//,target);
    } else
        console.log('not changed');
    document.getElementById('filetoedit').value = null;
}

function showImage(src) {//},target) {
    var fr=new FileReader();
    fr.onload = function(e) {
        var parent = document.getElementById('my-image');
        if (document.getElementsByClassName('editthiscont')[0])
            document.getElementsByClassName('editthiscont')[0].remove();
        var cont = child_to_parent(parent, 'div', ['editthiscont'], null, null);
        var pic = new Image();
        pic.src = this.result;
        pic.setAttribute('id', 'tosome');
        pic.onload = function() {
            parent.setAttribute('style', 'weight: '+pic.width+'; height: '+pic.height+';');

        }
        cont.appendChild(pic);
    };
    fr.readAsDataURL(src.files[0]);
}

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
        } else
            messageBox(event.target.response, 'red');

    }
    xhr.send("pic_owner=yes");
}
fetch_thumbnails();


var scroll = 0;

var moved = false;
function move(e){
    var diment = document.getElementsByClassName('editthiscont')[0].getBoundingClientRect();
    var newX = e.clientX - diment['x'] - image.clientWidth / 2;
    var newY = e.clientY - diment['y'] - image.clientHeight / 2 + scroll;
//    console.log(' ' + newX + '      ' +newY);
    if (newX <= diment['width'] && newY <= diment['height']) {
        image.style.left = newX + "px";
        image.style.top = newY + "px";
    }
    moved = true;
}

document.getElementsByClassName('main')[0].addEventListener('scroll', (event) => {
    //scroll = event.target.scrollTop + event.target.offsetHeight - event.target.clientHeight
});

function remove(e) {
    this.remove();
}

function remove_highlight(e) {
    var me = document.getElementById('stick_target');
    if (me) {
        me.style.border = 'none';
        console.log('toka');
        me.removeAttribute('id');
        var uus = parseInt(me.parentElement.style.left) + 2;
        var yla = parseInt(me.parentElement.style.top) + 2;
        me.parentElement.style.left = uus + 'px';
        me.parentElement.style.top = yla + 'px';
    }
}

document.addEventListener('mousedown', function(e) {
    remove_highlight(e);
});

function sticker_size(e) {
    if (!moved) {
        console.log('just click');
        e.target.style.border = '2px dashed black';
        var uus = parseInt(e.target.parentElement.style.left) - 2;
        var yla = parseInt(e.target.parentElement.style.top) - 2;
        e.target.parentElement.style.left = uus + 'px';
        e.target.parentElement.style.top = yla + 'px';
        setTimeout(function() {
            e.target.setAttribute('id', 'stick_target');
        }, 100);
    }
    moved = false;
}

function add_sticker_to_image(src) {
    var parent = document.getElementsByClassName('editthiscont')[0];
    if (parent) {
        var child = child_to_parent(parent, 'div', null, ['id', 'stic'], null);
        var stic = child_to_parent(child, 'img', null, ['src', src, 'style', 'width: 100px;'], null);
        child.addEventListener("mousedown", function(e){
            e.preventDefault();
            image = this;
            this.addEventListener("mousemove", move);
            this.addEventListener("mouseup", function(e){
                this.removeEventListener("mousemove", move);
            });
        });
        child.addEventListener('click', sticker_size, false);
        child.addEventListener("dblclick", remove, false);
        var diment = document.getElementsByClassName('editthiscont')[0].getBoundingClientRect();
        newx = diment['width'] / 2 - stic.width / 2;
        newy = diment['height'] / 2 - stic.height / 2;
        child.setAttribute('style', 'left:'+newx+'px;top:'+newy+'px;');
    } else
        console.log('need base image first');
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

document.getElementById('filetoedit').addEventListener('change', pickPicture);

function get_stickers_data(formData) {
    var diment = document.getElementsByClassName('editthiscont')[0].getBoundingClientRect();
    console.log(diment);
    formData.append('width', diment['width']);
    formData.append('height', diment['height']);
    var stickers = document.querySelectorAll('#stic');
    stickers.forEach(function(elem) {
//        formData.append('name', value);
        console.log(elem);
        console.log(elem.getBoundingClientRect());
    });
}

document.getElementById('loadable_sub').addEventListener('click', (event) => {
    event.preventDefault();
    if (document.getElementById('loadable_file') && document.getElementById('loadable_file').files != null) {
        console.log('is something');
        var xhr = new XMLHttpRequest();
        xhr.open("post", 'server/createPicture.php', true);
        xhr.onload = function(event){
            messageBox(event.target.response, 'green');
        }
        var formData = new FormData(document.getElementsByClassName("thisform")[0]);
        get_stickers_data(formData);
        xhr.send(formData);
    } else {
        //console.log('is nothing');
    }
});
