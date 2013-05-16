<?php
include_once "./db_connect.php";
include_once "./base.php";
include_once "./model/search.php";
include_once "./template/template.php";
include_once "./template/tem_header.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="<?php echo "$static_path"?>base.css" />
    <link rel="stylesheet" href="<?php echo "$static_path"?>userinfo.css" />
    <title>user information</title>
</head>
<body>
<?php
// controller
function userinfo(){
    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();

    session_start();
    if(isset($_GET["id"]))
        $uid = $_GET["id"];  // the uid of userinfo page;
    else
        $uid = $_SESSION["uid"];

    $myinfo = list_userinfo($uid);
    $username = $myinfo["name"];
    $email = $myinfo["email"];
    $birthday = $myinfo["birthday"];

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

    mysqli_close($con);
    return $html_page;
}

    echo userinfo();
?>

</body>
</html>
