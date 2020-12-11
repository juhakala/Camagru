function fade(parent, element) {
    var op = 1;  // initial opacity
    var timer = setInterval(function () {
        if (op <= 0.1){
            clearInterval(timer);
            document.body.removeChild(parent);
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op -= op * 0.1;
    }, 300);
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