<?php
	// The request is a JSON request.
	// We must read the input.
	// $_POST or $_GET will not work!
	session_start();

	$data = file_get_contents("php://input");

	error_log("Alarm.php------------------------------------------------",0);

	$username = $_SESSION["USER"];

	$dir = "/tmp/motion/".$username;

	$files = scandir($dir);
	error_log("Files->".$files);

	if(!$files){
		$response = "No files";
		echo json_encode($response);
	} else {
		//Netegem el array files perque no mostri . i ..
		for ($i=0; $i < sizeof($files); $i++) { 
			# code...
			if($files[$i] === "." || $files[$i] === ".."){
				unset($files[$i]);
			}
			error_log("Files-".$i."=".$files[$i]);
		}
		echo json_encode($files);
		
	}

?>