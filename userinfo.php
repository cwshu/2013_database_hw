<!-- user information 
name
email
birthday
back to main page
-->
<!--
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>user information</title>
</head>
<body>
    <h1>$username</h1>
    <p>
        Email: $email
        Birthday: $birthday
        <a href="./main.php">Back to main page</a>
    </p>
    <a href="./logout.php">Logout</a>
</body>
</html>
-->

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />
    <link rel="stylesheet" href="./base.css">
    <title>user information</title>
</head>
<body>
<?php
include "./db_connect.php";
include "./base.php";
$con = db_connection();
if(mysqli_connect_errno($con))
{
    echo "Fail to connect to MySQL: ".mysqli_connect_error();
}
else
{ 
    session_start();
    $user = $_GET["id"];  // the user of userinfo page;

    $sql = "select name, email, birthday from users where uid ='".$user."';";
    //username, email, birthday for $user
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $username = $row["name"];
    $email = $row["email"];
    $birthday = $row["birthday"];

    $html_header = tem_html_header("$user");
    $html_userinfo = "
        <div>
            <h1>".$username."</h1>
            <p>
                Email: ".$email." <br />
                Birthday: ".$birthday." <br />
                <a href=\"./main.php\">Back to main page</a>
            </p>
            <a href=\"./logout.php\">Logout</a>
        </div>";

    $html_page = $html_header.$html_userinfo;
    echo $html_page;
}
?>

</body>
</html>
