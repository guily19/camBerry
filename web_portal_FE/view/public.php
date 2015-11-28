<?php

	session_start();
	include('db_access.php'); 
	// The request is a JSON request.
	// We must read the input.
	// $_POST or $_GET will not work!

	$data = file_get_contents("php://input");

	//$username = json_decode($data);
	if(isset($_SESSION['USER'])) {
		$username = $_SESSION['USER'];
  	} else {
  		header("Location: index.php");
  	}
  	foreach($_POST['cameras'] as $camera){
    
  		$id = $camera;
  		
  	  $query = "UPDATE Cameras SET public = 1 WHERE id='".$id."'";

  		error_log("query = ".$query);

  		$reg = mysql_query($query);

  		if($reg) {
            echo "La camara ha sido añadida correctamente $query";
            //header ("Location: main.php");
        }else {
            echo "ha ocurrido un error y no se guardo la camara $query";
        }
  	}

?>