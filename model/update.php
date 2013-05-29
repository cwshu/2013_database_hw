<?php
// Notice: You should define "Global Variable $con" 
//         for your database connection (procedure style, not object-oriented style)
//         before using following functions

function update_userinfo($uid, $name, $email, $birthday){
    global $con;
    $name = htmlspecialchars($name);
    $email = htmlspecialchars($email);
    $birthday = htmlspecialchars($birthday);

    $sql = "update users set name = '".$name."', email = '".$email."',
            birthday = '".$birthday."' where uid = '".$uid."'";
    if(mysqli_query($con, $sql))
        return true;
    return false; 
}
function update_icon($uid, $file_ext){
    global $con;

    $sql = "update users set icon = '".$file_ext."' where uid = '".$uid."'";
    if(mysqli_query($con, $sql))
        return true;
    return false;
}
//function delete_icon($uid){ }
    
?>
