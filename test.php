<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="./styletest.css">
    <title>main</title>
</head>
<body>
    <div class="fixed-header" >
        Welcome $Username !<br />
        <a href="./userinfo.php">User Info</a>
        <a href="./logout.php">Logout</a>
    </div>
    <div class="header">
        Welcome $Username !<br />
        <a href="./userinfo.php">User Info</a>
        <a href="./logout.php">Logout</a>
    </div>
    <div class="content1">
        <div class="article">
            <div>
                <p>$user1 says</p>
                <p class="border">$msg1</p>
                <p>$date1</p>
            </div>
            <div>
                <p>$user2 says </p>
                <p class="border">$msg2</p>
                <p>$date2</p>
            </div>
        </div>
        <div class="friends">
           <h1>Friends</h1>
           $Friend1 <br />
           $Friend2 <br />
        </div>
    </div>
</body>
</html>
<!--
    <table>
        <tr>
            <td class="article">
                <p>
                    <span>$user1 says</span> <br/>
                    <span class="border">$msg1</span> <br/>
                    <span>$date1</span>
                </p>
                <p>
                    $user2 says <br/>
                    <span>$msg2</span> <br/>
                    $date2
                </p>
            </td>
            <td class="friends">
               <h1>Friends</h1>
               $Friend1 <br />
               $Friend2 <br />
            </td>
        </tr>
     </table>
-->
