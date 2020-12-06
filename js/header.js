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

// master function to handle middle class filling by xmlhttprequests
var request = new XMLHttpRequest();
function masters(str) {
//    url = sessionStorage.getItem('page') == null ? 'gallery.php' : sessionStorage.getItem('page');
    sessionStorage.setItem('page', str);
    request.open('GET', str, true);
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            var resp = request.responseText;
            document.getElementsByClassName('middle')[0].innerHTML = resp;
        }
    };
    request.send();
    console.log("str url is: " + str);
    if (str == 'gallery.php')
        galleryPage()
}

function galleryPage() {
    //sessionStorage.setItem('page', 'gallery.php');
    var js_request = new XMLHttpRequest();
    js_request.responseType = 'blob';
    js_request.open('GET', 'test.js', true);
    js_request.onload = function () {
        var script = document.createElement('script'),
        src = URL.createObjectURL(js_request.response);
        script.src = src;
        document.body.appendChild(script);
    };
    js_request.send();
}
//function editPage() {
//    //sessionStorage.setItem('page', 'api/edit.php');
//    //masters();
//}
//function userSettingsPage() {
//    //sessionStorage.setItem('page', 'api/userSettings.php');
//    //masters();
//}
//function forgotPassPage() {
//    //sessionStorage.setItem('page', 'api/forgotPass.php');
//    //masters();
//}
//function newUserPage() {
//    //sessionStorage.setItem('page', 'api/newUser.php');
//    //masters();
//}
//function userLoginPage() {
//    //sessionStorage.setItem('page', 'api/login.php');
//    //masters();
//}
function userLogoutPage() {
    sessionStorage.setItem('page', 'gallery.php');
    console.log(sessionStorage.getItem('page'));
    request.open('GET', 'login/logout.php', true);
    request.onload = function() {};
    request.send();
    document.location.reload(true);
}
