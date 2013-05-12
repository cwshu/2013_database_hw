<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="./base.css">
    <link rel="stylesheet" href="./main.css">
    <title>main</title>
</head>
<body>
<?php
session_start();
include "./base.php";
function list_all_friendid($con, $uid)
{
    $sql = "select friend_id from friends
            where uid = '".$uid."';";
    // echo "<h2>list_all_friendid</h2>".$sql;
    $result = mysqli_query($con, $sql);
    $friend_num = mysqli_num_rows($result);
    $friendid_list = array();
    for($i = 0; $i < $friend_num; $i++)
    {
        $row = mysqli_fetch_array($result);
        $friendid_list[] = $row["friend_id"];
    }
    return $friendid_list;
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
function get_all_article($con, $postid_list, $uid)
{
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
    // select uid, postid, content, time from articles where uid = 'aaa' {or uid = "bbb"} {or uid = "ccc"} order by time desc
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
// html templates
function tem_html_friend($friendid_list){
    global $con;
    $friend_num = count($friendid_list);
    $html_friend = "";
    for($i = 0; $i < $friend_num; $i++)
    {
        $html_friend_temp = "
        <a href=\"./userinfo.php?id=".$friendid_list[$i]."\">
        ".uid_to_name($friendid_list[$i])." <br /></a>";
        $html_friend = $html_friend.$html_friend_temp;
    }
    $html_friend = "
    <div class=\"friends\">
       <h2>Friends</h2>"
       .$html_friend."
    </div>";

    return $html_friend;
}
function tem_html_article($articles){
    $html_article = "
    <div class=\"article\">
    ".tem_html_post_article().tem_html_show_article($articles)."
    </div>";

    return $html_article;
}
function tem_html_post_article(){
    $html_article = "
    <div>
        <form method=\"post\" action=\"./post_article.php\">
            <span>想說的話...</br /></span>
            <textarea name=\"content\"></textarea>
            <input type=\"submit\" value=\"留言\">
        </form>
    </div>
    ";
    return $html_article;
}
function tem_html_show_article($articles){ // element: uid, content, time
    $article_num = count($articles);
    $html_article = "";
    for($i = 0; $i < $article_num; $i++)
    {
        if($articles[$i]["is_like"])
            $like_msg = "";
        else
            $like_msg = "like";

        $_html_article = "
        <div>
           <p><a href=\"./userinfo.php?id=".$articles[$i]["uid"]."\" class=\"name\">
           ".uid_to_name($articles[$i]['uid'])."</a> says </p>
           <p class=\"border\">".$articles[$i]['content']."</p>
           <p>
               <a href=\"./like.php?postid=".$articles[$i]["postid"]."\">".$like_msg."</a>
               <span>".$articles[$i]["like_population"]." like </span>
               <span class=\"time\"> <span class=\"it\">posted at </span>".$articles[$i]['time']."</span>
           </p>
        </div>";
        $html_article = $html_article.$_html_article;
    }
    return $html_article;
}
// main
if(isset($_SESSION["uid"])){
    include "./db_connect.php";
    $con = db_connection();
    if(mysqli_connect_errno($con)){
        echo "Fail to connect to MySQL: ".mysqli_connect_error();
    }
    else{
        //if having logined
        $uid = $_SESSION["uid"];
        // select username $html_header
        $html_header = tem_html_header($uid);
        // select all your friend
        $friendid_list = list_all_friendid($con, $uid);

        $html_friend = tem_html_friend($friendid_list);
        $articleid_list = $friendid_list;
        $articleid_list[] = $uid;   // $articleid_list.append("$uid")
        $articles = get_all_article($con, $articleid_list, $uid);
        $html_article = tem_html_article($articles);

        $html_page = 
        $html_header."
        <div class=\"content\">
        ".$html_friend.$html_article."
        </div>";

        echo $html_page;

        mysqli_close($con);
    }
}
else
    echo "valid way goto this page";
?>
</body>
</html>
