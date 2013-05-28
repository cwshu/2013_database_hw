<?php
include_once "./db_connect.php";
include_once "./base.php";
include_once "./model/search.php";
include_once "./model/delete.php";

function _preinfo(){
    session_start();   
    if(!isset($_SESSION["uid"])) return false;
    if(!isset($_POST["friend_id"]) || !$_POST["friend_id"] == "") return false;
    return true;
}

function delete_friend_control(){
    if(_preinfo()) 
        return "valid way to go this page";

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();

    $friend_id = mysqli_real_escape_string($con, $_POST["friend_id"]);
    if(!is_friend($_SESSION["uid"], $friend_id))
        return $friend_id." isn't your friend";

    if(!delete_friend($_SESSION["uid"], $friend_id))
        return "delete ".$friend_id." failed";

    return "delete success";
}

    echo delete_friend_control().redirect("./main.php");
?>
