<?php
    include('db_access.php'); // incluímos los datos de acceso a la BD
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_POST['enviar'])) { // comprobamos que se han enviado los datos del formulario
            if(empty($_POST['user'])) {
                echo "No ha ingresado el usuario. <a href='javascript:history.back();'>Reintentar</a>";
            }else {
                $user = mysql_real_escape_string($_POST['user']);
                $user = trim($user);
                $sql = mysql_query("SELECT USER, PASSWORD, MAIL FROM USERS WHERE USER='".$user."'");
                if(mysql_num_rows($sql)) {
                    $row = mysql_fetch_assoc($sql);
                    $num_caracteres = "10"; // asignamos el número de caracteres que va a tener la nueva contraseña
                    $nueva_clave = substr(md5(rand()),0,$num_caracteres); // generamos una nueva contraseña de forma aleatoria
                    $user = $row['USER'];
                    $psw= $nueva_clave; // la nueva contraseña que se enviará por correo al usuario
                    $psw2 = md5($psw); // encriptamos la nueva contraseña para guardarla en la BD
                    $email = $row['MAIL'];
                    // actualizamos los datos (contraseña) del usuario que solicitó su contraseña
                    mysql_query("UPDATE USERS SET PASSWORD='".$psw2."' WHERE user='".$user."'");
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
                        echo "La nueva contraseña ha sido enviada al email asociado al usuario ".$user.".";
                    }else {
                        echo "No se ha podido enviar el email. <a href='javascript:history.back();'>Reintentar</a>";
                    }
                }else {
                    echo "El usuario <strong>".$user."</strong> no está registrado. <a href='javascript:history.back();'>Reintentar</a>";
                }
            }
        }else {
    ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label>Usuario:</label><br />
            <input type="text" name="user" /><br />
            <input type="submit" name="enviar" value="Enviar" />
        </form>
    <?php
        }
    ?> 
</body>
</html>