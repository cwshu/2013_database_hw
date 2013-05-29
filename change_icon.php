<?php
    include_once "./base.php";
    include_once "./db_connect.php";
    include_once "./model/search.php";
    include_once "./model/update.php";
    include_once "./template/template.php";
?>
<?php
function _upload_icon(){
    if(!isset($_SESSION["uid"]))
        return "valid way to go this page";
    if(!isset($_FILES["icon"]))
        return "";
    if($_FILES["icon"]["error"] > 0) // upload error
        return "upload error".$_FILES["icon"]["error"];
    
    $file_ext = pathinfo($_FILES["icon"]["name"], PATHINFO_EXTENSION);
    move_uploaded_file($_FILES["icon"]["tmp_name"],
                       "./upload/".$_SESSION["uid"]."_icon.".$file_ext );

    return update_icon($_SESSION["uid"], $file_ext);
}
function change_icon(){
    session_start();
    global $con;
    $con = db_connection();

    _upload_icon();
    $file_ext = is_icon_exist($_SESSION["uid"]);
    
    $ret = tem_html_change_icon($file_ext, $_SESSION["uid"]);
    return $ret;
}

    echo change_icon();
?>
