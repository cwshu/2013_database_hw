<?php
function insert_article($uid, $content){
    global $con;
    $date = date("Y-m-d H:i:s", time());
    //echo $content."<br />";
    $content = htmlspecialchars($content); // XSS attack
    $content = nl2br($content); // newlines to HTML line break
    $content = mysqli_real_escape_string($con, $content); // sql injection

    $sql = "select postid from articles order by postid desc limit 1";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0) // no article in DB
        $postid = 1;
    else{
        $row = mysqli_fetch_array($result);
        $postid = $row["postid"] + 1;
    }
    
    $sql = "insert into articles value('".$uid."', '".$postid."', '".$content."', '".$date."');";
    //echo nl2br($sql)."<br />";
    $result = mysqli_query($con, $sql);
        return $result;
}

function alert_msg($msg){
    echo "<script>alert(\"".$msg."\")</script>";
}
// main
session_start();
if(isset($_SESSION["uid"]) && $_POST["content"] != "")
{
    include "./db_connect.php";
    $con = db_connection();
    if(mysqli_connect_errno($con)){
        echo "Fail to connect to MySQL: ".mysqli_connect_error();
    }
    else{
        $uid = $_SESSION["uid"];
        $content = $_POST["content"];
        $result = insert_article($uid, $content);
        if($result == True)
            alert_msg("post article success");
        else if($result == False)
            alert_msg("post article failed");
        header("Location: ./main.php");
    }
}
else{
    alert_msg("valid way to this page");
    echo ("valid way to this page");
}
?>
