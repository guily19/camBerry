<?php
    //session_start();
    //include('db_access.php'); // inclu�mos los datos de acceso a la BD
    // comprobamos que se haya iniciado la sesi�n
    if(isset($_SESSION['USER'])) {
        session_destroy();
        header("Location: index.php");
    } else {
        header("Location: index.php");
    }
?>  