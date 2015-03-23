<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{ALIAS:PATH}/style/user-page.css">
    <link rel="stylesheet" href="{ALIAS:PATH}/style/content.css">
    <link rel="stylesheet" href="{ALIAS:PATH}/style/audio.css">
    <link rel="stylesheet" href="{ALIAS:PATH}/style/font-awesome.css">
    <script src="{ALIAS:PATH}/js/styling.js"></script>
    <script src="{ALIAS:PATH}/js/audio.js"></script>
    <title>{ALIAS:TITLE}</title>
</head>
<body style="overflow: hidden">
<div class="full" id="full">
    <section class="main" id="main">
        <header class="main-top">
            <a class="nav-element beauty" style="margin-right:20px" href="#">{ALIAS:EXIT_TEXT}</a>
            <a class="nav-element beauty" href="index.php?audio">{ALIAS:MUSIC_TEXT}</a>
            <a class="nav-element beauty" href="#">{ALIAS:SEARCH_TEXT}</a>
        </header>
        <section class="content">
            {ALIAS:CONTENT}
        </section>
        <footer class="main-down">
            &copy; Copyright {ALIAS:YEAR}. Funtik
        </footer>
    </section>
</div>
</body>
</html>