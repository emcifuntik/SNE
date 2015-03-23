<section class="player">
    <audio id="player-backend">
        <source src="temp/1.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <i class="fa fa-play beauty player-button" id="player-button-play"></i>
    <i class="fa fa-fast-backward beauty player-button" id="player-button-prev"></i>
    <i class="fa fa-fast-forward beauty player-button" id="player-button-next"></i>
    <section class="player-information">
        <section class="player-artist beauty" id="player-text"></section>
        <section class="player-progress">
            <section class="player-progress-loaded" id="progress-loaded"></section>
            <section class="player-progress-track" id="progress-back"></section>
            <section class="player-progress-thumb" id="progress-track"></section>
            <section class="player-progress-dot" id="progress-dot"></section>
        </section>
    </section>
    <section class="player-adds">
        <section class="player-artist beauty"></section>
        <section class="player-progress">
            <section class="player-progress-track" id="volume-back"></section>
            <section class="player-progress-thumb" id="volume-track"></section>
            <section class="player-progress-dot" id="volume-dot"></section>
        </section>
    </section>
</section>
<section class="expand" id="search">
    <header class="block beauty" onclick="toggleClass('search', 'search-expand')">
        {ALIAS:SEARCH_TEXT}
    </header>
    <section class="information" id="search-text">

    </section>
</section>
<section class="playlist">
    {BLOCK:BEGIN:PLAYLIST_ITEM}
    <section class="playlist-one" value="{ALIAS:AUDIO_URL}">
        <span style="margin-left: 5px;float:left" class="beauty">{ALIAS:AUDIO_TITLE}</span>
        <span style="margin-right: 5px;float:right" class="beauty">{ALIAS:AUDIO_TIME}</span>
        <input type="hidden" name="url" value="{ALIAS:AUDIO_URL}"/>
        <input type="hidden" name="title" value="{ALIAS:AUDIO_TITLE}"/>
        <input type="hidden" name="time" value="{ALIAS:AUDIO_TIME}"/>
    </section>
    {BLOCK:END:PLAYLIST_ITEM}
</section>
