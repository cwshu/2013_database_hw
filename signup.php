<!--
insert into users values ("ubuntu", md5("ubuntu"), "Ubuntu", "Ubuntu@linux.unix", "2004-10-20");
-->
<?php
function is_uid_exist($uid){
    global $con;
    $sql = "select uid from users
            where uid = '".$uid."';";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num > 0)
        return true;
    return false;
}
/*
function is_email_exist($con, $email){
    $sql = "select uid from users
            where email = '".$email."';";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num > 0)
        return true;
    return false;
}*/
function insert_account($uid, $password, $name, $email, $birthday, $sex){
    global $con;
    //$date = date("Y-m-d H:i:s", time());
    $sql = "insert into users
            values ('".$uid."', md5('".$password."'), '".$name."', '".$email."', '".$birthday."','".$sex."');";
    echo $sql;
    mysqli_query($con, $sql); 
}

function is_full_info(){
    if($_POST["uid"] == "") return False;
    if($_POST["password"] == "") return False;
    if($_POST["password_again"] == "") return False;
    if($_POST["name"] == "") return False;
    if($_POST["email"] == "") return False;
    if($_POST["birthday"] == "") return False;
    if(!isset($_POST["sex"])) return False;
    return True;
}

// main
if(!is_full_info()) echo "Please fill in whole information";
else if($_POST["password"] != $_POST["password_again"]) echo "Password is different from password again";
else{
    include "./db_connect.php";
    // connect db
    $con = db_connection();
    if(mysqli_connect_errno($con)){
        echo "Fail to connect to MySQL: ".mysqli_connect_error();
    }
    else{
        $uid = mysqli_real_escape_string($con, $_POST["uid"]);
        $password = mysqli_real_escape_string($con, $_POST["password"]);
        $name = mysqli_real_escape_string($con, $_POST["name"]);
        $email = mysqli_real_escape_string($con, $_POST["email"]);
        $birthday = mysqli_real_escape_string($con, $_POST["birthday"]);
        $sex = $_POST["sex"];

        if(is_uid_exist($uid)) echo "This account is already used";
        else{
            insert_account($uid, $password, $name, $email, $birthday, $sex);
            echo "<script>alert(\"sign up success, please relogin!!\")</script>";
            echo "<a href=\"./index.php\">Back to homepage</a>";
        }
    }
}
?>
