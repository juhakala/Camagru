// masters function to handle middle class filling by xmlhttprequests
var request = new XMLHttpRequest();
function slaves(str, form) {
    sessionStorage.setItem('page', str);
    sessionStorage.setItem('form', form);
    request.open('GET', str, true);
    request.onreadystatechange = function (event) {
        if(request.readyState === XMLHttpRequest.DONE) {
            if (request.status === 0 || (request.status >= 200 && request.status < 400)) {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    document.getElementsByClassName('middle')[0].innerHTML = resp;
                    if (form != 'null') {
                        formPage(form);
                    }
                }
            }
        }
    };
    request.send();
}

function formPage(str) {
    var js_request = new XMLHttpRequest();
    js_request.responseType = 'blob';
    js_request.open('GET', str, true);
    js_request.onreadystatechange = function (event) {
        if(js_request.readyState === XMLHttpRequest.DONE) {
            if (js_request.status === 0 || (js_request.status >= 200 && js_request.status < 400)) {
                document.getElementById('tmpScript').remove();
                var script = document.createElement('script'),
                src = URL.createObjectURL(js_request.response);
                script.src = src;
                script.setAttribute("id", "tmpScript");
                document.body.appendChild(script);
            }
        }
    };
    js_request.send();
}
function userLogoutPage() {
    sessionStorage.setItem('page', 'api/gallery.php');
    sessionStorage.setItem('form', 'js/gallery.js');
    request.open('GET', 'server/UM/logout.php', true);
    request.onreadystatechange = function (event) {
        if(request.readyState === XMLHttpRequest.DONE) {
            if (request.status === 0 || (request.status >= 200 && request.status < 400)) {
                document.location.reload(true);
            }
        }
    };
    request.send();
}
