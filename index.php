<?php
    include_once "./base.php";
?>
<!-- login page -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="<?php echo "$static_path"?>index.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <title>Welcome Facenote!!!</title>
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
        <div class="msg">Facenote 能幫助你與生活中的人們互相嘴砲，<br />並與它們一起浪費寶貴的生命。</div>
        <div class="signup">
            <form method="post" action="signup.php">
                <div>Account: <input type="text" name="uid" /></div> 
                <div>Password: <input type="password" name="password" /></div>
                <div>Password again: <input type="password" name="password_again" /></div>
                <div>Name: <input type="text" name="name" /></div> 
                <div>Email: <input type="text" name="email" /></div> 
                <div>Birthday: <input type="text" name="birthday" /></div> 
                <div>Sex: 
                    <input type="radio" name="sex" value="M"/>Male 
                    <input type="radio" name="sex" value="F"/>Female
                </div> 
                <input class="button" type="submit" value="sign up"/>
            </form>
            <!-- <a href="./" target="_blank">驗證</a> -->
        </div>
        <!--
        <form method="post" action="test.php">
            <div><input type="hidden" name="postid" value="123456" /></div>
            <div><input type="submit" value="x"></div>
        </form>
        -->
    </div>
    <!--
    <div>
        <img src=".\static\中文喔.png" />
    </div>
    -->
    <?php 
    /*
    date_default_timezone_set("Asia/Taipei");
    echo "<br />現在時間: ".date("Y-m-d H:i:s",time())."<br />
                ";*/ ?>
    <!--
    jQuery :)
    <script>
        alert($("h1").text());
    </script>
    -->
</body>
</html>
