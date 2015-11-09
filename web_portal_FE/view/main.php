<?php
$conn = mysql_connect("localhost","root","S539CW7LjXk_v7A");

mysql_select_db("CamberryDB",$conn); 

//primero tengo que ver si el usuario está memorizado en una cookie
if (isset($_COOKIE["id_usuario_dw"]) && isset($_COOKIE["marca_aleatoria_usuario_dw"])){
   //Tengo cookies memorizadas
   //además voy a comprobar que esas variables no estén vacías
   if ($_COOKIE["id_usuario_dw"]!="" || $_COOKIE["marca_aleatoria_usuario_dw"]!=""){
      //Voy a ver si corresponden con algún usuario
      $ssql = "select * from Users where USER='" . $_COOKIE["id_usuario_dw"] . "' and COOKIE='" . $_COOKIE["marca_aleatoria_usuario_dw"] . "'";
      $rs = mysql_query($ssql);
      if (mysql_num_rows($rs)==1){
         echo "<b>Tengo un usuario correcto en una cookie</b>";
         $usuario_encontrado = mysql_fetch_object($rs);
         echo "<br>Eres el usuario número " . $usuario_encontrado->USER . ", de nombre " . $usuario_encontrado->usuario;
         header ("Location: main.html");
      }
   }
}

if ($_GET){
   //estan intentant accedir directament al ficher main.php

   //debería comprobar si el usuario es correcto
   $ssql = "select * from Users where MAIL = '" . $_POST["Email"] . "' and PASSWORD='" . $_POST["password"] . "'";
   //echo $ssql;
   $rs = mysql_query($ssql);
   if (mysql_num_rows($rs)==1){
      //TODO CORRECTO!! He detectado un usuario
      $usuario_encontrado = mysql_fetch_object($rs);
      //ahora debo de ver si el usuario quería memorizar su cuenta en este ordenador
    
         //es que pidió memorizar el usuario
         //1) creo una marca aleatoria en el registro de este usuario
         //alimentamos el generador de aleatorios
         mt_srand (time());
         //generamos un número aleatorio
         $numero_aleatorio = mt_rand(1000000,999999999);
         //2) meto la marca aleatoria en la tabla de usuario
         $ssql = "update Users set COOKIE='$numero_aleatorio' where MAIL='" . $_POST["Email"] . "'";
         mysql_query($ssql);
         //3) ahora meto una cookie en el ordenador del usuario con el identificador del usuario y la cookie aleatoria
         setcookie("id_usuario_dw", $usuario_encontrado->USER , time()+(60*60*24*365));
         setcookie("marca_aleatoria_usuario_dw", $numero_aleatorio, time()+(60*60*24*365));
     
      echo "Autenticado correctamente";
      header ("Location: main.html");
      
   }else{
      echo "Fallo de autenticación!";
      echo "<p><a href='index.php'>Volver</a>";
      echo "<p>$rs es la sortida de query, $ssql la consulta, connexio $conn";
   }
   
}else{
?>

<!DOCTYPE html>
<html>
<head>
	<title> Main Portal</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/animate.css">

	<script src="js/angular.min.js"></script>
	<script src="js/controllers.js"></script>

	<!-- Remove in server -->
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/animate.css">
	 
	 <script src="../js/angular.min.js"></script> 
	 <script src="../js/controllers.js"></script>

</head>
<body ng-app="myApp" ng-controller="MainCtrl">
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">CamBerry</a>
        </div>
        <form class="navbar-form navbar-right">
        	<button ng-class="videoMode ? 'btn btn-danger' : 'btn btn-success' " ng-click="viewControll()" ng-show="someVideoisShown">{{videoModeButtonText}}</button>
        	<button type="submit" class="btn btn-success">Log out</button>
        </form>
      </div>
    </nav>
	<div class="main_content">
		<div class="videos_wrapper">
			<div class="video_wrapper bounceInDown" ng-repeat="camera in cameras" ng-class="showVideo ? 'animated' : '' " ng-show="showVideo[$index] === true">
				<img class="close_icon" ng-src="img/icons/close.png" ng-click="closeVideo($index)">
				<img class="video" src="{{camera.video}}"></img>
				<div style="font-size: 20px; color: white;">{{camera.site}}</div>
			</div>
		</div>
		<div class="personal_cameras" ng-show="!videoMode" animated>
			<h1 class="subtitle">My Cameras</h1>
			<div class="cameras_wrapper">
				<div class="camera_content" ng-click="onClickOwnCamera($index)" ng-repeat="camera in cameras">
					<img class="camera_image" ng-src={{camera.img}}>
					<h2 class="camera_site">{{camera.site}}</h2>
				</div>
			</div>
		</div>
		<div class="videos_wrapper" ng-repeat="user in otherCameras">
			<div class="video_wrapper bounceInRight" ng-repeat="camera in user.cameras" ng-class="showVideo ? 'animated' : '' " ng-show="camera.show === true">
				<img class="close_icon" ng-src="img/icons/close.png" ng-click="closeVideoOther($parent.$index, $index)">
				<video class="video" ng-src="{{camera.video}}"></video>
				<h3 style="">{{camera.site}}</h3>
			</div>
		</div>
		<div class="others_cameras" ng-show="!videoMode" >
			<h1 class="subtitle">Other's Cameras</h1>
			<div  ng-repeat="user in otherCameras"> 
				<h3 class="other_cameras_user">{{user.user}}</h3>
				<div class="camera_content" ng-click="onClickOtherCamera($parent.$index,$index)" ng-repeat="camera in user.cameras">
					<img class="camera_image" ng-src={{camera.img}}>
					<h2 class="camera_site">{{camera.site}}</h2>
				</div>
			</div>
		</div>
	</div>
	<div class="footer"></div>
</body>
</html>

<?php
}
?>