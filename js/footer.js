document.getElementById('dropdown').addEventListener('click', (event) => {
    elem = document.getElementById('show');
    if (elem.style.display == 'none')
        elem.style.display = 'block';
    else
        elem.style.display = 'none';
});
document.querySelectorAll('#css_change').forEach(item => {
    item.addEventListener('change', (event) => {
        if (event.target.checked == true)
            sessionStorage.setItem('css_change_' + event.target.name, event.target.value);
        else
            sessionStorage.removeItem('css_change_' + event.target.name);
        run_themes()
    });
});
document.querySelectorAll('#css_change').forEach(item => {
    if (sessionStorage.getItem('css_change_' + item.name) != null)
        item.checked = true;
});