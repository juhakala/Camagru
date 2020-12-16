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
    });
    if (item.name == 'night') {
        item.addEventListener('change', (event) => {
            if (sessionStorage.getItem('css_change_' + item.name) != null) {
                document.body.style.background = '#020321';
                if (document.getElementsByClassName('container')[0]) {
                    document.getElementsByClassName('container')[0].style.background = '#2d2d2e';
                    document.getElementsByClassName('inner')[0].style.background = '#2d2d2e';
                } else if (document.getElementById('ontop')) {
                    document.getElementById('ontop').style.background = '#2d2d2e';
                    document.getElementById("wrapper").style.background = '#2d2d2e';
                }
            } else {
                document.body.style.background = 'white';
                if (document.getElementsByClassName('container')[0]) {
                    document.getElementsByClassName('container')[0].style.background = '#EEE';
                    document.getElementsByClassName('inner')[0].style.background = '#EEE';
                } else if (document.getElementById('ontop')) {
                    document.getElementById('ontop').style.background = '#EEE';
                    document.getElementById("wrapper").style.background = '#EEE';
                }
            }

        });
    }
});
document.querySelectorAll('#css_change').forEach(item => {
    if (sessionStorage.getItem('css_change_' + item.name) != null)
        item.checked = true;
});