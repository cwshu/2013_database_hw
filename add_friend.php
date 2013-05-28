<?php
include_once "./db_connect.php";
include_once "./base.php";
include_once "./model/search.php";
include_once "./model/insert.php";

function add_friend(){
    session_start();
    if(!isset($_POST["friend_id"]) || !isset($_SESSION["uid"]))
        return alert_msg("valid way to this page");

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();
    
    $friend_id = mysqli_real_escape_string($con, $_POST["friend_id"]);
    $uid = $_SESSION["uid"];
    if(!is_uid_exist($friend_id))
        return alert_msg($friend_id." doesn't exist, please check your friend's id again");
    if($uid == $friend_id)
        return alert_msg("Don't add yourself as your friend");
        
    $result1 = insert_friend($uid, $friend_id, $_POST["relationship"]);
    $result2 = insert_friend($friend_id, $uid);
    if($result1 == True && $result2 == True)
        $ret = alert_msg("add ".uid_to_name($friend_id)." as your friend successfully");
    else
        $ret = alert_msg("add ".uid_to_name($friend_id)." failed for unknown reason");
    
    return $ret;
}

echo add_friend().redirect("./userinfo.php");
?>
