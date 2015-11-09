<?php
include('db_access.php');
 if(isset($_POST['enviar'])) { // comprobamos que se han enviado los datos desde el formulario
        // creamos una función que nos parmita validar el email
        function valida_email($email) {
            if (preg_match('/^[A-Za-z0-9-_.+%]+@[A-Za-z0-9-.]+\.[A-Za-z]{2,4}$/', $email)) return true;
            else return false;
        }
        // Procedemos a comprobar que los campos del formulario no estén vacíos
        $sin_espacios = count_chars($_POST['user'], 1);
        if(!empty($sin_espacios[32])) { // comprobamos que el campo usuario_nombre no tenga espacios en blanco
            echo "El campo <em>usuario_nombre</em> no debe contener espacios en blanco. <a href='javascript:history.back();'>Reintentar</a>";
        }elseif(empty($_POST['user'])) { // comprobamos que el campo usuario_nombre no esté vacío
            echo "No haz ingresado tu usuario. <a href='javascript:history.back();'>Reintentar</a>";
        }elseif(empty($_POST['psw'])) { // comprobamos que el campo usuario_clave no esté vacío
            echo "No haz ingresado contraseña. <a href='javascript:history.back();'>Reintentar</a>";
        }elseif($_POST['psw'] != $_POST['psw2']) { // comprobamos que las contraseñas ingresadas coincidan
            echo "Las contraseñas ingresadas no coinciden. <a href='javascript:history.back();'>Reintentar</a>";
        }elseif(!valida_email($_POST['email'])) { // validamos que el email ingresado sea correcto
            echo "El email ingresado no es válido. <a href='javascript:history.back();'>Reintentar</a>";
        }else {
            // "limpiamos" los campos del formulario de posibles códigos maliciosos
            $user = mysql_real_escape_string($_POST['user']);
            $psw = mysql_real_escape_string($_POST['psw']);
            $email = mysql_real_escape_string($_POST['email']);
            $firstname = mysql_real_escape_string($_POST['firstname']);
	    $lastname = mysql_real_escape_string($_POST['lastname']);

            // comprobamos que el usuario ingresado no haya sido registrado antes
            $sql = mysql_query("SELECT USER FROM Users WHERE USER='".$user."'");
            if(mysql_num_rows($sql) > 0) {
                echo "El nombre usuario elegido ya ha sido registrado anteriormente. <a href='javascript:history.back();'>Reintentar</a>";
            }else {
                $psw = md5($psw); // encriptamos la contraseña ingresada con md5
                // ingresamos los datos a la BD
                $reg = mysql_query("INSERT INTO Users (USER, PASSWORD ,MAIL, NOMBRE, APELLIDOS) VALUES ('".$user."', '".$psw."', '".$email."','".$firstname."','".$lastname."')");
                if($reg) {
                    echo "Datos ingresados correctamente.";
                }else {
                    echo "ha ocurrido un error y no se registraron los datos.";
                }
            }
        }
    }else {
?>
<html>
<head>
	<title> Main Portal</title>
    <link rel="stylesheet" type="text/css" href="/css/register.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
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
        <form class="navbar-form navbar-right">
            <button ng-class="videoMode ? 'btn btn-danger' : 'btn btn-success' " ng-click="viewControll()" ng-show="someVideoisShown">{{videoModeButtonText}}</button>
            <button type="submit" class="btn btn-success">Log out</button>
        </form>
    </div>
</nav>
<div class="main_content">
	<div class="form_wrapper">
		<form  class="form-horizontal"action="<?=$_SERVER['PHP_SELF']?>" method="post">

            <div class="form-group">
                <label for="inputUser3" class="col-sm-2 control-label">User:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="user "id="inputUser3" placeholder="User">
                </div>
            </div>
            <div class="form-group">
                <label for="inputUser3" class="col-sm-2 control-label">First Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="firstname" id="inputUser3" placeholder="First Name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputUser3" class="col-sm-2 control-label">Last Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="lastname" id="inputUser3" placeholder="Last Name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Email:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="user "id="inputEmail3" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="inputUser3" class="col-sm-2 control-label">Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="user "id="inputPassword3" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="inputUser3" class="col-sm-2 control-label">Repeat Password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="user "id="inputPassword3" placeholder="Password">
                </div>
            </div>
<!-- 		        First name:<br>
  			<input class="form-text" type="text" name="firstname"> <br>
  			Last name:<br>
  			<input class="form-text" type="text" name="lastname"> <br>
  			E-mail:<br>
  			<input class="form-text" type="email" name="email"> <br>
  			Password:<br>
  			<input class="form-text" type="password" name="psw"> <br>
  			Repeat Password:<br>
  			<input class="form-text" type="password" name="psw2"> <br>
  			<input type ="submit" name="enviar" value="Register"/> -->
		</form>
	</div>
</div>
<div class="footer"></div>
</body>
</html>
<?php
}
?>
