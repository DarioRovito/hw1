<?php

require_once 'check-up.php';
 if (!$userid=check_up()) {
    header('Location: login.php');
    exit;
}




$username_corrente=$_SESSION['_sito_username']; 

include "dbconfig.php";

//se viene premuto il tasto ricerca utente
if(isset($_POST['utente_cercato']))  {
  $array[]=NULL;
  $i=0;


     
       $utente_cercato=$_POST['utente_cercato'];
       $query="SELECT name, surname, username, propic from users where username='$utente_cercato' and username<>'$username_corrente'";


       $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    
       $result=mysqli_query($conn, $query);
       
       //itera i risultati trovati nella query e li trasforma in array 
       while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
       {
            
  
        $array[$i]=$row;
           
       
        $query2="SELECT utente, follower from follow where utente='$username_corrente' and follower='$utente_cercato'";
        $result2=mysqli_query($conn, $query2);
        $row=mysqli_num_rows($result2);

        if($row>0){
       $array[$i]=array_merge($array[$i], array("following"=>"yes"));

        }
        else{

          $array[$i]=array_merge($array[$i], array("following"=>"no"));
        }

         $i++;
        
           

       }
       
           //se è vuoto ritorna zero
       if($array==NULL)
       {
              echo 0;

       }
        //altrimenti manda la risposta in json
       else{

         echo json_encode($array);
       }
    }

//se invece viene premuto il tasto ricerca tutti utenti
else{
  if(isset($_POST['tutti_utenti'])){

   $array[]=NULL;
   $i=0;
   $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $utenti_cercati=$_POST['tutti_utenti'];
        $query="SELECT name, surname, username, propic from users where username<>'$username_corrente'";
         
       
        $result=mysqli_query($conn, $query);

        while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
          
        
         $utente2=$row['username'];
         $array[$i]=$row;
        
         $query2="SELECT utente, follower from follow where utente='$username_corrente' and follower='$utente2'";
         $result2=mysqli_query($conn, $query2);
         $row=mysqli_num_rows($result2);

     if($row>0){
//inserisce nell'array che ho
    $array[$i]=array_merge($array[$i], array("following"=>"yes"));
    
    
     }

     else{

       $array[$i]=array_merge($array[$i], array("folllowing"=>"no"));

     }


      
      $i++;
    }
   
    if($array==NULL)
    {
           echo 0;

    }
     //altrimenti mandami la risposta in json
    else{

      echo json_encode($array);
    }


  }
}

    
if(isset($_POST['utenteseguito'])){

  $utente2=$_POST['utenteseguito'];
  

  $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
   
  // Si attiva il trigger che aumenta il numero di followers;
  // Si attiva il trigger che aumenta il numero di following;
  //inserisci i valori all'interno del database.
    $segui="INSERT into follow(utente, follower) VALUES ('$username_corrente', '$utente2')"; 
    $result_segui=mysqli_query($conn, $segui) or die("Errore ".mysqli_error($conn));
  
    if($result_segui==true){
  
     echo '1';
  
  
    }
    else{
           echo '0';
    }
  
  
  }
  //se viene premuto il tasto non segui formdata 
  if(isset($_POST['utentenonseguito'])){
  

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $utente2=$_POST['utentenonseguito'];
    // Si attiva il trigger che diminuisce il numero di followers;
    // Si attiva il trigger che diminuisce il numero di following;
    //togli i valori nel database.
    $nonsegui="DELETE from follow where utente='$username_corrente' and follower='$utente2'";
    //controllo la query
   $resultnonsegui=mysqli_query($conn, $nonsegui) or die("Errore ".mysqli_error($conn));
  if($resultnonsegui==true){
    echo '1';
  
  }
  else{
    echo '0';
  
  }
  }
  
  mysqli_close($conn);

  ?>
  


       
       
