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

	$ssql = "SELECT owner, img, site, video FROM Cameras WHERE owner!='" . $username ."' AND Cameras.public=1 ORDER BY Cameras.owner";
	$res = mysql_query($ssql);

	if (empty($res)) {
		error_log('NO MATCHES ON SQL QUERY',0);
	} else {

		//$cameras = "[{}]";
		//$cameras_json = json_decode($cameras, true);
		$cameras_json = array();
		$first_loop = 1;
		$last_user = "";
		$lastRow = mysql_num_rows($res);
		$counter = 0;

		while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
			++$counter;
			$current_user = $row['owner'];
			if ($current_user != $last_user) {

				if ($first_loop != 1) {
					array_push($cameras_json,$user_array);
				} else {
					$first_loop = 0;
				}

				$user_array = array(
					'user' => $current_user,
					'cameras' => array()
				);
				$last_user = $current_user;
			}
			$current_camera = array(
				'img' => $row['img'],
				'site' => $row['site'],
				'video' => $row['video'],
				'show' => false
			);
			array_push($user_array['cameras'],$current_camera);
			if ($counter == $lastRow) {
				array_push($cameras_json,$user_array);
			}

		}



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