// masters function to handle middle class filling by xmlhttprequests
function slaves(str, form, email, hash) {
    if (str === null || str === 'null' || str === '') {
        str = 'api/gallery.php';
        form = 'js/gallery.js';
    }
    var request = new XMLHttpRequest();
    sessionStorage.setItem('page', str);
    sessionStorage.setItem('form', form);
    request.open('POST', 'server/redirectConfirm.php', true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function (event) {
        if(request.readyState === XMLHttpRequest.DONE) {
            if (request.status === 0 || (request.status >= 200 && request.status < 400)) {
                if (request.status >= 200 && request.status < 400) {
                    var resp = request.responseText;
                    document.getElementsByClassName('middle')[0].innerHTML = resp;
                    if (form != 'null') {
                        var js_request = new XMLHttpRequest();
                        js_request.responseType = 'blob';
                        js_request.open('POST', 'server/redirectConfirm.php', true);
                        js_request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        js_request.onreadystatechange = function (event) {
                            if(js_request.readyState === XMLHttpRequest.DONE) {
                                if (js_request.status === 0 || (js_request.status >= 200 && js_request.status < 400)) {
                                    if (document.getElementById('tmpScript'))
                                        document.getElementById('tmpScript').remove();
                                    var script = document.createElement('script'),
                                    src = URL.createObjectURL(js_request.response);
                                    script.src = src;
                                    script.setAttribute("id", "tmpScript");
                                    document.body.appendChild(script);
                                }
                            }
                        };
                        js_request.send('data='+form);
                    }
                }
            }
        }
    };
    if (email != '' && hash != '' && email != null && hash != null)
        request.send('url='+str+'&email='+email+'&hash='+hash);
    else
        request.send('url='+str);
}
function userLogoutPage() {
    var request = new XMLHttpRequest();
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
