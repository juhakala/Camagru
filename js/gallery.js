var count = 0;
var picture_id = 0;
var wrapper = document.getElementById("wrapper");
var content = document.getElementById("content");
var test = document.getElementById("test");

function add_hover_effect(elem) {
    elem.addEventListener("mouseenter", function( event ) {
        event.target.style.opacity = '0.8';
    });
    elem.addEventListener("mouseleave", function( event ) {  
        event.target.style.opacity = '1';
    });
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

function makeCallForPics() {
    var xhr = new XMLHttpRequest();
    xhr.open("post", 'server/fetchGallery.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function (event) {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 0 || (xhr.status >= 200 && xhr.status < 400)) {
                if (event.target.response.startsWith('error')) {
                    //if picture is is not resetting then this is good
                    //messageBox(event.target.response, 'red');
                
                    // atm shits on event listeners -> maybe add counter to elem ids so private listeners? 
                    // works now, messages are shit thou
                    if (sessionStorage.getItem('css_change_gallery') != null)
                        picture_id = 0; //for infinity scroll
                } else {
                    resp = JSON.parse(event.target.response);
                    i = -1;
                    while (resp[++i]) {
                        var parent = child_to_parent(content, 'div', ['galdiv'], null, null);
                        child_to_parent(parent, 'img', ['galpicture'], ['id', "picinstance"+resp[i]['id'] + count, 'title', resp[i]['name'], 'alt', resp[i]['id'], 'src', 'img/'+resp[i]['name']], null);
                        var elem = document.getElementById('picinstance'+resp[i]['id'] + count);
                        if (!elem)
                            return ;
                        var p_elem = document.getElementById('hoverinstance'+resp[i]['id'] + count++);
                        add_hover_effect(elem);
                        elem.addEventListener('click', function( event ) { 
                            var parent = child_to_parent(document.body, 'div', ['commentbackground'], null, null);
                            var element = child_to_parent(parent, 'div', ['clickcont'], null, null);
                            var img_wrap = child_to_parent(element, 'div', ['clickpicturebackground'], null, null);
                            img_wrap.addEventListener("dblclick", function() {
                                like_picture(event.target.alt);
                              });
                            var child = child_to_parent(img_wrap, 'img', ['clickpicture'], null, null);
                            child.src = 'img/' + event.target.title;
                            var wrap = child_to_parent(element, 'div', ['commentdivoverflow'], null, null);
                            wrap.appendChild(get_comments(event.target.alt));
                        });
                    }
                    picture_id += i;
                }
            }
        }
    };
    xhr.send("start=" + picture_id);
}

window.onclick = function(e) {
    if (e.target.matches('.commentbackground')) {
        var show = document.getElementsByClassName("commentbackground")[0];
            if (show)
                document.body.removeChild(show);
    }
}

function like_picture(id) {
    var like = new XMLHttpRequest();
    like.open("post", 'server/fetchGallery.php', true);
    like.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    like.onreadystatechange = function (event) {
        if(like.readyState === XMLHttpRequest.DONE) {
            if (like.status === 0 || (like.status >= 200 && like.status < 400)) {
                if (!event.target.response.startsWith('error')) {
                    last_score = document.getElementById('likedlike').innerHTML;
                    new_score = parseInt(last_score,10) + 1;
                    document.getElementById('likedlike').innerHTML = new_score;
                    messageBox(event.target.response, 'green');
                } else
                    messageBox(event.target.response, 'red');
            }
        }

    }
    like.send("like_id=" + id);
}

function show_likes(resp) {
    var likes = child_to_parent(document.getElementsByClassName('clickpicturebackground')[0], 'div', ['likes'], null, '	&#10084; <span id="likedlike">' + resp['likes'] + '</span> &#128172; ' + resp['comments']);
    if (sessionStorage.getItem('css_change_likes') != null)
        likes.setAttribute('style', 'display: none;');
}

function get_comments(id) {
    var child = child_to_parent(null, 'div', ['commentcont'], null, null);
    var xhr = new XMLHttpRequest();
    xhr.open("post", 'server/fetchGallery.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function (event) {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 0 || (xhr.status >= 200 && xhr.status < 400)) {
                if (!event.target.response.startsWith('error')) {
                    resp = JSON.parse(event.target.response);
                    i = 0;
                    while (resp[i + 1]) {
                        var elem = child_to_parent(child, 'p', null, null, null);
                        elem.innerHTML = resp[i]['author'] + ' : [' + resp[i]['text'] + ']';
                        i++;
                    }
                    show_likes(resp[i]);
                } else {
                    //console.log(event.target.response);
                }
                var form = child_to_parent(child, 'form', null, ['id', 'forms'], null);
                var elem = child_to_parent(form, 'textarea', null, ['id', 'commenttextarea', 'name', 'comment'], null);
                elem.required = true;
                var pic_id = child_to_parent(form, 'input', null, ['type', 'text', 'name', 'id', 'value', id], null);
                pic_id.required = true;
                var sub = child_to_parent(form, 'input', null, ['id', 'formUrl', 'name', 'server/writeComment.php', 'value', 'comment', 'type', 'submit'], null);
                document.forms['forms'].addEventListener('submit', (event) => {
                    event.preventDefault();
                });
                document.getElementById('commenttextarea').addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        event.preventDefault();
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", document.getElementById("formUrl").name); 
                        xhr.onreadystatechange = function (event) {
                            if(xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 0 || (xhr.status >= 200 && xhr.status < 400)) {
                                    if (event.target.response.startsWith('success')) {
                                        messageBox(event.target.response, 'green');
                                        var parent = document.getElementsByClassName('commentdivoverflow')[0];
                                        if (parent != null) {
                                            parent.removeChild(document.getElementsByClassName('commentcont')[0]);
                                            parent.appendChild(get_comments(id));
                                        }
                                    } else {
                                    messageBox(event.target.response, 'red');
                                    }
                                }
                            }
                        };
                        var formData = new FormData(document.getElementById("forms"));
                        xhr.send(formData);
                    }
                });
            }
        }
    }
    xhr.send("gallery_id=" + id);
    return (child);
}

function scroller() {
    if(wrapper.scrollTop +wrapper.offsetHeight>content.offsetHeight - 100)
        makeCallForPics();
}
if (wrapper)
    wrapper.addEventListener('scroll', scroller, false);

makeCallForPics();