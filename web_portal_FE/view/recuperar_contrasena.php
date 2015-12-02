<?php
    include('db_access.php'); // incluímos los datos de acceso a la BD
?>
<!doctype html>
    <?php
        if(isset($_POST['enviar'])) { // comprobamos que se han enviado los datos del formulario
            if(empty($_POST['user'])) {
                echo "No ha ingresado el usuario. <a href='javascript:history.back();'>Reintentar</a>";
            }else {
                $user = mysql_real_escape_string($_POST['user']);
                $user = trim($user);
                $sql = mysql_query("SELECT USER, PASSWORD, MAIL FROM Users WHERE USER='".$user."'");
                if(mysql_num_rows($sql)) {
                    $row = mysql_fetch_assoc($sql);
                    $num_caracteres = "10"; // asignamos el número de caracteres que va a tener la nueva contraseña
                    $nueva_clave = substr(md5(rand()),0,$num_caracteres); // generamos una nueva contraseña de forma aleatoria
                    $user = $row['USER'];
                    $psw= $nueva_clave; // la nueva contraseña que se enviará por correo al usuario
                    $psw2 = md5($psw); // encriptamos la nueva contraseña para guardarla en la BD
                    $email = $row['MAIL'];
                    // actualizamos los datos (contraseña) del usuario que solicitó su contraseña
                    mysql_query("UPDATE Users SET PASSWORD='".$psw2."' WHERE USER='".$user."'");
                    // Enviamos por email la nueva contraseña
                    $remite_nombre = "Camberry Project"; // Tu nombre o el de tu página
                    $remite_email = "noreply@camberry.es"; // tu correo
                    $asunto = "Recuperación de contraseña"; // Asunto (se puede cambiar)
                    $mensaje = "Se ha generado una nueva contraseña para el usuario <strong>".$user."</strong>. La nueva contraseña es: <strong>".$psw."</strong>.";
                    $cabeceras = "From: ".$remite_nombre." <".$remite_email.">\r\n";
                    $cabeceras = $cabeceras."Mime-Version: 1.0\n";
                    $cabeceras = $cabeceras."Content-Type: text/html";
                    $enviar_email = mail($email,$asunto,$mensaje,$cabeceras);
                    if($enviar_email) {
                       echo "<h1><b> Recuperacion Completada </b></h1><br>";
                       echo "<h3>Contrasena reestablecida correctamente. Acceda a <b><a href='index.php'>Camberry!</a></b></h3>";
                       echo "<center><br><hr><h3><br>Ir a <b><a href='index.php'>Inicio</a></b></h3></center>";
                    }else {
                        echo "No se ha podido enviar el email. <a href='javascript:history.back();'>Reintentar</a>";
                    }
                }else {
                    echo "El usuario <strong>".$user."</strong> no está registrado. <a href='javascript:history.back();'>Reintentar</a>";
                }
            }
        }else {
    ?>
<head>
    <title> Password Recovery </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
<div class="main_content">
    <h1 class="title">Recuperación de contraseña</h1>
    <br><br>
    <div class="form_wrapper">
        <div>
            <form  class="form-horizontal" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">USUARIO: </label>
                    <div class="col-sm-5">
                        <input type="text" class="input form-control" name="user" id="inputUser3" placeholder="User" onchange="validateUsername()" required>
                        <font color="red"><label id="usernameErrorMsg"></label></font>
                    </div>
                </div>
                 <br><br>
                 <button class="btn btn-success" type ="submit" name="enviar" value="Recover">Recuperar</button>
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
