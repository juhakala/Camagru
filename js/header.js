function dropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}
window.onclick = function(e) {
    if (!e.target.matches('.dropbtn')) {
        var myDropdown = document.getElementById("myDropdown");
        if (myDropdown.classList.contains('show'))
            myDropdown.classList.remove('show');
    }
}

// masters function to handle middle class filling by xmlhttprequests
var request = new XMLHttpRequest();
function masters(str, form) {
    //console.log('str is: ' + str);
    //console.log('form is: ' + form);
    sessionStorage.setItem('page', str);
    sessionStorage.setItem('form', form);
    request.open('GET', str, true);
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            var resp = request.responseText;
            document.getElementsByClassName('middle')[0].innerHTML = resp;
        }
    };
    request.send();
    if (form != null) {
        //console.log('form data');
        formPage(form)
    }
}

function formPage(str) {
    var js_request = new XMLHttpRequest();
    js_request.responseType = 'blob';
    js_request.open('GET', str, true);
    js_request.onload = function () {
        var script = document.createElement('script'),
        src = URL.createObjectURL(js_request.response);
        script.src = src;
        document.body.appendChild(script);
    };
    js_request.send();
}
function userLogoutPage() {
    sessionStorage.setItem('page', 'gallery.php');
    sessionStorage.setItem('form', 'js/gallery.js');
    console.log(sessionStorage.getItem('page'));
    request.open('GET', 'login/logout.php', true);
    request.onload = function() {};
    request.send();
    document.location.reload(true);
}
