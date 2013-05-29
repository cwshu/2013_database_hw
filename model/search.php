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
    $sql = "select name, email, birthday, icon from users where uid ='".$uid."';";
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
function is_icon_exist($uid){
    global $con;
    $sql = "select icon from users where uid = '".$uid."'";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0)
        return false;
       
    $row = mysqli_fetch_array($result);
    if($row["icon"] == "0")
        return false;
    return $row["icon"];
}

function _is_friend($uid, $friend_id){
    global $con;
    $stmt = mysqli_prepare($con, "select * from friends where uid = ? and friend_id = ?");
    if(!$stmt)
        return false;

    mysqli_stmt_bind_param($stmt, "ss", $user, $friend);
    $user = $uid;
    $friend = $friend_id;
    mysqli_stmt_execute($stmt);
    $ret = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $ret;
}
function is_friend($uid, $friend_id){
    $ret1 = _is_friend($uid, $friend_id);
    $ret2 = _is_friend($friend_id, $uid);
    return $ret1 && $ret2;
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
function list_all_article_id($uid){
    global $con;

    $stmt = mysqli_prepare($con, "
    select postid from articles where uid = ?");
    if(!$stmt) return false;

    mysqli_stmt_bind_param($stmt, "s", $uid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $postid);
    $postids = array();
    while(mysqli_stmt_fetch($stmt)){
        $postids[] = $postid;
    }
    mysqli_stmt_close($stmt);
    return $postids;
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
    for($i = 1; $i < $people_num; $i++){
        $sql = $sql."or uid = '".$postid_list[$i]."' ";
    }
    $sql = $sql."order by time desc;";
    // select uid, postid, content, time from articles 
    // where uid = 'aaa' {or uid = "bbb"} {or uid = "ccc"} order by time desc
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    for($i = 0; $i < $num; $i++){
        $row = mysqli_fetch_array($result);
        $articles[$i] = array(
        "uid" => $row["uid"] ,
        "content" => $row["content"] ,
        "time" => $row["time"],
        "postid" => $row["postid"]
        );
        $articles[$i]["icon"] = is_icon_exist($articles[$i]["uid"]);
        $articles[$i]["like_population"] = like_population($articles[$i]["postid"]);
        $articles[$i]["is_like"] = is_like($articles[$i]["postid"], $uid);
        $articles[$i]["is_your_article"] = ($uid == $row["uid"]);
    }
    return $articles;
}
function get_uid_of_article($postid){
    global $con;
    if(!is_article_exist($postid)) return false;
    
    $stmt = mysqli_prepare($con, "select uid from articles where postid = ?");
    mysqli_stmt_bind_param($stmt, "i", $postid);
    mysqli_stmt_bind_result($stmt, $uid);
    mysqli_stmt_execute($stmt);
    if(mysqli_stmt_fetch($stmt))
        return $uid;
    return false;
}

function like_population($postid){
    global $con;
    $sql = "select count(*) from likes where postid = '".$postid."';";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    return $row["count(*)"];
}
function list_uid_like_article($postid){
    global $con;
    $stmt = mysqli_prepare($con, "
    select uid from likes where postid = ?");
    if(!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "i", $postid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $uid);
    $uids = array();
    while(mysqli_stmt_fetch($stmt)){
        $uids[] = $uid;
    }
    mysqli_stmt_close($stmt);
    return $uids;
}
function is_like($postid, $uid){
    global $con;
    $postid = mysqli_real_escape_string($con, $postid);
    $uid = mysqli_real_escape_string($con, $uid);

    $sql = "select * from likes where postid = '".$postid."' and uid = '".$uid."';";
    // echo $sql."<br />";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num == 0)
        return False;
    return True;
}
?>
