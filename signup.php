<!--
insert into users values ("ubuntu", md5("ubuntu"), "Ubuntu", "Ubuntu@linux.unix", "2004-10-20");
-->
<?php
function is_uid_exist($con, $uid){
    $sql = "select uid from users
            where uid = '".$uid."';";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num > 0)
        return true;
    return false;
}
function is_email_exist($con, $email){
    $sql = "select uid from users
            where email = '".$email."';";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num > 0)
        return true;
    return false;
}
function insert_account($con, $uid, $password, $name, $email, $timestamp){
    $date = date("Y-m-d H:i:s", $timestamp);
    $sql = "insert into users
            values ('".$uid."', md5('".$password."'), '".$name."', '".$email."', '".$timestamp."');"
    mysqli_query($con, $sql); 

}
?>
