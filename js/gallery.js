
//window.addEventListener('DOMContentLoaded', (event) => {
var more = '<div style="height: 600px; background: #EEE;"><img src="img/dog1.jpg" style="height: 600px;"></div><div style="height: 600px; background: #EEE;"><img src="img/dog2.jpg" style="height: 600px;"></div>';
var wrapper = document.getElementById("wrapper");
var content = document.getElementById("content");
var test = document.getElementById("test");
test.innerHTML += wrapper.scrollTop +"+"+wrapper.offsetHeight+">"+content.offsetHeight;
content.innerHTML = more;
var n = 3;
var times = 0;
function addEvent(obj,ev,fn) {
    if(obj.addEventListener)
        obj.addEventListener(ev,fn,false);
    else if(obj.attachEvent)
        obj.attachEvent("on"+ev,fn);
}
function scroller() {
    more = '<div style="height: 600px; background: #EEE;"><img src="img/dog'+n+'.jpg" style="height: 600px;"></div><div style="height: 600px; background: #EEE;"><img src="img/dog'+(n+1)+'.jpg" style="height: 600px;"></div>';
    test.innerHTML = wrapper.scrollTop +"+"+wrapper.offsetHeight+">"+content.offsetHeight;
    if(wrapper.scrollTop +wrapper.offsetHeight>content.offsetHeight - 100 && times < 3) {
        content.innerHTML+= more;
        //console.log(content);
        n += 2;
        if (n > 6) {
            //times++;
            n = 1;
        }
    }
}
addEvent(wrapper,"scroll",scroller);
