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
            messageBox(event.target.response, 'red');
            // atm shits on event listeners -> maybe add counter to elem ids so private listeners? 
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
                    element.classList.add("clickcont");
                    var child = document.createElement("IMG");
                    child.classList.add("clickpicture");
                    child.src = event.target.src.slice(30);
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
    if (!e.target.matches('.clickcont')) {
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
                elem.innerHTML = resp[i]['author'] + ' : [' + resp[i]['text'] + ']';
                child.appendChild(elem);
                i++;
            }
        }
    }
    xhr.send("gallery_id=" + id);
    return (child);
}