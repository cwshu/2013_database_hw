<?php
// Notice: You should define "Global Variable $con" 
//         for your database connection (procedure style, not object-oriented style)
//         before using following functions

function delete_user($uid){
    global $con;
    if(!is_uid_exist($uid))
        return false;
    
    $uid = mysqli_real_escape_string($con, $uid);
    $sql = "delete from users where uid = '".$uid."';";
    $del_user = mysqli_query($con, $sql);
    if(!$del_user) 
        return false;

    $friends = list_all_friendid($uid);
    $articles = list_all_article_id($uid);
    // delete all friends and articles(and like article)
    foreach($friends as $key => $friend_id){
        delete_friend($uid, $friend_id);
    }
    foreach($articles as $key => $postid){
        delete_article($postid);
    }
    return true;
}
function delete_friend($uid, $friend_id){
    global $con;
    if(!is_uid_exist($uid))
        return false;
    if(!is_uid_exist($friend_id))
        return false;
    if(!is_friend($uid, $friend_id))

    $uid = mysqli_real_escape_string($con, $uid);
    $friend_id = mysqli_real_escape_string($con, $friend_id);
    $sql = "delete from friends where uid = '".$uid."' and friend_id = '".$friend_id."';";
    $ret1 = mysqli_query($con, $sql);
    $sql = "delete from friends where uid = '".$friend_id."' and friend_id = '".$uid."';";
    $ret2 = mysqli_query($con, $sql);
    return $ret1 && $ret2;
}
function delete_article($postid){
    global $con;
    if(!is_article_exist($postid))
        return false;

    $postid = mysqli_real_escape_string($con, $postid);
    $sql = "delete from articles where postid = '".$postid."';";
    $det_art = mysqli_query($con, $sql);
    if(!$det_art)
        return false;
    
    $liked_people = list_uid_like_article($postid);
    foreach($liked_people as $key => $uid){
        delete_like_article($postid, $uid);
    }
    _delete_responses_of_article($postid);
    return true;
}
function _delete_responses_of_article($postid){
    global $con;
    $sql = "delete from responses where postid = '".$postid."';";
    // $postid = mysqli_real_escape_string($con, $postid);
    mysqli_query($con, $sql);
}
function delete_response($postid, $r_postid){
    global $con;
    if(!is_response_exist($postid, $r_postid))
        return false;

    $postid = mysqli_real_escape_string($con, $postid);
    $r_postid = mysqli_real_escape_string($con, $r_postid);
    $sql = "delete from responses where postid = '".$postid."' 
            and r_postid = '".$r_postid."';";
    $result = mysqli_query($con, $sql);
    if(!$result)
        return false;

    return true;
}
function delete_like_article($postid, $uid){ // unlike article
    global $con;
    if(!is_uid_exist($uid))
        return false;
    if(!is_article_exist($postid))
        return false;
    
    $postid = mysqli_real_escape_string($con, $postid);
    $uid = mysqli_real_escape_string($con, $uid);
    $sql = "delete from likes where uid = '".$uid."' 
            and postid = '".$postid."';";
    
    return mysqli_query($con, $sql);
}
?>
