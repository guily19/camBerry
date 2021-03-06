<?php

session_start();
include('db_access.php'); 

//primero tengo que ver si el usuario está memorizado en una cookie
if (isset($_COOKIE["id_usuario_dw"]) && isset($_COOKIE["marca_aleatoria_usuario_dw"])){
   //Tengo cookies memorizadas
   //además voy a comprobar que esas variables no estén vacías
   if ($_COOKIE["id_usuario_dw"]!="" || $_COOKIE["marca_aleatoria_usuario_dw"]!=""){
      //Voy a ver si corresponden con algún usuario

      $userCookie = mysql_real_escape_string($_COOKIE["id_usuario_dw"]);
      $markCookie = mysql_real_escape_string($_COOKIE["marca_aleatoria_usuario_dw"]);

      $ssql = "select * from Users where USER='" . $userCookie . "' and COOKIE='" . $markCookie . "'";
      $rs = mysql_query($ssql);
      if (mysql_num_rows($rs)==1){
         //echo "<b>Tengo un usuario correcto en una cookie</b>";
         $usuario_encontrado = mysql_fetch_object($rs);
         //echo "<br>Eres el usuario número " . $usuario_encontrado->USER . ", de nombre " . $usuario_encontrado->usuario;
         header ("Location: main.php");
      }
   }
}
 
if ($_POST){
	if(empty($_POST['Email']) || empty($_POST['password'])) {
            //echo "El usuario o la contraseña no han sido ingresados. <a href='javascript:history.back();'>Reintentar</a>";
            header("Location: index.php");
    }else {
		   $Email = mysql_real_escape_string($_POST['Email']);
		   $password = mysql_real_escape_string($_POST["password"]);
		   $password = md5($password);
		   //es que estamos recibiendo datos por el formulario de autenticación (recibo de $_POST)

		   //debería comprobar si el usuario es correcto
		   $ssql = "select * from Users where MAIL = '" . $Email . "' and PASSWORD='" . $password . "'";
		   //echo $ssql;
		   $rs = mysql_query($ssql);
		   if($row = mysql_fetch_array($rs)) {
				//TODO CORRECTO!! He detectado un usuario
				$usuario_encontrado = mysql_fetch_object($rs);
				$_SESSION['ID'] = $row['ID']; // creamos la sesion "usuario_id" y le asignamos como valor el campo usuario_id
				$_SESSION['USER'] = $row["USER"]; // creamos la sesion "usuario_nombre" y le asignamos como valor el campo usuario_nombre
				//ahora debo de ver si el usuario quería memorizar su cuenta en este ordenador
				
				//es que pidió memorizar el usuario
				//1) creo una marca aleatoria en el registro de este usuario
				//alimentamos el generador de aleatorios
				mt_srand (time());
				//generamos un número aleatorio
				$numero_aleatorio = mt_rand(1000000,999999999);
				//2) meto la marca aleatoria en la tabla de usuario
				$ssql = "update Users set COOKIE='$numero_aleatorio' where MAIL='" . $Email . "'";
				mysql_query($ssql);
				//3) ahora meto una cookie en el ordenador del usuario con el identificador del usuario y la cookie aleatoria
				setcookie("id_usuario_dw", $usuario_encontrado->USER , time()+(60*60*24*365));
				setcookie("marca_aleatoria_usuario_dw", $numero_aleatorio, time()+(60*60*24*365));
				//echo "Autenticado correctamente";
				header ("Location: main.php");
			}else{
				//echo "Fallo de autenticación!";
				//echo "<p><a href='index.php'>Volver</a>";
				//echo "<p>$rs es la sortida de query, $ssql la consulta, connexio $conn";
        header("Location: index.php");
			}
   
		}
	}
else{
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Camberry Project </title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

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
        <div id="navbar" class="navbar-collapse collapse">
          <form action="index.php" method="POST" class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" name="Email"  class="form-control" required>
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" name= "password"  class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Entrar</button>
            <button type="button" class="btn btn-danger"  onclick = "location='/recuperar_contrasena.php'" >Olvidó su contraseña?</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h2>Bienvenido al proyecto CamBerry</h2>
        <p>El sistema de seguridad para tu hogar y tu empresa más simple de instalar, más facil de obtener y con el mejor servicio de atención del momento.</p>
        <p><a class="btn btn-primary btn-lg" href="buykit.html" role="button">Más información &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Pack Camberry</h2>
          <p>Compra tu Kit camberry para tener el mejor servicio de vigilancia al mejor precio. Te ofrecemos un sistema economico, simple y ...... </p>
          <p><a class="btn btn-default" href="buykit.html" role="button">Compra tu Kit! &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Regístrate</h2>
          <p>Regístrate para poder acceder a las cámaras publicas de nuestro sistema y poder ver de forma totalmente privada tus cámaras privadas </p>
          <p><a class="btn btn-default" href="register.php" role="button">Regístrate &raquo;</a></p>
       </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Camberry Project 2015</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
<?php
}
?>
