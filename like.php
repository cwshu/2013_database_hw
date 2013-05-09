<?php
include "./db_connect.php";
function insert_like_article($postid, $uid){
    global $con;
    $sql = "insert into likes value('".$postid."', '".$uid."');";
    $result = mysqli_query($con, $sql);
    return $result;
}
function is_article_exist($postid){
    global $con;
    $sql = "select postid from articles where postid = '".$postid."';";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num == 0)
        return False;
    return True;
}
// main
session_start();
if(!isset($_GET["postid"]) || !isset($_SESSION["uid"])){
    echo "valid way to this page";
}
else{
    $con = db_connection();
    if(mysqli_connect_errno($con)){
        echo "Fail to connect to MySQL: ".mysqli_connect_error();
    }
    $postid = $_GET["postid"];
    $uid = $_SESSION["uid"];
    if(!is_article_exist($postid)){
        echo "no this article";
    }
    else{
        $result = insert_like_article($postid, $uid);
        if($result)
            echo "Success <br />";
        else
            echo "Failed <br />";
        
        echo "<a href=\"./main.php\">Back to Main page</a>";
    }

}
?>
