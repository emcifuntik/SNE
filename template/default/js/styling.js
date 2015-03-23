/**
 * Created by Tuxick on 11.03.2015.
 */

window.addEventListener('load', firstLoad);
window.addEventListener('resize', adapt);

function firstLoad() {
    document.body.style.backgroundSize = window.screen.width + ' ' + window.screen.height;
    document.getElementById('full').style.width = window.innerWidth + 'px';
    document.getElementById('full').style.height = window.innerHeight + 'px';
    adapt();
    
}

function adapt() {
    document.getElementById('full').style.width = window.innerWidth + 'px';
    document.getElementById('full').style.height = window.innerHeight + 'px';
}

function toggleClass(id, className)
{
    if(document.getElementById(id).classList.contains(className)) {
        document.getElementById(id).classList.remove(className);
    }
    else {
        document.getElementById(id).classList.add(className);
    }
}

function expand(id) {
    if(document.getElementById(id).classList.contains('expanded')) {
        document.getElementById(id).classList.remove('expanded');
        //document.getElementById(id + '-text').style.display = 'none';
    }
    else {
        document.getElementById(id).classList.add('expanded');
        //document.getElementById(id + '-text').style.display = 'block';
    }
}