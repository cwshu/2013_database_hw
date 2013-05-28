<?php
include_once "./db_connect.php";
include_once "./base.php";
include_once "./model/search.php";
include_once "./model/delete.php";

function delete_user_control(){
    session_start();
    if(!isset($_SESSION["uid"]))
        return "valid way to go this page";

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();

    if(!delete_user($_SESSION["uid"]))
        return "delete user failed";

    return "delete success";
}
    echo delete_user_control().redirect("./index.php");
?>
