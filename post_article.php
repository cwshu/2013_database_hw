<?php
include_once "./db_connect.php";
include_once "./base.php";
include_once "./model/insert.php";

function preinfo_post_article(){
    if(!isset($_SESSION["uid"])) return False;
    if(!isset($_POST["content"])) return False;
    return True;
}
// main
function post_article(){
    session_start();
    if(!preinfo_post_article())
        return alert_msg("valid way to this page").back_hyperlink("./main.php", "Main page");
    if($_POST["content"] == "")
        return alert_msg("請勿張貼空白文").back_hyperlink("./main.php", "Main page");

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();

    $uid = $_SESSION["uid"];
    $content = $_POST["content"];
    $result = insert_article($uid, $content);
    if($result == True)
        $ret = alert_msg("post article success");
    else if($result == False)
        $ret = alert_msg("post article failed");

    return $ret;
}
echo post_article().redirect("./main.php");;
?>
