<?php

	session_start();
	include('db_access.php'); 
	// The request is a JSON request.
	// We must read the input.
	// $_POST or $_GET will not work!

	error_log("Settings -----------------------------------");

	$data = file_get_contents("php://input");

	//$username = json_decode($data);
	if(isset($_SESSION['USER'])) {
		$username = $_SESSION['USER'];
  	} else {
  		header("Location: index.php");
  	}
  	if(!empty($_POST["Video"]) && !empty($_POST["Image"]) && !empty($_POST["Site"])){
  		//TODO
  		//error_log("check that the params are correct");
  		$video = $_POST["Video"];
  		$img = $_POST["Image"];
  		$site = $_POST["Site"];
  		//Add camera
  		error_log("There are all params to save camera");


  		
  		$query = "INSERT into Cameras VALUES ('".$video."', '".$img."', '".$site."')";

  		error_log("query = ".$query);

  		if($reg) {
            echo "La camara ha sido añadida correctamente";
        }else {
            echo "ha ocurrido un error y no se guardo la camara";
        }

  	} 

?>