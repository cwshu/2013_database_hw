<?php
    include_once "./template/template.php";
    include_once "./base.php";
    include_once "./db_connect.php";
    include_once "./model/search.php";
    include_once "./model/update.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>change userinfo</title>
</head>
<body>
<?php
function change_userinfo(){
    session_start();
    if(!isset($_SESSION["uid"]))
        return "valid way to this page";

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con)){
        echo "Fail to connect to MySQL: ".mysqli_connect_error();
    }
    $uid = $_SESSION["uid"];

    if(!isset($_POST["name"])){
        $row = list_userinfo($uid);
        $name = $row["name"];
        $email = $row["email"];
        $birthday = $row["birthday"];
        return tem_html_change_userinfo($name, $email, $birthday);
    }

    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $birthday = mysqli_real_escape_string($con, $_POST["birthday"]);
    if(update_userinfo($uid, $name, $email, $birthday))
        return "update success <br />".back_hyperlink("./userinfo.php", "userinfo");
    else
        return "update failed <br />".back_hyperlink("./userinfo.php", "userinfo");
}

echo change_userinfo();
?>
</body>
</html>
