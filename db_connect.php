<?php
function db_connection(){
    $db_host = "localhost";
    $db_user = "facenote";
    $db_pwd  = "facenote";
    $db_name = "facenote";
    $con = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
    return $con;
}

    /* how to use
    // connect db
    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con)){
        echo "Fail to connect to MySQL: ".mysqli_connect_error();
    }
    */
?>
