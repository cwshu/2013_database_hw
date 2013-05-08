<!-- login page -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="./index.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <title>facenote login</title>
</head>
<body>
    <div class="header">
        <h1>歡迎來到 Facenote</h1>
        <form method="post" action="login.php">
            <p class="account">Account: <br /><input type="text" name="uid" /></p>
            <p class="password">Password: <br /><input type="password" name="password" /></p>
            <input class="button" type="submit" value="login"/>
        </form>
    </div>
    <div class="body">
        Facenote 能幫助你與生活中的人們互相嘴砲，並與它們一起浪費寶貴的生命。
    </div>
    <form method="post" action="signup.php">
    <p>Account: <br /><input type="text" name="uid" /></p> <a href="./" target="_blank">驗證</a>
    <?php 
    date_default_timezone_set("Asia/Taipei");
    echo "<br />現在時間: ".date("Y-m-d H:i:s",time())."<br />
                "; ?>
    <!--
    jQuery :)
    <script>
        alert($("h1").text());
    </script>
    -->
</body>
</html>
