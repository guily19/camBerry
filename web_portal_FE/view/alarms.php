<?php
	// The request is a JSON request.
	// We must read the input.
	// $_POST or $_GET will not work!

	$data = file_get_contents("php://input");

	error_log("Alarm.php------------------------------------------------",0);

	$username = $_SESSION["USER"];

	error_log("username : ".$username);

	$dir = "tmp/".$username;

	$files = scandir($dir);

	if(sizeof($files) === 0){
		$response = "No files";
		echo json_encode($response);
	} else {
		$response = sizeof($files)." files";
		echo json_encode($response);
		
	}

?>