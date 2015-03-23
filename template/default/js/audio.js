/**
 * Created by Tuxick on 15.03.2015.
 * TODO: Сделать переключение треков и загрузку из JSON
 */
var buttons = {};
var playerBackend = null;
var playerText = null;

var progressThumb = null;
var progressBack = null;
var progressLoaded = null;
var progressDot = null;
var isProgressClicked = false;
var progress = 0;

var volumeThumb = null;
var volumeBack = null;
var volumeDot = null;
var isVolumeClicked = false;

window.addEventListener('load', playerOnLoad);
window.addEventListener('mouseup', onMouseUp);
window.addEventListener('mousemove', onMouseMove);

function setProgress(value)
{
    progressThumb.style.width = value + '%';
    progressDot.style.left = value + '%';
}

function setLoaded(value)
{
    progressLoaded.style.width = value + '%';
}

function setVolume(value)
{
    volumeThumb.style.width = value + '%';
    volumeDot.style.left = value + '%';
}

function playerOnLoad()
{
    if(document.getElementById('player-backend')) {
        buttons = {
            play: document.getElementById('player-button-play'),
            prev: document.getElementById('player-button-prev'),
            next: document.getElementById('player-button-next')
        };
        buttons['play'].onclick = playButton;
        buttons['prev'].onclick = prevButton;
        buttons['next'].onclick = nextButton;
        playerText = document.getElementById('player-text');
        playerBackend = document.getElementById('player-backend');
        playerBackend.addEventListener('timeupdate', onProgress);
        playerBackend.addEventListener('ended', onEnded);

        progressThumb = document.getElementById('progress-track');
        progressBack = document.getElementById('progress-back');
        progressLoaded = document.getElementById('progress-loaded');
        progressDot = document.getElementById('progress-dot');
        progressThumb.addEventListener('mousedown', progressMouseClick);
        progressBack.addEventListener('mousedown', progressMouseClick);
        progressDot.addEventListener('mousedown', progressMouseClick);

        volumeThumb = document.getElementById('volume-track');
        volumeBack = document.getElementById('volume-back');
        volumeDot = document.getElementById('volume-dot');
        volumeThumb.addEventListener('mousedown', volumeMouseClick);
        volumeBack.addEventListener('mousedown', volumeMouseClick);
        volumeDot.addEventListener('mousedown', volumeMouseClick);

        setProgress(0);
        setLoaded(0);
        if (localStorage.getItem('volume')) {
            playerBackend.volume = parseFloat(localStorage.getItem('volume'));
            setVolume(parseFloat(localStorage.getItem('volume')) * 100);
        }
        else setVolume(playerBackend.volume * 100);

        var playlist = document.getElementsByClassName('playlist-one');
        for(var i = 0; i < playlist.length; ++i)
        {

            playlist[i].addEventListener("click", playListItemClicked);
        }
    }
}

function playButton()
{
    if(playerBackend.paused) {
        playerBackend.play();
        buttons['play'].classList.remove('fa-play');
        buttons['play'].classList.add('fa-pause');
    }
    else {
        buttons['play'].classList.remove('fa-pause');
        buttons['play'].classList.add('fa-play');
        playerBackend.pause();
    }
}
function prevButton()
{
    alert('prev');
}
function nextButton()
{
    alert('next');
}

function onProgress()
{
    if(!isProgressClicked) setProgress(playerBackend.currentTime / playerBackend.duration * 100);
    setLoaded((playerBackend.buffered.end(0) / playerBackend.duration * 100) > 100 ? 100 : (playerBackend.buffered.end(0) / playerBackend.duration * 100) );
}

function onEnded()
{
    setProgress(0.0);
    buttons['play'].classList.remove('fa-pause');
    buttons['play'].classList.add('fa-play');
}

function onMouseUp(e)
{
    if(isProgressClicked) {
        isProgressClicked = false;
        changePos(progress);
    }
    isVolumeClicked = false;
    document.body.classList.remove('unselect');
}

function onMouseMove(e)
{
    var evt = e ? e : window.event;
    if(isProgressClicked) {
        var progressRect = progressBack.getBoundingClientRect();
        var progressClickX = evt.pageX - progressRect.left;
        var time = progressClickX / progressBack.offsetWidth;
        if (time < 0) time = 0;
        else if (time > 1) time = 1;
        setProgress(time * 100);
        progress = time;
    }
    if(isVolumeClicked) {
        var volumeRect = volumeBack.getBoundingClientRect();
        var volumeClickX = evt.pageX - volumeRect.left;
        var value = volumeClickX / volumeBack.offsetWidth;
        if(value < 0) value = 0;
        else if(value > 1) value = 1;
        changeVol(value);
    }
}

function progressMouseClick(e)
{
    document.body.classList.add('unselect');
    isProgressClicked = true;
    var evt = e ? e:window.event;
    var rect = progressBack.getBoundingClientRect();
    var clickX = evt.pageX - rect.left;
    var time = clickX / progressBack.offsetWidth;
    if(time < 0) time = 0;
    else if(time > 1) time = playerBackend.duration;
    setProgress(time * 100);
    progress = time;
}

function changePos(time) {
    playerBackend.currentTime = playerBackend.duration * time;
}

function volumeMouseClick(e)
{
    document.body.classList.add('unselect');
    isVolumeClicked = true;
    var evt = e ? e:window.event;
    var rect = volumeBack.getBoundingClientRect();
    var clickX = evt.pageX - rect.left;
    var value = clickX / volumeBack.offsetWidth;
    if(value < 0) value = 0;
    else if(value > 1) value = 1;
    changeVol(value);
}

function changeVol(value) {
    localStorage.setItem('volume', value);
    playerBackend.volume = value;
    setVolume(value * 100);
}

function playListItemClicked(e)
{
    console.log(e);
    setProgress(0);
    playerBackend.pause();
    playerBackend.src = e.toElement.children['url'].value;
    document.getElementById('player-text').innerText = e.toElement.children['title'].value
    playButton();
}