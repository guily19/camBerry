<!-- This file will return de cameras of an user and the public cameras depending the http req -->

<?php
   /*
   * Collect all Details from Angular HTTP Request.
   */ 
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    // @$email = $request->email;
    // @$pass = $request->pass;
    echo $request;
    // echo $email; //this will go back under "data" of angular call.
    /*
     * You can use $email and $pass for further work. Such as Database calls.
    */    
?>