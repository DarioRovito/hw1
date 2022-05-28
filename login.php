<?php
 include 'check-up.php';
 if (check_up()) {
    header('Location: home.php');
    exit;
}


if (!empty($_POST["username"]) && !empty($_POST["password"]) )
    {

       // Se username e password sono stati inviati viene fatta la connessione al DATABASE
       $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $search = filter_var($username, FILTER_VALIDATE_EMAIL) ? "email" : "username";
        $query = "SELECT id, username, password FROM users WHERE $search = '$username'";

        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
        if (mysqli_num_rows($res) > 0) {
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $entry['password'])) {
                // Imposto una sessione dell'utente
                $_SESSION["_sito_username"] = $entry['username'];
                $_SESSION["_sito_user_id"] = $entry['id'];
                header("Location: home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
        }
        // Se l'utente non è stato trovato o la password non ha passato la verifica
        $error = "Username e/o password errati.";
    }
    else if (isset($_POST["username"]) || isset($_POST["password"])) {
        $error = "Inserisci username e password.";
    }

?>


<html>

<head>
    <link rel='stylesheet' href='./style/signup.css'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="favicon.png" type="image/png" />
    <title>Sportify-Login</title>
</head>

<body>

    <main class="login">

        <section class="section_main">
            <h1>Benvenuto!!</h1>
            <?php
                  // Verifica la presenza di errori
                  if (isset($error)) {
                      echo "<span class='error'>$error</span>";
                  }
                  
              ?>

            <form name='login' method='post'>
                <div class="username">
                    <div><label for='username'>Nome utente o email</label></div>
                    <div><input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>></div>
                </div>
                <div class="password">
                    <div><label for='password'>Password</label></div>
                    <div><input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>></div>
                </div>
                <input type='submit' value="Accedi">
                </div>
            </form>
            <div class="signup">Non hai un account? <a href="signup.php">Iscriviti</a>
        </section>
    </main>
    <footer>
        <p>
            Developed by Dario Rovito
        </p>
    </footer>

</body>

</html>