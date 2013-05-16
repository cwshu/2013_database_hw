<?php

// base php function
$name_table = array();
function uid_to_name($uid){
    global $con;
    global $name_table;
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
// base html/css/js function
function alert_msg($msg){
    return "<script>alert(\"".$msg."\")</script>";
}
function back_hyperlink($path, $view){
    return "<a href=\"".$path."\">Back to ".$view."</a>";
}
function redirect($path){
    return "<script>document.location.href=\"".$path."\"</script>";
}
// HTML template
function tem_html_header($uid){
    $username = uid_to_name($uid);
    $html_header = "
    <div class=\"fixed_header\" >
        <span class=\"logo\">Facenote</span>
        <span class=\"function\">
            Welcome ".$username." !
            <a href=\"./main.php\">Main page</a>
            <a href=\"./userinfo.php?id=".$uid."\">User Info</a>
            <a href=\"./logout.php\">Logout</a>
        </span>
    </div>";

    return $html_header;
}

?>
