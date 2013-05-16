<?php
    function logout(){
        session_start();
        unset($_SESSION['uid']);
    }
    logout();
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    Goodbye! <br />
    <a href="./index.php">Back</a>
</body>
</html>
