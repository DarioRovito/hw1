<?php

require_once 'check-up.php';
 if (!$userid=check_up()) {
    header('Location: login.php');
    exit;
}

?>

<html>
    <?php 
        // Carico le informazioni dell'utente loggato per visualizzarle nella sezione profilo della home
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid = mysqli_real_escape_string($conn, $userid);
        $query = "SELECT * FROM users WHERE id = $userid";
        $res_1 = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res_1);   
    ?> 

<head>
    <link rel='stylesheet' href='./style/home.css'>
    <script src='./scripts/home.js' defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Maiden+Orange&display=swap" rel="stylesheet">
    <link rel="icon" href="favicon.png" type="image/png" />

    <title>Sportify-Home</title>
</head>

<body>
    <header>
        <div id="overlay"></div>
        <nav>
            <div id="titolo">Sportify</div>
            <div class="links">
                <a href="./">Home</a>
                <a class='here' href="profilo.php">Profilo</a>
                <a href="ricerca_utenti.php">ricerca utenti</a>
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
            <strong>Condivididi ciò che vuoi con chi vuoi</strong><br />
        </h1>
    </header>
    <section id="profile">
        <div class="avatar" style="background-image: url(<?php echo $userinfo['propic'] == null ? "images/default_avatar.png" : $userinfo['propic'] ?>)">
        </div>
        <div class="name">
            Name:<?php echo $userinfo['name']." ".$userinfo['surname'];?>
        </div>
        <div class="username">
            Username:@<?php echo $userinfo['username'] ?>
        </div>
        <a class="visualizza" href="profilo.php">Visualizza profilo</a>
        <div class="information">
            <div>
                <span class="count"><?php echo $userinfo['nposts'] ?></span><br>Posts
            </div>
            <div id="view_followers">
                <span class="count"><?php echo $userinfo['nfollowers'] ?></span><br>followers
            </div>
            <div id="view_following">
                <span class="count"><?php echo $userinfo['nfollowing'] ?></span><br>following
            </div>
        </div>
    </section>

    <section class="post">
        <article id="box_post">
        </article>
    </section>

    <section id="modale_like" class="hidden">

    </section>
    <!--SIDEBAR-->
    <section id="sidebar" class="hidden">a
        <div class="side" id="sidebar_links">
            <a class='here' href="./">Home</a>
            <a href="profilo.php">Profilo</a>
            <a href="ricerca_utenti.php">Ricerca utenti</a>
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
<?php mysqli_close($conn); ?>