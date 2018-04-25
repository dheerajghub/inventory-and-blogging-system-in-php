<!doctype html>
<html>
<?php 
    session_start();
    if(isset($_SESSION['user'])){
        header('location:home.php');
    }
?>
<body>
<h1>Hello world!</h1>
<a href="login.php">LOGIN</a>
<a href="register.php">REGISTER</a>
</body>
</html>