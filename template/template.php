<?php
// html templates
function tem_html_userinfo($username, $email, $birthday){
    $html_userinfo = "
        <div class=\"userinfo\">
            <h1>".$username."</h1>
            <p>
                Email: ".$email." <br />
                Birthday: ".$birthday." <br />
            </p>
        </div>";

    return $html_userinfo;
}

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
function tem_html_add_friend(){
    $html_add_friend = "
    <div class=\"add_friend\">
        <form method=\"post\" action=\"./add_friend.php\">
            <span><input type=\"submit\" value=\"Add friend\"></span>
            <span>friend id:<input type=\"text\" name=\"friend_id\"/></span>
            <span>relationship:<input type=\"text\" name=\"relationship\"/></span>
        </form>
    </div>
    ";
    return $html_add_friend;
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
            $like_msg = "unlike";
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
?>
