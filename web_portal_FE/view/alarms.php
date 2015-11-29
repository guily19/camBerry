<?php
	// The request is a JSON request.
	// We must read the input.
	// $_POST or $_GET will not work!
	session_start();

	$data = file_get_contents("php://input");

	error_log("Alarm.php------------------------------------------------",0);

	$username = $_SESSION["USER"];
	error_log($username);

	$dir = "/var/motion/".$username;

	$files = scandir($dir);
	error_log("Files->".json_encode($files));

	if($files === false){
		echo undefined;
	} else {
		//Netegem el array files perque no mostri . i ..
		$response = [];

		for ($i=0; $i < sizeof($files); $i++) { 
			# code...
			if($files[$i] === "." || $files[$i] === ".."){
				unset($files[$i]);
			}
		}
		//Re-indexamos el array una vez eliminados los elementos no deseados.
		$files = array_values($files);

		for ($i=0; $i < sizeof($files); $i++) { 
			# code...
			header('Content-type: image/jpg');
			$file = $dir."/".$files[$i];
			error_log("File ->".$file);
			$read = readfile($file);
			error_log("Read ->".$read);
			echo $file;
			array_push($response, $file);
			// error_log("Files-".$i."=".$files[$i]);
		}
		header('Content-type: image/jpg');
		echo json_encode($response);
		
	}

?>