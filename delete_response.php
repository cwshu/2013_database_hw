<?php
include_once "./db_connect.php";
include_once "./base.php";
include_once "./model/search.php";
include_once "./model/delete.php";

function preinfo(){
    session_start();
    if(!isset($_POST["postid"])) return false;
    if(!isset($_POST["r_postid"])) return false;
    if(!isset($_SESSION["uid"])) return false;
    return true;
}
function delete_response_control(){
    if(!preinfo()) 
        return "valid way to this page";

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();

    $postid = mysqli_real_escape_string($con, $_POST["postid"]);
    $r_postid = mysqli_real_escape_string($con, $_POST["r_postid"]);
    if(!is_response_exist($postid, $r_postid)) 
        return "this response doesn't exist";
    if($_SESSION["uid"] != get_uid_of_response($postid, $r_postid))
        return "This isn't your response";
    if(!delete_response($postid, $r_postid)) 
        return "delete article failed";

    return "delete success";
}

echo delete_response_control().redirect("./main.php");
?>
