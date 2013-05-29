<?php
// Notice: You should define "Global Variable $con" 
//         for your database connection (procedure style, not object-oriented style)
//         before using following functions

function insert_account($uid, $password, $name, $email, $birthday, $sex){
    global $con;
    $uid = htmlspecialchars($uid);
    $password = htmlspecialchars($password);
    $name = htmlspecialchars($name);
    $email = htmlspecialchars($email);
    $birthday = htmlspecialchars($birthday);
    $sex = htmlspecialchars($sex);

    $sql = "insert into users
            values ('".$uid."', md5('".$password."'),
            '".$name."', '".$email."', '".$birthday."','".$sex."');";

    return mysqli_query($con, $sql); 
}

function insert_friend($uid, $friendid, $relationship = ""){
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

function insert_article($uid, $content){
    global $con;
    date_default_timezone_set("Asia/Taipei");
    $date = date("Y-m-d H:i:s", time());
    $content = htmlspecialchars($content); // XSS attack
    $content = nl2br($content); // newlines to HTML line break
    $content = mysqli_real_escape_string($con, $content); // sql injection

    // select newest postid
    $sql = "select postid from articles order by postid desc limit 1";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0) // no article in DB
        $postid = 1;
    else{
        $row = mysqli_fetch_array($result);
        $postid = $row["postid"] + 1;
    }
    
    $sql = "insert into articles value('".$uid."', '".$postid."',
            '".$content."', '".$date."');";
    $result = mysqli_query($con, $sql);
    return $result;
}

function insert_response($postid, $uid, $content){
    global $con;
    date_default_timezone_set("Asia/Taipei");
    $date = date("Y-m-d H:i:s", time());
    $content = htmlspecialchars($content); // XSS attack
    $content = nl2br($content); // newlines to HTML line break
    $content = mysqli_real_escape_string($con, $content); // sql injection

    // select newest r_postid
    $sql = "select r_postid from responses where postid = '".$postid."'
            order by r_postid desc limit 1";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0) // no article in DB
        $r_postid = 1;
    else{
        $row = mysqli_fetch_array($result);
        $r_postid = $row["r_postid"] + 1;
    }
    
    $sql = "insert into responses value
            ('".$postid."', '".$r_postid."', '".$uid."', '".$content."', '".$date."')";
    $result = mysqli_query($con, $sql);
    return $result;
}

function insert_like_article($postid, $uid){
    // notice: you should include /model/search.php
    global $con;
    if(!is_uid_exist($uid))
        return false;
    if(!is_article_exist($postid))
        return false;

    $sql = "insert into likes value('".$postid."', '".$uid."');";
    $result = mysqli_query($con, $sql);
    return $result;
}
?>
