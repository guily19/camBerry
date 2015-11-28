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

    $result = mysql_query("SELECT id FROM Cameras WHERE owner ='".$username."'");
  
    $max = mysql_num_rows($result);
    for($i = 0; $i < $max;$i++)
    {
    $id = mysql_fetch_object($result)->id;  
    $query = "UPDATE Cameras SET public = 1 WHERE id='".$id."'";
    $reg = mysql_query($query);
    }
    $total = 0;
    if(!empty($_POST["cams"])){

      $cams = $_POST["cams"];
      foreach ($cams as $cam){
      $total = $total + $cam;  
      }
    }
      //TODO
      //error_log("check that the params are correct");
      //Add camera
      error_log("There are all params to save camera");
  	//while ($id = mysql_fetch_assoc($cameras)) {

  //	$query = "UPDATE Cameras SET public = 1 WHERE id='".$id."'";

  //  error_log("query = ".$query);
     
  //	$reg = mysql_query($query);
  //}
  
  		if($reg) {
            echo "La camara ha sido añadida correctamente $query /// $total";
            //header ("Location: main.php");
        }else {
            echo "ha ocurrido un error y no se guardo la camara $query";
        }

?>