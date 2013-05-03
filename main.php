<!--
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="./main.css">
    <title>main</title>
</head>
<body>
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
    <div class=\"article\">
        <div class=\"friends\">
           <h2>Friends</h2>"
           .$html_friend."
        </div>";
    <div class=\"article\">
    ".$html_article."
    </div>";
    </div>";
</body>
</html>
-->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="./main.css">
    <title>main</title>
</head>
<body>
<?php
/*
if post parameter exist || session exist
    if mysql_connect true
        if post
            if correct pwd
            else wrong password, break;
        
        got user's all friend
        got their all post

        end mysql_connect
    else error db connection
else valid way goto this page
*/
session_start();
define("not_login",0);
define("have_loginned",1); //save uid
define("login_now",2);
function db_connection(){
    $db_host = "localhost";
    $db_user = "dbuser";
    $db_pwd  = "dbuser";
    $db_name = "db_pj2";
    $con = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
    return $con;
}
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
function authentication($con, $uid, $password){
    $sql = "select uid from users   
            where uid = '".$uid."'
            and password = md5('".$password."');";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) == 0) // no user/pwd match 
        return false;
    return true;
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
function tem_html_article($articles){ // element: uid, content, time
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
        $html_article = "
        <div class=\"article\">
        ".$html_article."
        </div>";

    return $html_article;
}
// main
$way_to_page = not_login;
if(isset($_SESSION["uid"])) 
    $way_to_page = have_loginned;
else if(isset($_POST['uid']))
    $way_to_page = login_now;

if($way_to_page != not_login)
{
    // connect db
    $con = db_connection();
    if(mysqli_connect_errno($con)){
        echo "Fail to connect to MySQL: ".mysqli_connect_error();
    }
    else{
        // preprocess: get uid (check if password is true)
        $login_success = 1;
        if($way_to_page == login_now){
            $uid = mysqli_real_escape_string($con, $_POST['uid']);
            $password = mysqli_real_escape_string($con, $_POST['password']);
            if(!authentication($con, $uid, $password)){
                echo "wrong password";
                $login_success = 0;
            }
            else{ // login success, save user in session
                $_SESSION["uid"] = $uid;
            }
        }
        else if($way_to_page == have_loginned){
            $uid = $_SESSION["uid"];
        }
        if($login_success || $way_to_page = have_loginned)
        {
            // select username $html_header
            $username = uid_to_name($con, $uid);
            $html_header = tem_html_header($username, $uid);
            // select all your friend
            $friendid_list = list_all_friendid($con, $uid);

            $html_friend = tem_html_friend($friendid_list);
            $articleid_list = $friendid_list;
            $articleid_list[] = $uid;
            $articles = get_all_article($con, $articleid_list);
            $html_article = tem_html_article($articles);

            $html_page = 
            $html_header."
            <div class=content1>
            ".$html_friend.$html_article."
            </div>";

            echo $html_page;
        }

        mysqli_close($con);
    }
}
else
    echo "valid way goto this page";
?>
</body>
</html>
