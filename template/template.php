<?php
// html templates
function tem_html_userinfo($uid, $username, $email, $birthday, $img_file_ext){
    if($img_file_ext == "0") // no icon
        $icon = "";
    else
        $icon = tem_html_show_icon($uid, $img_file_ext, 200);
    $html_userinfo = "
        <div class=\"userinfo\">
            ".$icon."
            <h1>".$username."</h1>
            <p>
                account: ".$uid." <br />
                Email: ".$email." <br />
                Birthday: ".$birthday." <br />
                <a href=\"./change_userinfo.php\">change personal infomation</a>
            </p>
        </div>
        ";

    return $html_userinfo;
}
function tem_html_change_userinfo($name, $email, $birthday){
    $html_ch_userinfo="
    <form method=\"post\" action=\"./change_userinfo.php\">
        Name: <input type=\"text\" name=\"name\" value=\"".$name."\"> <br />
        Email: <input type=\"text\" name=\"email\" value=\"".$email."\"> <br />
        Birthday: <input type=\"text\" name=\"birthday\" value=\"".$birthday."\"> <br />
        <input type=\"submit\" value=\"修改\">
    </form>
    <a href=\"./change_icon.php\">Change icon</a><br />
    <a href=\"./userinfo.php\">Back to userinfo</a>
    ";
    return $html_ch_userinfo;
}
function tem_html_change_icon($img_file_ext, $uid){
// You should include "./base.php"
    if($img_file_ext == "0") // img doesn't exist
        $tem_show_icon = "";
    else
        $tem_show_icon = "
        <span>Your icon:<br /><span>".tem_html_show_icon($uid, $img_file_ext, 200);
    
    $ret = $tem_show_icon._change_icon_form();
    $ret = $ret.back_hyperlink("./userinfo.php", "Userinfo");
    return $ret;
}
function _change_icon_form(){
    $form = "
    <form method=\"post\" action=\"./change_icon.php\" enctype=\"multipart/form-data\">
        Upload Your Icon:
        <input type=\"file\" name=\"icon\" > <br />
        <input type=\"submit\" value=\"確認\">
    </form>
    ";
    return $form;
}
function tem_html_show_icon($uid, $img_file_ext, $size){
    $icon = "
    <img src=\"./upload/".$uid."_icon.".$img_file_ext."\"
         width=\"".$size."\" height=\"".$size."\" />
    ";
    return $icon;
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
function tem_html_delete_friend(){
    $html_delete_friend = "
    <div class=\"delete_friend\">
        <form method=\"post\" action=\"./delete_friend.php\">
            <span><input type=\"submit\" value=\"Delete friend\"></span>
            <span>friend id:<input type=\"text\" name=\"friend_id\"/></span>
        </form>
    </div>
    ";
    return $html_delete_friend;
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
        $_html_article = _tem_html_show_article($articles[$i]);
        $html_article = $html_article.$_html_article;
    }
    return $html_article;
}
function _tem_html_show_article($article){
    if($article["is_like"])
        $like_msg = "unlike";
    else
        $like_msg = "like";

    if($article["is_your_article"])
        $delete_article_msg = "
        <form class=\"delete_article\" method=\"post\" action=\"./delete_article.php\">
            <input type=\"hidden\" name=\"postid\" value=\"".$article["postid"]."\" />
            <input type=\"submit\" value=\"x\">
        </form>";
    else
        $delete_article_msg = "";

    if($article["icon"] != false)
        $icon = tem_html_show_icon($article["uid"], $article["icon"], 30);
    else
        $icon = "";

    $html_responses = tem_html_response($article["responses"], $article["postid"]);
    $html_article = "
    <div>
       <div class=\"art_head\">
           ".$icon."
           <a href=\"./userinfo.php?id=".$article["uid"]."\" class=\"name\">
           ".uid_to_name($article["uid"])."</a><span> says</span>".$delete_article_msg."
       </div>
       <p class=\"border\">".$article['content']."</p>
       <p>
           <a href=\"./like.php?postid=".$article["postid"]."\">".$like_msg."</a>
           <span>".$article["like_population"]." like </span>
           <span class=\"time\"> 
              <span class=\"it\">posted at </span>".$article['time']."
           </span>
       </p>
       ".$html_responses."
    </div>";

    return $html_article;
}
function tem_html_response($responses, $postid){
    $html_response = "
    <div class=\"responses\">
    ".tem_html_post_response($postid).tem_html_show_response($responses)."
    </div>";

    return $html_response;
}
function tem_html_post_response($postid){
    $html_response = "
    <div>
        <form method=\"post\" action=\"./response.php\">
            <textarea name=\"content\"></textarea>
            <input type=\"hidden\" name=\"postid\" value=\"".$postid."\">
            <input type=\"submit\" value=\"回復\">
        </form>
    </div>
    ";
    return $html_response;
}
function tem_html_show_response($responses){ // element: uid, content, time
    $response_num = count($responses);
    $html_response = "";
    for($i = 0; $i < $response_num; $i++)
    {
        $_html_response = _tem_html_show_response($responses[$i]);
        $html_response = $html_response.$_html_response;
    }
    return $html_response;
}
function _tem_html_show_response($response){
    if($response["is_your_response"])
        $delete_response_msg = "
        <form class=\"delete_response\" method=\"post\" action=\"./delete_response.php\">
            <input type=\"hidden\" name=\"postid\" value=\"".$response["postid"]."\" />
            <input type=\"hidden\" name=\"r_postid\" value=\"".$response["r_postid"]."\" />
            <input type=\"submit\" value=\"x\">
        </form>";
    else
        $delete_response_msg = "";

    if($response["icon"] != false)
        $icon = tem_html_show_icon($response["uid"], $response["icon"], 30);
    else
        $icon = "";

    $html_response = "
    <div>
       <div class=\"resp_head\">
           ".$icon."
           <a href=\"./userinfo.php?id=".$response["uid"]."\" class=\"name\">
           ".uid_to_name($response["uid"])."</a><span> says</span>".$delete_response_msg."
           <span class=\"time\"> 
              <span class=\"it\">posted at </span>".$response['time']."
           </span>
       </div>
       <p class=\"border\">".$response['content']."</p>
    </div>";

    return $html_response;
}
?>
