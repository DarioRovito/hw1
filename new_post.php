<?php

require_once 'check-up.php';
 if (!$userid=check_up()) {
    header('Location: login.php');
    exit;
}

?>


<html>

<head>
    <link rel='stylesheet' href='./style/new_post.css'>
    <script src='./scripts/new_post.js' defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Grechen+Fuemen&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IM+Fell+DW+Pica+SC&display=swap" rel="stylesheet">
    <link rel="icon" href="favicon.png" type="image/png" />
    <title>Sportify-new_post</title>

</head>

<body>

    <header>

        <div id="overlay"></div>
        <nav>
            <div id="titolo">Sportify </div>
            <div class="links">
                <a href="./">Home</a>
                <a class='here' href="profilo.php">Profilo</a>
                <a href="ricerca_utenti.php">ricerca utenti</a>
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

            <strong>Crea il tuo nuovo post</strong><br />
        </h1>
    </header>

    <article>
        <form name='search_content' id='search'>

            <h1>Ricerca post</h1>

            <input type='text' name='content' id='content'>

            <select name='type' id='tipo'>
                <option value='sports'>Sports</option>
                <option value='giphy'>Giphy</option>
                <option value='spotify'>Spotify</option>
            </select>

            <label>&nbsp;<input class="submit" type='submit'></label>
        </form>
    </article>

    <section class="box_container">

        <div id="contents">
        </div>

    </section>

    <section id="modale" class="hidden">
    </section>


    <!--SIDEBAR-->
    <section id="sidebar" class="hidden">
        <div class="side" id="sidebar_links">

            <a href="./">Home</a>
            <a href="profilo.php">Profilo</a>
            <a href="ricerca_utenti.php">Ricerca utenti</a>
            <a class='here' href="new_post.php">Nuovo post</a>
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