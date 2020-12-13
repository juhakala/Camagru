function child_to_parent(parent, child_type, class_names, attributes, required) {
    var child = document.createElement(child_type);
    if (class_names != null) {
        for (z = 0; class_names[z]; z++)
            child.classList.add(class_names[z]);
    }
    if (attributes != null) {
        for (z = 0; attributes[z]; z += 2)
            child.setAttribute(attributes[z], attributes[z + 1]);
    }
    if (required === true)
        child.required = true;
    if (parent != null)
        parent.appendChild(child);
    return (child);
}

function changePasswd(parent) {
    input = child_to_parent(parent, 'input', null, ['type', 'password', 'placeholder', 'newPasswd', 'name', 'newPasswd'], true);
    input = child_to_parent(parent, 'input', null, ['type', 'password', 'placeholder', 'newPasswdAgain', 'name', 'newPasswdAgain'], true);
}

function changeEmail(parent) {
    input = child_to_parent(parent, 'input', null, ['type', 'email', 'placeholder', 'newEmail', 'name', 'newEmail'], true);
    input = child_to_parent(parent, 'input', null, ['type', 'email', 'placeholder', 'newEmailAgain', 'name', 'newEmailAgain'], true);
}

function changeLogin(parent) {
    input = child_to_parent(parent, 'input', null, ['type', 'text', 'placeholder', 'newLogin', 'name', 'newLogin'], true);
    input = child_to_parent(parent, 'input', null, ['type', 'text', 'placeholder', 'newLoginAgain', 'name', 'newLoginAgain'], true);
}

function deleteLogin(parent) {
    input = child_to_parent(parent, 'input', null, ['type', 'text', 'placeholder', 'login', 'name', 'login'], true);
}

function createForm(name) {
    if (document.forms['forms'])
        document.getElementsByClassName('formParent')[0].removeChild(document.forms['forms']);
    var parent = document.getElementsByClassName('formParent')[0];
    var form = child_to_parent(parent, 'form', null, ['id', 'forms'], false);
    child_to_parent(form, 'input', null, ['name', 'name', 'type', 'hidden', 'value', name], false);
    name == 'passChange' ? changePasswd(form) : 0;
    name == 'emailChange' ? changeEmail(form) : 0;
    name == 'loginChange' ? changeLogin(form) : 0;
    name == 'loginDelete' ? deleteLogin(form) : 0;
    child_to_parent(form, 'input', null, ['type', 'password', 'placeholder', 'passwd', 'name', 'passwd'], true);
    child_to_parent(form, 'input', null, ['id', 'formUrl', 'type', 'submit', 'name', 'server/UM/userSettings.php'], false);
    document.forms['forms'].addEventListener('submit', (event) => {
        event.preventDefault();
        var xhr = new XMLHttpRequest();
        xhr.open("POST", document.getElementById("formUrl").name); 
        xhr.onload = function(event){ 
            if (event.target.response.startsWith('success')) {
                sessionStorage.setItem('page', 'gallery.php');
                sessionStorage.setItem('form', 'js/gallery.js');
                sessionStorage.setItem('message', event.target.response);
                sessionStorage.setItem('color', 'green');
                //window.location.href = 'http://localhost:8080/Camagru/index.php';
                document.location.reload(true);
                //messageBox(event.target.response, 'green');
            } else {
                messageBox(event.target.response, 'red');
            }
        };
        var formData = new FormData(document.getElementById("forms"));
        xhr.send(formData);
    });
}