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

	//configuracionn con la BD

	//query SQL

	$ssql = "SELECT img, site, video FROM Cameras WHERE owner='" . $username ."'";
    $res = mysql_query($ssql);

    error_log($res,0);
    error_log('bduigwiudgwuidw',0);

    $result = json_encode($res);
    error_log($result,0);

    $result2 = json_decode($res);
    error_log($result2,0);




	//Poner la respuesta de la base de datos en en JSON con los siguientes parametros:
	//imagen, String con el sitio donde esta la camara, link del Video

	

	$files = scandir($dir);

	if(sizeof($files) === 0){
		$response = "No files";
		echo json_encode($response);
	} else {
		$response = sizeof($files)." files";
		echo json_encode($response);
		
	}

?>