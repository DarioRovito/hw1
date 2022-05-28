<?php


require_once 'check-up.php';



header('Content-Type: application/json');
//In base al post che voglio cercare viene scelto una di queste possibilità
switch($_GET['type']) {
    case 'giphy': on_giphy(); break;
    case 'sports':on_sports(); break;
    case 'spotify':on_spotify(); break;
    default: break;
}



function on_giphy(){
    $api_key_giphy='Yti2IlfR6RcCB4tZYieRb2lkWHxNAfrJ';
 
    $query = urlencode($_GET["q"]);
    $url = 'http://api.giphy.com/v1/gifs/search?q='.$query.'&api_key='. $api_key_giphy .'&limit=20';
  
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    $json = json_decode($data, true);
    curl_close($ch);
     $json_array=array();
     for( $g=0; $g<count($json['data']); $g++){
        $json_array[]=array('id' => $json['data'][$g]['id'], 'thumbnail' => $json['data'][$g]['images']['preview_gif']['url'], 'height' => $json['data'][$g]['images']['preview_gif']['height'], 'width' => $json['data'][$g]['images']['preview_gif']['width']);
    }

     echo json_encode($json_array);
}


function on_spotify(){
    $client_id_spotify='65839724ae5d46508386a6a27a5b7fd5';
    $client_secret_spotify='2971a1e7da284e22ac561a96a1114f98';

    // ACCESS TOKEN
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token' );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Eseguo la POST
    curl_setopt($ch, CURLOPT_POST, 1);
    // Setto body e header della POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials'); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($client_id_spotify.':'.$client_secret_spotify))); 
    $token=json_decode(curl_exec($ch), true);
    curl_close($ch); 
    
    //eseguo la query
    $query = urlencode($_GET["q"]);
    $url = 'https://api.spotify.com/v1/search?type=track&q='.$query;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // Imposto il token
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token['access_token'])); 
    $res=curl_exec($ch);
    curl_close($ch);
    echo $res;
}

function on_sports(){
    $query = urlencode($_GET["q"]);
    $url = 'https://sports.api.decathlon.com/sports/search/'.$query.'?source=' . 'popular' . '&coordinates=' . '2.3333' . ',' . '48.8667';
    
     // Creo il CURL handle per l'URL selezionato
     $ch = curl_init($url);
     // Setto che voglio ritornato il valore, anziché un boolean (default)
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
     $res=curl_exec($ch);
      // Libero le risorse
    curl_close($ch);
    echo $res;
    
    }


