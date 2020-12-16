// masters function to handle middle class filling by xmlhttprequests
var request = new XMLHttpRequest();
function slaves(str, form) {
    //console.log('str is: ' + str);
    //console.log('form is: ' + form);
    sessionStorage.setItem('page', str);
    sessionStorage.setItem('form', form);
    request.open('GET', str, true);
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            var resp = request.responseText;
            document.getElementsByClassName('middle')[0].innerHTML = resp;
            if (form != 'null') {
                //console.log('inside form is: ' + form);
                formPage(form);
            }
        }
    };
    request.send();
}

function formPage(str) {
    var js_request = new XMLHttpRequest();
    js_request.responseType = 'blob';
    js_request.open('GET', str, true);
    js_request.onload = function () {
        document.getElementById('tmpScript').remove();
        var script = document.createElement('script'),
        src = URL.createObjectURL(js_request.response);
        script.src = src;
        script.setAttribute("id", "tmpScript");
        document.body.appendChild(script);
    };
    js_request.send();
}
function userLogoutPage() {
    sessionStorage.setItem('page', 'api/gallery.php');
    sessionStorage.setItem('form', 'js/gallery.js');
    console.log(sessionStorage.getItem('page'));
    request.open('GET', 'server/UM/logout.php', true);
    request.onload = function() {};
    request.send();
    document.location.reload(true);
}
