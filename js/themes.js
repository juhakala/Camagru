window.addEventListener('DOMContentLoaded', (event) => {
    run_themes();
});
function run_themes() {
    if (sessionStorage.getItem('css_change_night') != null) {
        var head = document.getElementsByTagName('HEAD')[0];  
        var link = document.createElement('link'); 
        link.id = 'dark-mode';
        link.rel = 'stylesheet';  
        link.type = 'text/css'; 
        link.href = 'api/css/dark.css';  
        head.appendChild(link); 
    } else if (document.getElementById('dark-mode'))
        document.getElementById('dark-mode').remove();
    console.log('in themes');
}
