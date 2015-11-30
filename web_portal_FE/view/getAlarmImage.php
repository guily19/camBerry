<?php
	// The request is a JSON request.
	// We must read the input.
	// $_POST or $_GET will not work!
	session_start();

	$data = file_get_contents("php://input");

	error_log("Alarm.php------------------------------------------------",0);

	$username = $_SESSION["USER"];
	error_log($username);

	if(!empty($_GET["img"])){
		header('Content-type: image/jpg');
		readfile($_GET["img"]);
	} else {
		error_log("No image path param to get Image");
	}

?>