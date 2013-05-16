<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="./base.css" />
    <link rel="stylesheet" href="./main.css" />
    <title>Facenote</title>
</head>
<body>
<?php
include_once "./base.php";
include_once "./db_connect.php";
include_once "./model/search.php";

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
               <span class=\"time\"> 
                  <span class=\"it\">posted at </span>".$articles[$i]['time']."
               </span>
           </p>
        </div>";
        $html_article = $html_article.$_html_article;
    }
    return $html_article;
}
// main
function mainpage(){
    session_start();
    if(!isset($_SESSION["uid"]))
        return "valid way goto this page";

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();

    $uid = $_SESSION["uid"];
    $html_header = tem_html_header($uid);
    // select all your friend
    $friendid_list = list_all_friendid($uid);

    $html_friend = tem_html_friend($friendid_list);
    $articleid_list = $friendid_list;
    $articleid_list[] = $uid;   // $articleid_list.append("$uid")
    $articles = get_all_article($articleid_list, $uid);
    $html_article = tem_html_article($articles);

    $html_page = 
    $html_header."
    <div class=\"content\">
        ".$html_friend.$html_article."
    </div>";

    mysqli_close($con);
    return $html_page;
}

echo mainpage();
?>
</body>
</html>
