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
  	if(!empty($_POST["Video"]) || !empty($_POST["Image"]) || !empty($_POST["Site"])){
  		//Add camera
  		error_log("Adding Camera ------------------------------");
  	} 

  	error_log("Data ->",json_decode($data));

?>