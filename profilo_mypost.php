<?php 

require_once 'check-up.php';
if (!$userid=check_up()) {
   header('Location: login.php');
   exit;
}

    $username=$_SESSION['_sito_username'];
    header('Content-Type: application/json');

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $userid = mysqli_real_escape_string($conn, $userid);
    
    // Se devo mostrare contenuti a partire da un certo numero, creo la stringa della query associata
    $next = isset($_GET['from']) ? 'AND posts.id < '.mysqli_real_escape_string($conn, $_GET['from']).' ' : '';
        
         // Seleziono tutti gli attributi che mi interessano
        // (FROM) Dall'unione tra i post e gli utenti (dell'utente di cui sto visualizzando il profilo)
$query = "SELECT users.id AS userid, users.name AS name, users.surname AS surname, users.username AS username, users.propic AS propic,posts.id AS postid, posts.content AS content, posts.time AS time, posts.nlikes AS nlikes, posts.ncomments AS ncomments,
        EXISTS(SELECT user FROM likes WHERE post = posts.id AND user = $userid) AS liked 
        FROM posts JOIN users ON posts.user = users.id where users.username ='$username' ORDER BY postid DESC LIMIT 10";



    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
     
    $postArray = array();


    while($entry = mysqli_fetch_assoc($res)) {
        // Scorro i risultati ottenuti e creo l'elenco di post
        $propic = $entry['propic'] == null ? "images/default_avatar.png" : $entry['propic'];
        $time = getTime($entry['time']);
        $postArray[] = array('userid' => $entry['userid'], 'name' => $entry['name'], 'surname' => $entry['surname'], 
                            'username' => $entry['username'], 'propic' => $propic, 
                            'postid' => $entry['postid'], 'content' => json_decode($entry['content']), 'nlikes' => $entry['nlikes'], 
                            'ncomments' => $entry['ncomments'], 'time' => "$time", 'liked' => $entry['liked']);
    }
    echo json_encode($postArray);
    
    exit;

    function getTime($timestamp) {      
        // Calcola il tempo trascorso dalla pubblicazione del post       
        $old = strtotime($timestamp); 
        $diff = time() - $old;           
        $old = date('d/m/y', $old);

        if ($diff /60 <1) {
            return intval($diff%60)." secondi fa";
        } else if (intval($diff/60) == 1)  {
            return "Un minuto fa";  
        } else if ($diff / 60 < 60) {
            return intval($diff/60)." minuti fa";
        } else if (intval($diff / 3600) == 1) {
            return "Un'ora fa";
        } else if ($diff / 3600 <24) {
            return intval($diff/3600) . " ore fa";
        } else if (intval($diff/86400) == 1) {
            return "Ieri";
        } else if ($diff/86400 < 30) {
            return intval($diff/86400) . " giorni fa";
        } else {
            return $old; 
        }
    }
    
    mysqli_close($conn);
?>