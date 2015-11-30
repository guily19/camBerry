<?php

	session_start();
	include('db_access.php'); 
	// The request is a JSON request.
	// We must read the input.
	// $_POST or $_GET will not work!

	//$data = file_get_contents("php://input");

	//$username = json_decode($data);
	if(isset($_SESSION['USER'])) {
		$username = mysql_real_escape_string($_SESSION['USER']);
  	} else {
  		header("Location: index.php");
  }

    $result = mysql_query("SELECT id FROM Cameras WHERE owner ='".$username."'");
  
    $max = mysql_num_rows($result);
    for($i = 0; $i < $max;$i++)
    {
    $id = mysql_fetch_object($result)->id;  
    $query = "UPDATE Cameras SET public = 0 WHERE id='".$id."'";
    $reg = mysql_query($query);
    }
    if($_POST["cams"]){
      $cams = mysql_real_escape_string($_POST["cams"]);
      foreach ($cams as $site){
        $query = "UPDATE Cameras SET public = 1 WHERE owner= '".$username."' AND site='".$site."'";
        $reg = mysql_query($query);
      }
    } //TODO
      //error_log("check that the params are correct");
      //Add camera
      error_log("There are all params to save camera");
  	//while ($id = mysql_fetch_assoc($cameras)) {

  //	$query = "UPDATE Cameras SET public = 1 WHERE id='".$id."'";

  //  error_log("query = ".$query);
     
  //	$reg = mysql_query($query);
  //}
  
  		if($reg) {
          header ("Location: main.php");
      }else {
          echo "<h1><b> Error al publicar la camara</b></h1><br>";
          echo "<h3>Ha ocurrido un error y no se ha publicado la camara <a href='javascript:history.back();'>Reintentar</a>";
          echo "<center><br><hr><h3><br>Ir a <b><a href='index.php'>Inicio</a></b></h3></center>";
      }

?>