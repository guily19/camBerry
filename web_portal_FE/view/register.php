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
	<link rel="stylesheet" type="text/css" href="/css/main.css">
</head>
<body>
<div class="header">
	<img class="logo" src="/img/logo.jpeg" style="fload:left">
	<div class="title"> Welcome to CamBerry Service Registration Form </div>
</div>
<div class="main_content">
	<div class="form_wrapper">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			User:<br>
                        <input class="form-text" type="text" name="user"> <br>
		        First name:<br>
  			<input class="form-text" type="text" name="firstname"> <br>
  			Last name:<br>
  			<input class="form-text" type="text" name="lastname"> <br>
  			E-mail:<br>
  			<input class="form-text" type="email" name="email"> <br>
  			Password:<br>
  			<input class="form-text" type="password" name="psw"> <br>
  			Repeat Password:<br>
  			<input class="form-text" type="password" name="psw2"> <br>
  			<input type ="submit" name="enviar" value="Register"/>
		</form>
	</div>
</div>
<div class="footer"></div>
</body>
</html>
<?php
}
?>
