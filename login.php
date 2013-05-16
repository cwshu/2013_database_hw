<?php
include_once "./db_connect.php";
include_once "./base.php";
include_once "./model/search.php";

function login(){
    if(!isset($_POST['uid']) || !isset($_POST['password']))
        return alert_msg("valid way to goto this page");

    global $con;
    $con = db_connection();
    if(mysqli_connect_errno($con))
        return "Fail to connect to MySQL: ".mysqli_connect_error();

    session_start();
    $uid = mysqli_real_escape_string($con, $_POST['uid']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    if(!authentication($uid, $password))
        return alert_msg("wrong password");
    // login success, save user in session, and redirect to main page
    $_SESSION["uid"] = $uid;

    $ret = alert_msg("login success");
    // $ret = $ret.back_hyperlink("./main.php", "Main page");
    $ret = $ret.redirect("./main.php");

    mysqli_close($con);
    return $ret;
}

    echo login();
?>
