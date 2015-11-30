<?php

	session_start();
	include('db_access.php'); 
	// The request is a JSON request.
	// We must read the input.
	// $_POST or $_GET will not work!

	error_log("AddCamera -----------------------------------");
  //$user = $_SESSION['USER'];
	$data = file_get_contents("php://input");

	//$username = json_decode($data);
	if(isset($_SESSION['USER'])) {
		$username = $_SESSION['USER'];
  } else {
  	header("Location: index.php");
  }
  	
  if(!empty($_POST["Video"]) && !empty($_POST["Image"]) && !empty($_POST["Site"])){
  		//TODO
  		//error_log("check that the params are co

      $video = mysql_real_escape_string($_POST['Video']);
      $site = mysql_real_escape_string($_POST['Site']);
      $img = mysql_real_escape_string($_POST['Image']);

  		//Add camera
  		error_log("There are all params to save camera");

  		$query = "INSERT INTO Cameras (owner ,site, img, video, public)VALUES ('".$user."','".$site."','".$img."','".$video."',0)";

  		error_log("query = ".$query);

  		$reg = mysql_query($query);

  		if($reg) {
            header ("Location: main.php");
        } else {
          echo "<h1><b> Error al registrar la cámara</b></h1><br>";
          echo "<h3>Ha ocurrido un error y no se ha guardado la camara <a href='javascript:history.back();'>Reintentar</a>";
          echo "<center><br><hr><h3><br>Ir a <b><a href='index.php'>Inicio</a></b></h3></center>";
        }

  	} else {
      echo "<h1><b> Error al registrar la cámara</b></h1><br>";
      echo "<h3>Todos los campos tienen que estar llenos <a href='javascript:history.back();'>Reintentar</a>";
      echo "<center><br><hr><h3><br>Ir a <b><a href='index.php'>Inicio</a></b></h3></center>";
  	}

?>