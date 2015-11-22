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

	if (empty($res)) {
		error_log('NO MATCHES ON SQL QUERY',0);
	} else {

		$cameras = "[{}]";
		$cameras_json = json_decode($cameras, true);

		while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {

			$imgstr = $row['img'];
			$sitestr = $row['site'];
			$videostr = $row['video'];
			error_log($imgstr,0);
			error_log($sitestr,0);
			error_log($videostr,0);
			$current_camera = array(
				'img' => $imgstr,
				'site' => $sitestr,
				'video' => $videostr,
			);

			array_push($current_camera, $cameras_json);
		}

		//$json_data = json_encode($cameras_json);
		error_log('----------',0);
		$prueba = "" . $cameras_json;
		error_log($prueba, 0);

	}




	//Poner la respuesta de la base de datos en en JSON con los siguientes parametros:
	//imagen, String con el sitio donde esta la camara, link del Video

	

	//$files = scandir($dir);

	//if(sizeof($files) === 0){
	//	$response = "No files";
	//	echo json_encode($response);
	//} else {
	//	$response = sizeof($files)." files";
	//	echo json_encode($response);
		
	//}

?>