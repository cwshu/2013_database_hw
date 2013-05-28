<?php
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
            <form method=\"post\" action=\"./delete_user.php\">
                <input type=\"submit\" value=\"delete account\">
            </form>
        </span>
    </div>";

    return $html_header;
}
?>
