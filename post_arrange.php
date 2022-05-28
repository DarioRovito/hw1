<?php
//php necessario per inserire nel database il post da pubblicare

require_once 'check-up.php';
 if (!$userid=check_up()) {
    header('Location: login.php');
    exit;
}

//In base al post che si vuole pubblicare viene scelto una di queste possibilità
switch($_POST['type']) {
    case 'giphy': giphy(); break;
    case 'spotify': spotify(); break;
    case 'sports': sports();break;
    default: break;
}


function spotify() {

    GLOBAL $dbconfig, $userid;

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    
    // Costruisco la query
    $userid = mysqli_real_escape_string($conn, $userid);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $text = mysqli_real_escape_string($conn, $_POST['text']);

    // Eseguo la query : inserisco nella tabella post del mio database il post che voglio pubblicare
    $query = "INSERT INTO posts(user, content) VALUES('.$userid.', JSON_OBJECT('type', '$type', 'text', '$text', 'id', '$id'))";

    // Se corretta, ritorna un JSON con {ok: true}
    if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
        echo json_encode(array('done' => true));
        exit;
    }

    mysqli_close($conn);
    echo json_encode(array('done' => false));
}




function giphy() {

    GLOBAL $dbconfig, $userid;
    $url = 'http://api.giphy.com/v1/gifs/'.$_POST["id"].'?api_key=Yti2IlfR6RcCB4tZYieRb2lkWHxNAfrJ';
    $data =  file_get_contents($url);
    $json = json_decode($data, true);

    if($json['meta']['status'] == 200) {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        // Costruisco la query
        $userid = mysqli_real_escape_string($conn, $userid);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $text = mysqli_real_escape_string($conn, $_POST['text']);
        $url = mysqli_real_escape_string($conn, $json['data']['images']['original']['url']);
   
        // Eseguo la query : inserisco nella tabella post del mio database il post che voglio pubblicare
        $query = "INSERT INTO posts(user, content) VALUES('.$userid.', JSON_OBJECT('type', '$type', 'text', '$text', 'id', '$id', 'url', '$url'))";

        if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
            echo json_encode(array('done' => true));
            exit;
        }
        
    }

    echo json_encode(array('done' => false));
}



function sports(){
    GLOBAL $dbconfig, $userid;
    $url = 'https://sports.api.decathlon.com/sports/'.$_POST["id"];

    $data =  file_get_contents($url);
    $json = json_decode($data, true);

        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        // Costruisco la query
        $userid = mysqli_real_escape_string($conn, $userid);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $text = mysqli_real_escape_string($conn, $_POST['text']);
        $url = mysqli_real_escape_string($conn, $json['data']['relationships']['images']['data']['0']['url']);
        // Eseguo la query : inserisco nella tabella post del mio database il post che voglio pubblicare
        $query = "INSERT INTO posts(user, content) VALUES('.$userid.', JSON_OBJECT('type', '$type', 'text', '$text', 'id', '$id', 'url', '$url'))";

        if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
            echo json_encode(array('done' => true));
            exit;
        }
     
        mysqli_close($conn);
        echo json_encode(array('ok' => false));
    }

?>

