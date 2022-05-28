<?php

require_once 'check-up.php';
 if (!$userid=check_up()) {
    header('Location: login.php');
    exit;
}


?>

<html>

<head>
    <link rel='stylesheet' href='./style/home.css'>
    <script src='./scripts/cerca_utenti.js' defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link rel="icon" href="favicon.png" type="image/png" />
    <title>Sportify-ricerca_utenti</title>
</head>

<body>
    <header>
        <div id="overlay"></div>
        <nav>
            <div id="titolo">Sportify</div>
            <div class="links">
                <a href="./">Home</a>
                <a class='here' href="profilo.php">Profilo</a>
                <a href="new_post.php">Nuovo post</a>
                <a href="logout.php">Logout</a>
            </div>

            <div id="sidebar_button">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </nav>

        <h1>
            <h1>
                <strong>Ricerca utenti</strong><br />
            </h1>

    </header>

    <div class="search_people">
        <label>Ricerca Utenti<input type="search" id="search_people"></label>
        <div class="btnCerca">
            <button class="CercaUtente">Ricerca Utente</button>
            <button class="TuttiUtenti">Visualizza tutti gli utenti</button>
        </div>
    </div>


    <div class="utenti hidden">

    </div>

    <!--SIDEBAR-->
    <section id="sidebar" class="hidden">
        <div class="side" id="sidebar_links">

            <a href="./">Home</a>
            <a href="profilo.php">Profilo</a>
            <a class='here' href="ricerca_utenti.php">Ricerca utenti</a>
            <a href="new_post.php">Nuovo post</a>
            <a href="logout.php">Logout</a>
        </div>
    </section>
</body>

<footer>
    <p>
        Developed by Dario Rovito
    </p>
</footer>

</html>