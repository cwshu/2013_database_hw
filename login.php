<?php
if(isset($_POST['uid']) && isset($_POST['password']))
{
function authentication($uid, $password){
    global $con;

    $sql = "select uid from users   
            where uid = '".$uid."'
            and password = md5('".$password."');";
    //echo $sql."<br />";
    $result = mysqli_query($con, $sql);
    //echo mysqli_num_rows($result); // no user/pwd match 
    if(mysqli_num_rows($result) == 0) // no user/pwd match 
        return false;
    return true;
    
}
    session_start();

    include "./db_connect.php";
    // connect db
    $con = db_connection();
    if(mysqli_connect_errno($con)){
        echo "Fail to connect to MySQL: ".mysqli_connect_error();
    }
    else{
        $uid = mysqli_real_escape_string($con, $_POST['uid']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        if(!authentication($uid, $password)){
            echo "wrong password";
        }
        else{ // login success, save user in session, and redirect to main page
            $_SESSION["uid"] = $uid;
            //echo $_SESSION["uid"];
            header("Location: ./main.php");
        }
    }
}
else
    echo "valid way to goto this page<br />";
?>

