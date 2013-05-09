<?php
include "./db_connect.php";
include "./base.php";
/*
function name_to_uid($username){
    global $con;
    $sql = "select uid from users where name = '".$username."';";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0)
        return False;
    $row = mysqli_fetch_array($result);
    return $row["uid"];

}
function is_username_exist($username){
    global $con;
    $sql = "select uid from users where name = '".$username."';";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num == 0)
        return False;
    return True;
}
*/
function is_uid_exist($uid){
    global $con;
    $sql = "select uid from users where uid = '".$uid."';";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num == 0)
        return False;
    return True;
}
function add_friend($uid, $friendid, $relationship = ""){
    global $con;

    if($uid == $friendid)
        return False;
    if($relationship == "")
        $sql = "insert into friends(uid, friend_id) value('".$uid."', '".$friendid."');";
    else
        $sql = "insert into friends value('".$uid."', '".$friendid."', '".$relationship."');";

    $result = mysqli_query($con, $sql);
    return $result;
}

//main
session_start();
if(!isset($_POST["friend_id"]) || !isset($_SESSION["uid"]))
    echo "valid way to this page <br />";
else{
    $con = db_connection();
    if(mysqli_connect_errno($con)){
        echo "Fail to connect to MySQL: ".mysqli_connect_error();
    }
    else{
        $friend_id = $_POST["friend_id"];
        $uid = $_SESSION["uid"];
        if(!is_uid_exist($friend_id)){
            echo "no this person :".$friend_id."<br />";
        }
        else if($uid == $friend_id){
            echo "Don't add yourself as your friend<br />";
        }
        else{
            $con = db_connection();
            $result1 = add_friend($uid, $friend_id, $_POST["relationship"]);
            $result2 = add_friend($friend_id, $uid);
            if($result1 == True && $result2 == True)
                echo "add ".uid_to_name($friend_id)." as your friend successfully <br />";
            else
                echo "add ".uid_to_name($friend_id)." failed for unknown reason <br />";
            
            echo "<a href=\"./userinfo.php?id=".$uid."\">Back to Userinfo</a>";
        }
    }
}

?>
