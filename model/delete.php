<?php
// Notice: You should define "Global Variable $con" 
//         for your database connection (procedure style, not object-oriented style)
//         before using following functions

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
