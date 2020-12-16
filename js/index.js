function fade(parent, element) {
    var op = 1;  // initial opacity setTimeout(function () {
    var timer = setTimeout(function () {
        var intimer = setInterval(function () {
            if (op <= 0.1){
                clearInterval(intimer);
                document.body.removeChild(parent);
                return ;
            }
            element.style.opacity = op;
            element.style.filter = 'alpha(opacity=' + op * 100 + ")";
            op -= op * 0.1;
        }, 40);
    }, 1000);
}
function messageBox(str, color) {
    var element = document.createElement('div');
    var parent = document.createElement('div');
    parent.setAttribute("class", "messagediv");
    if (color == 'green')
        element.setAttribute("class", "succesful");
    else
        element.setAttribute("class", "failure");
    element.innerHTML = str;
    parent.appendChild(element);
    document.body.appendChild(parent);
    fade(parent, element);
}

if (sessionStorage.getItem('message') != null) {
    messageBox(sessionStorage.getItem('message'), sessionStorage.getItem('color'));
    sessionStorage.removeItem('message');
    sessionStorage.removeItem('color');
}
if (sessionStorage.getItem('css_change_night') != null) {
    document.body.style.background = '#020321';
}