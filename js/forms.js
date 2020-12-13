/*
-(20:13) dont need to specify method in forms since preventDefault? 20:13
-(22:52) yep doesnt matter at all but evaluators are stupid so lets put post 
    because 'sensitive should always be post' <(-_- )>
-(04:39) naah just take all away  
*/

/*
need
form with id='forms'
submit button for form with id='formUrl' and name='url you want form to go'
*/

document.forms['forms'].addEventListener('submit', (event) => {
    event.preventDefault();
    //console.log(document.getElementById("formUrl").name);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", document.getElementById("formUrl").name); 
    xhr.onload = function(event){ 
        if (event.target.response.startsWith('success')) {
            sessionStorage.setItem('page', 'api/gallery.php');
            sessionStorage.setItem('form', 'js/gallery.js');
            sessionStorage.setItem('message', event.target.response);
            sessionStorage.setItem('color', 'green');
            //window.location.href = 'http://localhost:8080/Camagru/index.php';
            window.location.href = window.location.href
            //document.location.reload(true);
            //messageBox(event.target.response, 'green');
        } else {
            messageBox(event.target.response, 'red');
        }
    };
    var formData = new FormData(document.getElementById("forms"));
    xhr.send(formData);
});

