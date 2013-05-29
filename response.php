<?php
include_once "./db_connect.php";
include_once "./base.php";
include_once "./model/insert.php";

function preinfo(){
    if(!isset($_SESSION["uid"])) return False;
    if(!isset($_POST["postid"])) return False;
    if(!isset($_POST["content"])) return False;
    return True;
}
// main
function post_response(){
    session_start();
    if(!preinfo())
        return alert_msg("valid way to this page").back_hyperlink("./main.php", "Main page");
    if($_POST["content"] == "")
        return alert_msg("請勿張貼空白文").back_hyperlink("./main.php", "Main page");

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();

    $uid = $_SESSION["uid"];
    $postid = mysqli_real_escape_string($con, $_POST["postid"]);
    $content = $_POST["content"]; // can't escape immediately because lf2br
    $result = insert_response($postid, $uid, $content);
    if($result == True)
        $ret = "post response success";
    else 
        $ret = alert_msg("post response failed");

    return $ret;
}

echo post_response().redirect("./main.php");;
?>
