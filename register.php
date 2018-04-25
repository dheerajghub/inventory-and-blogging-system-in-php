<!doctype html>
<html>
<body>
<?php
include('dbconnection.php');
include('sanitizer.php');
if(!empty($_GET['msg'])){
    echo "<Script>alert('".sanitizer($_GET['msg'])."');</script>";
}?>
<a href="index.php">go back</a><br><hr>
<form action = "core.php?type=reg" method="post">
username:
<input type="text" name="username"><br><hr>
email:
<input type="text" name="email"><br><hr>
age:
<input type="number" name="age"><br><hr>
password:
<input type="password" name="pass"><br>
(note:password must contains uppercase,lowercase,specialchar,number,min length 8)
<hr>
confirm password:
<input type="password" name="cpass"><br><hr>
<input type="submit" value="submit">
</form>
</body>
</html>