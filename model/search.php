<?php
// Notice: You should define "Global Variable $con" 
//         for your database connection (procedure style, not object-oriented style)
//         before using following functions

function authentication($uid, $password){
    // authenticate user account and password
    global $con;

    $sql = "select uid from users   
            where uid = '".$uid."'
            and password = md5('".$password."');";
    //echo $sql."<br />";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0) // no user/pwd match 
        return false;
    return true;
}
function list_userinfo($uid){
    // list username, email and birthday
    global $con;
    $sql = "select name, email, birthday from users where uid ='".$uid."';";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0)
        return false;

    $row = mysqli_fetch_array($result);
        return $row;
}
function is_uid_exist($uid){
    global $con;
    $sql = "select uid from users
            where uid = '".$uid."';";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num > 0)
        return true;
    return false;
}
function is_email_exist($email){
    global $con;
    $sql = "select email from users
            where email = '".$email."';";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num > 0)
        return true;
    return false;
}

function list_all_friendid($uid)
{
    // list all your friends
    global $con;
    $sql = "select friend_id from friends
            where uid = '".$uid."';";
    $result = mysqli_query($con, $sql);
    $friend_num = mysqli_num_rows($result);
    $friendid_list = array();
    for($i = 0; $i < $friend_num; $i++){
        $row = mysqli_fetch_array($result);
        $friendid_list[] = $row["friend_id"];
    }

    return $friendid_list;
}

function is_article_exist($postid){
    global $con;
    $sql = "select postid from articles where postid = '".$postid."';";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num == 0)
        return false;
    return true;
}
function get_all_article($postid_list, $uid)
{
    global $con;

    $articles = array();
    $people_num = count($postid_list);
    if($people_num == 0)
        return $articles;
    $sql = "select uid, postid, content, time from articles
            where uid = '".$postid_list[0]."' ";
    for($i = 1; $i < $people_num; $i++)
    {
        $sql = $sql."or uid = '".$postid_list[$i]."' ";
    }
    $sql = $sql."order by time desc;";
    // select uid, postid, content, time from articles 
    // where uid = 'aaa' {or uid = "bbb"} {or uid = "ccc"} order by time desc
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    for($i = 0; $i < $num; $i++)
    {
        $row = mysqli_fetch_array($result);
        $articles[$i] = array(
        "uid" => $row["uid"] ,
        "content" => $row["content"] ,
        "time" => $row["time"],
        "postid" => $row["postid"]
        );
        $articles[$i]["like_population"] = like_population($articles[$i]["postid"]);
        $articles[$i]["is_like"] = is_like($articles[$i]["postid"], $uid);
    }
    return $articles;
}

function like_population($postid){
    global $con;
    $sql = "select count(*) from likes where postid = '".$postid."';";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    return $row["count(*)"];
}

function is_like($postid, $uid){
    global $con;
    $sql = "select * from likes where postid = '".$postid."' and uid = '".$uid."';";
    // echo $sql."<br />";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num == 0)
        return False;
    return True;
}
?>
