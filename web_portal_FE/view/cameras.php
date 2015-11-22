<?php

	session_start();
	include('db_access.php'); 
	// The request is a JSON request.
	// We must read the input.
	// $_POST or $_GET will not work!

	$data = file_get_contents("php://input");

	$username = json_decode($data);

	//configuracionn con la BD

	//query SQL

	$ssql = "SELECT img, site, video from Users where USER='" . $username]"'";
    $res = mysql_query($ssql);


	//Poner la respuesta de la base de datos en en JSON con los siguientes parametros:
	// imagen, String con el sitio donde esta la camara, link del Video

	

	$files = scandir($dir);

	if(sizeof($files) === 0){
		$response = "No files";
		echo json_encode($response);
	} else {
		$response = sizeof($files)." files";
		echo json_encode($response);
		
	}

?>