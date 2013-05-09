<!-- uid information 
name
email
birthday
back to main page
-->
<!--
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>uid information</title>
</head>
<body>
    <h1>$username</h1>
    <p>
        Email: $email
        Birthday: $birthday
        <a href="./main.php">Back to main page</a>
    </p>
    <a href="./logout.php">Logout</a>
</body>
</html>
-->

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />
    <link rel="stylesheet" href="./base.css">
    <link rel="stylesheet" href="./userinfo.css">
    <title>uid information</title>
</head>
<body>
<?php
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
function list_all_friendid($uid)
{
    global $con;
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

include "./db_connect.php";
include "./base.php";
$con = db_connection();
if(mysqli_connect_errno($con))
{
    echo "Fail to connect to MySQL: ".mysqli_connect_error();
}
else
{ 
    session_start();
    $uid = $_GET["id"];  // the uid of userinfo page;

    $sql = "select name, email, birthday from users where uid ='".$uid."';";
    //username, email, birthday for $uid
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $username = $row["name"];
    $email = $row["email"];
    $birthday = $row["birthday"];

    $html_header = tem_html_header($_SESSION["uid"]);
    $html_userinfo = tem_html_userinfo($username, $email, $birthday);
    if($_SESSION["uid"] == $uid)
        $html_add_friend = tem_html_add_friend();
    else
        $html_add_friend = "";
    $friendid_list = list_all_friendid($uid);
    $html_friend = tem_html_friend($friendid_list);

    $html_page = $html_header."
                 <div class=\"content\">
                    ".$html_userinfo.$html_add_friend.$html_friend."
                 </div>";
        
    echo $html_page;
}
?>

</body>
</html>
