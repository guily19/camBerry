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
            header("Location: register.php");
        }elseif(empty($_POST['user'])) { // comprobamos que el campo usuario_nombre no esté vacío
            header("Location: register.pgp");
        }elseif(empty($_POST['psw']) || empty($_POST['psw2'])) { // comprobamos que el campo usuario_clave no esté vacío
            header("Location: register.php");
        }elseif($_POST['psw'] != $_POST['psw2']) { // comprobamos que las contraseñas ingresadas coincidan
            header("Location: register.php");
        }elseif(!valida_email($_POST['email'])) { // validamos que el email ingresado sea correcto
            header("Location: register.php");
        }else {
            // "limpiamos" los campos del formulario de posibles códigos maliciosos
            $user = mysql_real_escape_string($_POST['user']);
            $psw = mysql_real_escape_string($_POST['psw']);
            $psw2 = mysql_real_escape_string($_POST['psw2']);
            $email = mysql_real_escape_string($_POST['email']);
            $firstname = mysql_real_escape_string($_POST['firstname']);
	        $lastname = mysql_real_escape_string($_POST['lastname']);

            // comprobamos que el usuario ingresado no haya sido registrado antes
            $sql = mysql_query("SELECT USER FROM Users WHERE USER='".$user."'");
            $sql2 = mysql_query("SELECT MAIL FROM Users WHERE MAIL='".$email."'");
            if(mysql_num_rows($sql) > 0) {
                echo "<h1><b> Error al registrar usuario </b></h1><br>";
                echo "<h3>El nombre de usuario ya ha sido registrado anteriormente. <a href='javascript:history.back();'>Reintentar</a>";
                echo "<center><br><hr><h3><br>Ir a <b><a href='index.php'>Inicio</a></b></h3></center>";
            }
            else if(mysql_num_rows($sql2) > 0) {
                echo "Este email ya ha sido registrado anteriormente. <a href='javascript:history.back();'>Reintentar</a>";
            }
            else {
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
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

    <script language="javascript">
        function validateUsername() {
            var inputUsername = document.getElementById("inputUser3").value;
            if (/\s/.test(inputUsername)) {
                document.getElementById("usernameErrorMsg").innerHTML = "El usuario no puede contener espacios.";
            } else {
                document.getElementById("usernameErrorMsg").innerHTML = "";
            }
        }

        function validatePassword() {
            var firstPass = document.getElementById("inputPassword3").value;
            var secondPass = document.getElementById("inputPassword4").value;

            if (firstPass != secondPass) {
                document.getElementById("passwordErrorMsg").innerHTML = "Las contrase&ntilde;as no coinciden.";
            } else {
                document.getElementById("passwordErrorMsg").innerHTML = "";
            }
        }

        function validateEmail() {
            var mail = document.getElementById("inputEmail3").value;

            if (/^[A-Za-z0-9-_.+%]+@[A-Za-z0-9-.]+\.[A-Za-z]{2,4}$/.test(mail)) {
                document.getElementById("emailErrorMsg").innerHTML = "";
            } else {
                document.getElementById("emailErrorMsg").innerHTML = "Formato de mail incorrecto.   ";
            }
        }      

    </script>



</head>
<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container ProductImage">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">CamBerry</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <form action="index.php" method="POST" class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" name="Email"  class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" name= "password"  class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>



<div class="main_content">
    <h1 class="title">Registration Form</h1>
    <br><br>
	<div class="form_wrapper">
        <div>
    		<form  class="form-horizontal" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">User:</label>
                    <div class="col-sm-5">
                        <input type="text" class="input form-control" name="user" id="inputUser3" placeholder="User" onchange="validateUsername()" required>
                        <font color="red"><label id="usernameErrorMsg"></label></font>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">First Name:</label>
                    <div class="col-sm-5">
                        <input type="text" class="input form-control" name="firstname" id="inputUser3" placeholder="First Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">Last Name:</label>
                    <div class="col-sm-5">
                        <input type="text" class="input form-control" name="lastname" id="inputUser3" placeholder="Last Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Email:</label>
                    <div class="col-sm-5">
                        <input type="email" class="input form-control" name="email"id="inputEmail3" placeholder="Email" onchange="validateEmail()" required>
                        <font color="red"><label id="emailErrorMsg"></label></font>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">Password:</label>
                    <div class="col-sm-5">
                        <input type="password" class="input form-control" name="psw"id="inputPassword3" placeholder="Password" onchange="validatePassword()" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">Repeat Password:</label>
                    <div class="col-sm-5">
                        <input type="password" class="input form-control" name="psw2"id="inputPassword4" placeholder="Password" onchange="validatePassword()" required>
                        <font color="red"><label id="passwordErrorMsg"></label></font>
                    </div>
                </div>
                 <br><br>
                 <button class="btn btn-success" type ="submit" name="enviar" value="Register">Register </button>
		    </form>
        </div>
	</div>
</div>
<div class="footer"></div>
</body>
</html>
<?php
}
?>
