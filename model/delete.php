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
function delete_friend($uid, $friendid){
    global $con;
    if(!is_uid_exist($uid))
        return false;
    if(!is_uid_exist($friendid))
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
