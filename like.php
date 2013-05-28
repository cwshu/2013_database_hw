<?php
include_once "./db_connect.php";
include_once "./base.php";
include_once "./model/search.php";
include_once "./model/insert.php";
include_once "./model/delete.php";

// main
function like(){
    session_start();
    if(!isset($_GET["postid"]) || !isset($_SESSION["uid"]))
        return "valid way to this page";

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();

    $postid = mysqli_real_escape_string($con, $_GET["postid"]);
    $uid = $_SESSION["uid"];
    if(!is_article_exist($postid))
        return alert_msg("this article doesn't exist");

    if(!is_like($postid, $uid)){
        $result = insert_like_article($postid, $uid);
        if(!$result)
            return alert_msg("unlike article failed");
    }
    else{
        $result = delete_like_article($postid, $uid);
        if(!$result)
            return alert_msg("like article failed");
    }
    
    return redirect("./main.php");
}

echo like();
?>
