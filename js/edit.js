var stream = false;
function pickPicture() {
    if (!document.getElementById('my-image')) {
        document.getElementById('filetoedit').value = null;
        return ;
    }
    if (document.getElementById('filetoedit').value != null) {
        if (document.getElementById('loadable_file'))
            document.getElementById('loadable_file').remove();
        var src = document.getElementById("filetoedit");
        var clone = src.cloneNode(true);
        clone.id = 'loadable_file';
        clone.hidden = true;
        document.getElementsByClassName('thisform')[0].appendChild(clone);
        showImage(src);
    }
    document.getElementById('filetoedit').value = null;
}

function showImage(src) {
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

function hover_thumb(e) {
    var timer = setTimeout( function() {
        var child = child_to_parent(e.target, 'div', null, ['id', 'delete_thumbnail'], 'x');
        child.addEventListener('click', (event) => {
            var xhr = new XMLHttpRequest();
            xhr.open("post", 'server/deletefromgallery.php', true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function(event){ 
                if(xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 0 || (xhr.status >= 200 && xhr.status < 400)) {
                        if (event.target.response.startsWith('success')) {
                            sessionStorage.setItem('message', event.target.response);
                            sessionStorage.setItem('color', 'green');
                            window.location.href = window.location.href
                        } else
                            messageBox(event.target.response, 'red');
                    }
                }
            }
            xhr.send("delete="+e.target.getAttribute('alt')+"&name="+e.target.getAttribute('title'));

        });
    }, 1000);
    e.target.addEventListener('mouseleave', function() {
        if (timer) {
            clearTimeout(timer);
        }
        if (document.getElementById('delete_thumbnail')) {
            document.getElementById('delete_thumbnail').remove();
        }
    });
}

function add_thumbnail(resp) {
    var parent = document.getElementsByClassName('thumbnail')[0];
    i = 0;
    for (i = 0; resp[i]; i++) {
        var cont = child_to_parent(parent, 'div', ['minicontainer'], null, null);
        var middle = child_to_parent(cont, 'div', ['middle_thumbnail'], ['alt', resp[i]['id'], 'title', resp[i]['name']], null);
        var child = child_to_parent(middle, 'img', ['minipicture'], ['src', 'img/' + resp[i]['name']], null);
        middle.addEventListener('mouseenter', hover_thumb);
    }
}

function fetch_thumbnails() {
    var xhr = new XMLHttpRequest();
    xhr.open("post", 'server/fetchGallery.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange  = function(event){
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 0 || (xhr.status >= 200 && xhr.status < 400)) {
                if (!event.target.response.startsWith('error')) {
                    resp = JSON.parse(event.target.response);
                    add_thumbnail(resp);
                } else
                    messageBox(event.target.response, 'red');
            }
        }
    }
    xhr.send("pic_owner=yes");
}
fetch_thumbnails();


var scroll = 0;

var moved = false;
function move(e){
    var diment = document.getElementsByClassName('editthiscont')[0].getBoundingClientRect();
    var newX = e.clientX - diment['x'] - image.childNodes[0].width / 2;
    var newY = e.clientY - diment['y'] - image.childNodes[0].height / 2 + scroll;
    if (newX <= diment['width'] && newY <= diment['height']) {
        image.style.left = newX + "px";
        image.style.top = newY + "px";
    }
    moved = true;
}

function remove(e) {
    this.remove();
}

function remove_highlight(e) {
    var me = document.getElementById('stick_target');
    if (me) {
        me.style.border = 'none';
        me.removeAttribute('id');
        var uus = parseInt(me.parentElement.style.left) + 2;
        var yla = parseInt(me.parentElement.style.top) + 2;
        me.parentElement.style.left = uus + 'px';
        me.parentElement.style.top = yla + 'px';
        window.removeEventListener('keypress', add_sticker_size);
    }
}

document.addEventListener('mousedown', function(e) {
    remove_highlight(e);
});

function add_sticker_size(e) {
    e.preventDefault();
    var elem = e.currentTarget.myTarget;
    if (e.key == 'n') {
        var size = parseInt(elem.width) - 5;
        if (size > 0)
            elem.style.width = size + 'px';
    } else if (e.key == 'm') {
        var size = parseInt(elem.width) + 5;
        if (size < 650)
            elem.style.width = size + 'px';
    }
}

function sticker_size(e) {
    if (!moved) {
        e.target.style.border = '2px dashed black';
        var uus = parseInt(e.target.parentElement.style.left) - 2;
        var yla = parseInt(e.target.parentElement.style.top) - 2;
        e.target.parentElement.style.left = uus + 'px';
        e.target.parentElement.style.top = yla + 'px';
        setTimeout(function() {
            e.target.setAttribute('id', 'stick_target');
        }, 100);
        window.addEventListener('keypress', add_sticker_size);
        window.myTarget = e.target;
    }
    moved = false;
}

function add_sticker_to_image(src) {
    var parent = document.getElementsByClassName('editthiscont')[0];
    if (parent) {
        var child = child_to_parent(parent, 'div', null, ['id', 'stic', 'alt', src], null);
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
    }
}

function add_sticker(resp) {
    var parent = document.getElementsByClassName('stickers')[0];
    i = 0;
    for (i = 0; resp[i]; i++) {
        var cont = child_to_parent(parent, 'div', ['minicontainer'], null, null);
        var middle = child_to_parent(cont, 'div', ['middle_thumbnail'], null, null);
        var child = child_to_parent(middle, 'img', ['minipicture', 'stickerpicture'], ['src', 'stickers/' + resp[i]['src']], null);
        child.addEventListener('click', (event) => {
            add_sticker_to_image(event.target.src);
        });
    }
}

function fetch_stickers() {
    var xhr = new XMLHttpRequest();
    xhr.open("post", 'server/fetchGallery.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function(event){ 
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 0 || (xhr.status >= 200 && xhr.status < 400)) {
                if (!event.target.response.startsWith('error')) {
                    resp = JSON.parse(event.target.response);
                    add_sticker(resp);
                } else
                    messageBox(event.target.response, 'red');
            }
        }
    }
    xhr.send("stickers=yes");
}
fetch_stickers();
if (document.getElementById('filetoedit'))
    document.getElementById('filetoedit').addEventListener('change', pickPicture);

function get_stickers_data(formData) {
    var div_diment = document.getElementById('tosome').getBoundingClientRect();
    formData.append('width', div_diment['width']);
    formData.append('height', div_diment['height']);
    var stickers = document.querySelectorAll('#stic');
    var dataArr = new Array();
    s = 0;
    stickers.forEach(function(elem) {
        dataArr[s] = {};
        var diment = elem.childNodes[0].getBoundingClientRect();
        dataArr[s]['name'] = '../stickers/' + elem.getAttribute('alt').substring(elem.getAttribute('alt').lastIndexOf("/") + 1);
        dataArr[s]['width'] = diment['width'];
        dataArr[s]['height'] = diment['height'];
        dataArr[s]['x'] = diment['left'] - div_diment['left'];
        dataArr[s]['y'] = diment['top'] - div_diment['top'];
        s++;
    });
    formData.append('stickers', JSON.stringify(dataArr));
}
if (document.getElementById('loadable_sub')) {
    document.getElementById('loadable_sub').addEventListener('click', (event) => {
        event.preventDefault();
        if (document.getElementsByClassName('editthiscont')[0]) {
            var xhr = new XMLHttpRequest();
            xhr.open("post", 'server/createPicture.php', true);
            xhr.onreadystatechange = function(event) {
                if(xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 0 || (xhr.status >= 200 && xhr.status < 400)) {
                        if (event.target.response.startsWith('success')) {
                            sessionStorage.setItem('message', event.target.response);
                            sessionStorage.setItem('color', 'green');
                            window.location.href = window.location.href
                        } else {
                            messageBox(event.target.response, 'red');
                        }
                    }
                }
            }
            if (document.getElementsByClassName('forsaving')[0]) {
                var formData = new FormData();
                formData.append('canvas', document.getElementById('tosome').toDataURL('image/png'))
            }
            else
                var formData = new FormData(document.getElementsByClassName("thisform")[0]);
            get_stickers_data(formData);
            xhr.send(formData);
        }
    });
}

document.getElementById('startstream').addEventListener('click', function(e) {
    if (e.detail == 0)
        return ;
    if (this.value == 'start') {
        this.value = 'wait';
        if (navigator.mediaDevices.getUserMedia) {
            stream = true;
            if (document.getElementById('my-image'))
                document.getElementById('my-image').remove();
            var parent = document.createElement('div');
            parent.classList.add('image');
            parent.classList.add('videoimage');
            document.getElementsByClassName('content-wrapper')[0].prepend(parent);
            var video = document.createElement('video');
            parent.append(video);
            video.id = 'my-video';
            if (video) {
                navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(mediaStream) {
                    video.srcObject = mediaStream;
                    video.play();
                    setTimeout(() => {
                        var missi = child_to_parent(document.getElementsByClassName('controls')[0], 'div', ['minicontainer', 'controls-here'], null, null);
                        var take = child_to_parent(missi, 'input', ['ctrl-button', 'middle_thumbnail'], ['type', 'button', 'value', '3', 'id', 'take_photo'], null);
                        document.getElementById('startstream').value = 'stop';
                        window.addEventListener('keypress', take_picture_from_stream);
                        take.addEventListener('click', take_picture_from_stream);
                        take.key = 'bb';
                    }, 2000);
                })
                .catch(function(err) {
                    console.log('getUsermMdia related error => ("startstream")');
                });
            }
        }
    } else if (this.value == 'stop') {
        stop_stream();
    }
});

function stop_stream() {
    window.removeEventListener('keypress', take_picture_from_stream);
    stream = false;
    this.value = 'wait';
    var parent = document.createElement('div');
    parent.classList.add('image');
    parent.id = 'my-image';
    document.getElementsByClassName('content-wrapper')[0].prepend(parent);
    var video = document.getElementById('my-video');
    if (video) {
        var tracks = video.srcObject.getTracks();
        for (i = 0; i < tracks.length; i++) {
            let track = tracks[i];
            track.stop();
        }
        video.srcObject = null;
        document.getElementsByClassName('videoimage')[0].remove();
        if (document.getElementById('take_photo'))
            document.getElementById('take_photo').parentNode.remove();
        setTimeout(() => {
            document.getElementById('startstream').value = 'start';
        }, 1000);
    }
}

function take_picture_from_stream(e) {
    if (e.key && e.key === ' ') {
        document.getElementById('take_photo').parentNode.remove();
        var video = document.getElementById('my-video');
        var canvas = document.createElement("canvas");
        canvas.classList.add('forsaving');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.id = 'tosome';
        canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
        stop_stream();
        var cont = child_to_parent(document.getElementById('my-image'), 'div', ['editthiscont'], null, null);
        cont.appendChild(canvas);
    } else if (e.currentTarget && e.currentTarget.key ==='bb') {
        var elem = document.getElementById('take_photo');
        var time = setInterval(function() {
            elem.value = parseInt(elem.value) - 1;
        }, 1000);
        setTimeout(function () {
            clearInterval(time);
            if (!document.getElementById('take_photo'))
                return ;
            document.getElementById('take_photo').parentNode.remove();
            var video = document.getElementById('my-video');
            var canvas = document.createElement("canvas");
            canvas.classList.add('forsaving');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.id = 'tosome';
            canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
            stop_stream();
            var cont = child_to_parent(document.getElementById('my-image'), 'div', ['editthiscont'], null, null);
            cont.appendChild(canvas);
        }, 4000);
    } else
        return ;
    if (document.getElementById('take_photo'))
        document.getElementById('take_photo').removeEventListener('click', take_picture_from_stream);
}