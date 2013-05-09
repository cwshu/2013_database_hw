<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="./main.css">
    <title>main</title>
</head>
<body>
<?php
session_start();
$name_table = array();
function uid_to_name($con, $uid){
    if(isset($name_table[$uid])){
        return $name_table[$uid];
    }
    else{
        $sql = "select name from users
                where uid = '".$uid."';";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $name_table[$uid] = $row["name"];
        return $name_table[$uid];
    }
}
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
function get_all_article($con, $postid_list)
{
    $articles = array();
    $people_num = count($postid_list);
    if($people_num == 0)
        return $articles;
    $sql = "select uid, content, time from articles
            where uid = '".$postid_list[0]."' ";
    for($i = 1; $i < $people_num; $i++)
    {
        $sql = $sql."or uid = '".$postid_list[$i]."' ";
    }
    $sql = $sql."order by time desc;";
    // select uid, content, time from articles where uid = 'aaa' {or uid = "bbb"} {or uid = "ccc"} order by time desc

    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    for($i = 0; $i < $num; $i++)
    {
        $row = mysqli_fetch_array($result);
        $articles[] = array(
        "uid" => $row["uid"] ,
        "content" => $row["content"] ,
        "time" => $row["time"]
        );
    }
    return $articles;
}
// html templates
function tem_html_header($username, $uid){
    $html_header = "
    <div class=\"fixed-header\" >
        Welcome ".$username." !<br />
        <a href=\"./userinfo.php?id=".$uid."\">User Info</a>
        <a href=\"./logout.php\">Logout</a>
    </div>
    <div class=\"header\">
        Welcome Username !<br />
        <a href=\"./userinfo.php\">User Info</a>
        <a href=\"./logout.php\">Logout</a>
    </div>";

    return $html_header;
}
function tem_html_friend($friendid_list){
    global $con;
    $friend_num = count($friendid_list);
    $html_friend = "";
    for($i = 0; $i < $friend_num; $i++)
    {
        $html_friend_temp = "
        <a href=\"./userinfo.php?id=".$friendid_list[$i]."\">
        ".uid_to_name($con, $friendid_list[$i])." <br /></a>";
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
        <textarea name=\"content\"></textarea>
        <input type=\"submit\" value=\"留言\">
    </div>
    ";
    return $html_article;
}
function tem_html_show_article($articles){ // element: uid, content, time
    global $con;
    $article_num = count($articles);
    $html_article = "";
    for($i = 0; $i < $article_num; $i++)
    {
        $_html_article = "
        <div>
           <p><a href=\"./userinfo.php?id=".$articles[$i]["uid"]."\" class=\"name\">
           ".uid_to_name($con, $articles[$i]['uid'])."</a> says </p>
           <p class=\"border\">".$articles[$i]['content']."</p>
           <p>".$articles[$i]['time']."</p>
        </div>";
        $html_article = $html_article.$_html_article;
    }
    return $html_article;
}
// main
if(isset($_SESSION["uid"])){
    include "./db_connect.php";
    // connect db
    $con = db_connection();
    if(mysqli_connect_errno($con)){
        echo "Fail to connect to MySQL: ".mysqli_connect_error();
    }
    else{
        //if having logined
        $uid = $_SESSION["uid"];
        // select username $html_header
        $username = uid_to_name($con, $uid);
        $html_header = tem_html_header($username, $uid);
        // select all your friend
        $friendid_list = list_all_friendid($con, $uid);

        $html_friend = tem_html_friend($friendid_list);
        $articleid_list = $friendid_list;
        $articleid_list[] = $uid;   // $articleid_list.append("$uid")
        $articles = get_all_article($con, $articleid_list);
        $html_article = tem_html_article($articles);

        $html_page = 
        $html_header."
        <div class=content1>
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
