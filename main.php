<?php
include_once "./base.php";
include_once "./db_connect.php";
include_once "./model/search.php";
include_once "./template/template.php";
include_once "./template/tem_header.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="<?php echo "$static_path"?>base.css" />
    <link rel="stylesheet" href="<?php echo "$static_path"?>main.css" />
    <title>Facenote</title>
</head>
<body>
<?php
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
