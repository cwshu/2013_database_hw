<?php
function db_connection(){
    $db_host = "localhost";
    $db_user = "dbuser";
    $db_pwd  = "dbuser";
    $db_name = "db_pj2";
    $con = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
    return $con;
}

    /* how to use
    // connect db
    $con = db_connection();
    if(mysqli_connect_errno($con)){
        echo "Fail to connect to MySQL: ".mysqli_connect_error();
    }
    */
?>
