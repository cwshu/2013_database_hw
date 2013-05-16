<?php
include_once "./db_connect.php";
include_once "./base.php";
include_once "./model/search.php";
include_once "./model/insert.php";

function is_full_info(){
    if(!isset($_POST["uid"]) || $_POST["uid"] == "") return false;
    if(!isset($_POST["password"]) || $_POST["password"] == "") return false;
    if(!isset($_POST["password_again"]) || $_POST["password_again"] == "") return false;
    if(!isset($_POST["name"]) || $_POST["name"] == "") return false;
    if(!isset($_POST["email"]) || $_POST["email"] == "") return false;
    if(!isset($_POST["birthday"]) || $_POST["birthday"] == "") return false;
    if(!isset($_POST["sex"]) || $_POST["sex"] == "") return false;
    return true;
}

function signup(){
    if(!is_full_info()) 
        return alert_msg("Please fill in complete 
               information").redirect("./index.php");
    if($_POST["password"] != $_POST["password_again"]) 
        return alert_msg("Password is different from 
               Password again").redirect(".index.php");

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();

    $uid = mysqli_real_escape_string($con, $_POST["uid"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $birthday = mysqli_real_escape_string($con, $_POST["birthday"]);
    $sex = $_POST["sex"];

    if(is_uid_exist($uid)) 
        return alert_msg("This account is already used").redirect("./index.php");
    if(is_email_exist($uid)) 
        return alert_msg("This email is already used").redirect("./index.php");
    if(insert_account($uid, $password, $name, $email, $birthday, $sex) == false)
        return alert_msg("sign up failed").redirect("./index.php");

    $ret = alert_msg("sign up success, please relogin!!");
    // $ret = $ret.back_hyperlink("./index.php", "Homepage");
    $ret = $ret.redirect("./index.php");

    mysqli_close($con);
    return $ret;
}

    echo signup();
?>
