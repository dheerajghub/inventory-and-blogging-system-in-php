<?php 
session_start();
if($_SESSION['user']){
    $user = $_SESSION['user'];
}
else{
    header("location:index.php");
}
?>
<html>
<body>
    <h1>Hello <?php echo $user;?></h1>
    <a href="logout.php">logout</a><br>
    <a href="addsupplier.php">add supplier</a><br>
    <a href="showsupplier.php">watch suppliers</a><br>
    <a href="blog.php">blog page</a>
</body>
</html>