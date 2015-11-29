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

	$ssql = "SELECT img, site, video, public FROM Cameras WHERE owner='" . $username ."'";
	$res = mysql_query($ssql);

	if (empty($res)) {
		error_log('NO MATCHES ON SQL QUERY',0);
	} else {

		//$cameras = "[{}]";
		//$cameras_json = json_decode($cameras, true);
		$cameras_json = array();

		while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
			$check= " ";
			if($row['public'] == 1) $check = "checked";
			$current_camera = array(
				'img' => $row['img'],
				'site' => $row['site'],
				'video' => $row['video'],
				'public' => $row['public'],
				'check' => $check
			);

			array_push($cameras_json, $current_camera);
		}

		error_log("FOREACH",0);
		foreach($cameras_json as $item):;
			error_log($item['img'],0);
			error_log($item['site'],0);
 		endforeach;

		//$json_data = json_encode($cameras_json);
		error_log('----------',0);
		$result = print_r($cameras_json, true);
		error_log($result, 0);


		echo json_encode($cameras_json);

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