
var wrapper = document.getElementById("wrapper");
var content = document.getElementById("content");
var test = document.getElementById("test");

var picture_id = 0;
var data = "start="+picture_id;
function makeCallForPics() {
    data = "start="+picture_id;
    console.log('make call: ' + data);
    var xhr = new XMLHttpRequest();
    xhr.open("post", 'server/fetchGallery.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function(event){ 
        if (event.target.response.startsWith('error')) {
            messageBox(event.target.response, 'red');
            picture_id = 0; //for infinity scroll
        } else {
            resp = JSON.parse(event.target.response);
            i = 0;
            while (resp[i]) {
//                console.log(resp[i]['name']);
                content.innerHTML+= '<div class="galdiv"><img src="img/'+resp[i++]['name']+'" class="galpicture"></div>';
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
