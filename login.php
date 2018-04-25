<!doctype html>
<html>
<body>
<?php 
include('dbconnection.php');
include('sanitizer.php');
if(!empty($_GET['msg'])){
    echo "<script>alert('".sanitizer($_GET['msg'])."')</script>";
}
?>
<a href="index.php">go back</a><br><hr>
<form action="core.php?type=log" method="post">
username or email:
<input type="text" name="input"><br><hr>
password:
<input type="password" name="password"><br><hr>
<input type="submit" value="submit">
</form>
</body>
</html>