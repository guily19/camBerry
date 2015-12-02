<?php
    session_start();
    include('db_access.php'); // incluímos los datos de conexión a la BD

    if(isset($_SESSION['USER'])) {
    $username = $_SESSION['USER'];
    } else {
        header("Location: index.php");
    }
        $perfil = mysql_query("SELECT * FROM Users WHERE USER='".$username."'") or die(mysql_error());
        if(mysql_num_rows($perfil)) { 
            $row = mysql_fetch_array($perfil);
            $id = $row["ID"];
            $nick = $row["USER"];
            $name = $row["NOMBRE"];
            $surname = $row["APELLIDOS"];
            $email = $row["MAIL"];
    
            if(isset($_POST['enviar'])) {
                if($_POST['psw'] != $_POST['psw2']) {
                    echo "Las contraseñas ingresadas no coinciden. <a href='javascript:history.back();'>Reintentar</a>";
                }else {
                    $user = $_SESSION['USER'];
                    $psw = mysql_real_escape_string($_POST["psw"]);
                    $psw = md5($psw); 
                    $sql = mysql_query("UPDATE Users SET PASSWORD='".$psw."' WHERE USER='".$user."'");
                    if($sql) {
                       echo "<h1><b> Cambio completado </b></h1><br>";
                       echo "<h3>Contraseña cambiada correctamente. Volver a <b><a href='main.php'>Camberry!</a></b></h3>";
                       echo "<center><br><hr><h3><br>Ir a <b><a href='index.php'>Inicio</a></b></h3></center>";
                    }else {
                        echo "Error: No se pudo cambiar la contraseña. <a href='javascript:history.back();'>Reintentar</a>";
                    }
                }
            }else {
    ?>
    <html>
<head>
    <title> About me</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

    <script language="javascript">
        
        function validatePassword() {
            var firstPass = document.getElementById("inputPassword3").value;
            var secondPass = document.getElementById("inputPassword4").value;

            if (firstPass != secondPass) {
                document.getElementById("passwordErrorMsg").innerHTML = "Las contrase&ntilde;as no coinciden.";
            } else {
                document.getElementById("passwordErrorMsg").innerHTML = "";
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
          <a class="navbar-brand" href="main.php">CamBerry</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        </div><!--/.navbar-collapse -->
      </div>
    </nav>



<div class="main_content">
    <h1 class="title">Sobre mi</h1>
    <br><br>
    <div class="form_wrapper">
        <div>
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">ID: <?=$id?></label>
                </div>
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">Usuario: <?=$nick?></label>
                </div>
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">Nombre: <?=$name?></label>
                </div>
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">Apellidos: <?=$surname?></label>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Email: <?=$email?></label>
                </div>
                 <br><br>
        </div>
    </div>
</div>
<div class="form_wrapper">
     <h1 class="title">Cambiar contraseña</h1>
        <div>
            <form  class="form-horizontal" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">Nueva contraseña:</label>
                    <div class="col-sm-5">
                        <input type="password" class="input form-control" name="psw"id="inputPassword3" placeholder="Password" onchange="validatePassword()" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUser3" class="col-sm-4 control-label">Repita la nueva contraseña:</label>
                    <div class="col-sm-5">
                        <input type="password" class="input form-control" name="psw2"id="inputPassword4" placeholder="Password" onchange="validatePassword()" required>
                        <font color="red"><label id="passwordErrorMsg"></label></font>
                    </div>
                </div>
                 <br><br>
                 <button class="btn btn-success" type ="submit" name="enviar" value="Register">Actualizar </button>
            </form>
        </div>
    </div>
<div class="footer"></div>
</body>
</html>
    <?php
            }
        }else {
            echo "Acceso denegado.";
        }
    ?> 
