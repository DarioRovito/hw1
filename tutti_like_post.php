<?php

require_once 'check-up.php';
 if (!$userid=check_up()) {
    header('Location: login.php');
    exit;
}


$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

$userid = mysqli_real_escape_string($conn, $userid);



$id_post=$_POST['like_post'];


  $array[]=NULL;
  $i=0;
if(isset($_POST['like_post'])){
   $id_post=$_POST['like_post'];
   //selezione tutte le persone che hanno messo like a quel post
   $query="SELECT users.username, users.propic, likes.post FROM users JOIN likes ON likes.user=users.id WHERE likes.post='$id_post' ";


$result=mysqli_query($conn, $query);
  //itera i risultati trovati nella query e li trasforma in array 
  while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
{
   $array[$i]=$row;
   $i++;
}
 
if($array==NULL){
            
 echo 0;
}
else{

 echo json_encode($array);


}

}

mysqli_close($conn);

?>





