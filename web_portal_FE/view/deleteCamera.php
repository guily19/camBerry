<?php

  session_start();
  include('db_access.php'); 
  // The request is a JSON request.
  // We must read the input.
  // $_POST or $_GET will not work!

  //$data = file_get_contents("php://input");

  //$username = json_decode($data);
  if(isset($_SESSION['USER'])) {
    $username = $_SESSION['USER'];
    } else {
      header("Location: index.php");
    }

    if($_POST["cams"]){
      $cams = $_POST["cams"];
      foreach ($cams as $site){
        $query = "DELETE FROM Cameras WHERE owner= '".$username."' AND site='".$site."'";
     
        $reg = mysql_query($query);
      }
    } //TODO
      //error_log("check that the params are correct");
      //Add camera
    //while ($id = mysql_fetch_assoc($cameras)) {
  //  $query = "UPDATE Cameras SET public = 1 WHERE id='".$id."'";

  //  error_log("query = ".$query);
     
  //  $reg = mysql_query($query);
  //}
  
      if($reg) {
            echo "Camara Borrada";
            header ("Location: main.php");
        }else {
            echo "ha ocurrido un error y no se ha borrado la camara $query";
        }

?>