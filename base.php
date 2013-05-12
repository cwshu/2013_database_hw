<?php

$name_table = array();
// base function
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
    </div>
    <div class=\"header\" >
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
