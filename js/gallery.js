var close = true;
var count = 0;
var wrapper = document.getElementById("wrapper");
var content = document.getElementById("content");
var test = document.getElementById("test");

var picture_id = 0;
var data = "start="+picture_id;
function makeCallForPics() {
    data = "start="+picture_id;
    var xhr = new XMLHttpRequest();
    xhr.open("post", 'server/fetchGallery.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(event){ 
        if (event.target.response.startsWith('error')) {
            //if picture is is not resetting then this is good
            //messageBox(event.target.response, 'red');

            // atm shits on event listeners -> maybe add counter to elem ids so private listeners? 
            // works now, messages are shit thou
            picture_id = 0; //for infinity scroll
    
        } else {
            resp = JSON.parse(event.target.response);
            i = 0;
            while (resp[i]) {
//              console.log(resp[i]);
                var parent = document.createElement("div");
                parent.classList.add("galdiv");
                var child = document.createElement("IMG");
                child.src = 'img/'+resp[i]['name'];
                child.classList.add("galpicture");
                child.setAttribute("id", "picinstance"+resp[i]['id'] + count);
                child.setAttribute("alt", resp[i]['id']);
                child.setAttribute("title", resp[i]['name']);
                var likes = document.createElement("p");
                likes.classList.add("hoverpic");
                likes.setAttribute("id", "hoverinstance"+resp[i]['id'] + count);
                likes.innerHTML = resp[i]['likes'];
                content.appendChild(parent);
                parent.appendChild(child);
                parent.appendChild(likes);
//                console.log('picinstance'+resp[i]['id']);
                var elem = document.getElementById('picinstance'+resp[i]['id'] + count);
                var p_elem = document.getElementById('hoverinstance'+resp[i]['id'] + count);
                elem.addEventListener("mouseenter", function( event ) {
                    //console.log(event.target.id.replace('pic', 'hover'));
                    event.target.style.opacity = '0.3';
                    document.getElementById(event.target.id.replace('pic', 'hover')).style.display = 'block';
                });
                elem.addEventListener("mouseleave", function( event ) {  
                    event.target.style.opacity = '1';
                    document.getElementById(event.target.id.replace('pic', 'hover')).style.display = 'none';
                });

                elem.addEventListener('click', function( event ) { 
                    //console.log('soon');
                    var parent = document.createElement("div");
                    parent.classList.add("commentbackground");
                    var element = document.createElement("div");
                    element.classList.add("clickarea");
                    element.classList.add("clickcont");
                    var child = document.createElement("IMG");
                    child.classList.add("clickarea");
                    child.classList.add("clickpicture");
                    child.src = 'img/' + event.target.title;
                    element.appendChild(child);
                    parent.appendChild(element);
                    element.appendChild(get_comments(event.target.alt));
                    document.body.appendChild(parent);
                    //console.log(element);
                    close = false;
                });
                i++;
                count++;
            }
            picture_id += i;
        }
    };
    xhr.send(data);
}

//test.innerHTML += wrapper.scrollTop +"+"+wrapper.offsetHeight+">"+content.offsetHeight;
makeCallForPics();
function addEvent(obj,ev,fn) {
    if(obj.addEventListener)
        obj.addEventListener(ev,fn,false);
    else if(obj.attachEvent)
        obj.attachEvent("on"+ev,fn);
}
function scroller() {
    //test.innerHTML = wrapper.scrollTop +"+"+wrapper.offsetHeight+">"+content.offsetHeight;
    if(wrapper.scrollTop +wrapper.offsetHeight>content.offsetHeight - 100) {
        makeCallForPics();
    }
}
addEvent(wrapper,"scroll",scroller);

window.onclick = function(e) {
    if (!e.target.matches('.clickarea')) {
        var show = document.getElementsByClassName("commentbackground")[0];
        if (close == true) {
            if (show) {
                document.body.removeChild(show);
                //console.log('closed');
            }
        }
        close = true;
    }
}

function get_comments(id) {
    //console.log('getting comments of id: ' + id + ' soon.');
    var child = document.createElement("div");
    child.classList.add("commentcont");
    var xhr = new XMLHttpRequest();
    xhr.open("post", 'server/fetchGallery.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(event){ 
        if (event.target.response.startsWith('error')) {
            //console.log(event.target.response);
        } else {
            resp = JSON.parse(event.target.response);
            i = 0;
            while (resp[i]) {
//                console.log(resp[i]);
                var elem = document.createElement("p");
                elem.classList.add("clickarea");
                elem.innerHTML = resp[i]['author'] + ' : [' + resp[i]['text'] + ']';
                child.appendChild(elem);
                i++;
            }
        }
        var form = document.createElement("form");
        form.setAttribute("id", 'forms');
        var elem = document.createElement("textarea");
        elem.classList.add("clickarea");
        elem.setAttribute("name", 'comment');
        elem.setAttribute("id", 'commenttextarea');
        elem.required = true;
        form.appendChild(elem);
        var pic_id = document.createElement("input");
        pic_id.setAttribute("type", 'text');
        pic_id.setAttribute("value", id);
        pic_id.setAttribute("name", 'id');
        pic_id.required = true;
        form.appendChild(pic_id);
        var sub = document.createElement("input");
        sub.classList.add("clickarea");
        sub.setAttribute("type", 'submit');
        sub.setAttribute("value", 'comment');
        sub.setAttribute("name", 'server/writeComment.php');
        sub.setAttribute("id", 'formUrl');
        form.appendChild(sub);
        child.appendChild(form);
        document.forms['forms'].addEventListener('submit', (event) => {
            event.preventDefault();
        });
        document.getElementById('commenttextarea').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                event.preventDefault();
                var xhr = new XMLHttpRequest();
                xhr.open("POST", document.getElementById("formUrl").name); 
                xhr.onload = function(event){ 
                    if (event.target.response.startsWith('success')) {
                        messageBox(event.target.response, 'green');
                        var parent = document.getElementsByClassName('clickarea')[0];
                        if (parent != null) {
                            parent.removeChild(document.getElementsByClassName('commentdivoverflow')[0]);
                            parent.appendChild(get_comments(id));
                        }
//                        get_comments(id);
                    } else {
                        messageBox(event.target.response, 'red');
                    }
                };
                var formData = new FormData(document.getElementById("forms"));
                xhr.send(formData);
            }
        });
    }
    xhr.send("gallery_id=" + id);
    var wrap = document.createElement("div");
    wrap.classList.add("commentdivoverflow");
    wrap.appendChild(child);
    return (wrap);
}