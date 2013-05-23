<?php
include_once "./db_connect.php";
include_once "./base.php";
include_once "./model/search.php";
include_once "./model/delete.php";

function preinfo(){
    session_start();
    if(!isset($_POST["postid"])) return false;
    if(!isset($_SESSION["uid"])) return false;
    return true;
}
function delete_article_control(){
    if(!preinfo()) return "valid way to this page";

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();

    $postid = mysqli_real_escape_string($con, $_POST["postid"]);
    if(!is_article_exist($postid)) return "this article doesn't exist";

    if($_SESSION["uid"] != get_uid_of_article($postid))
        return "This isn't your article";
    
    if(!delete_article($postid)) return "delete article failed";

    return alert_msg("delete success");
}

echo delete_article_control().redirect("./main.php");
?>
