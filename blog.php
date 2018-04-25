<!DOCTYPE html>
<html lang="en">
<head>
   <title>Blog</title>
</head>
<body>
<?php
include('dbconnection.php'); 
include('sanitizer.php');
   if(!empty($_GET['msg'])){
    echo "<script>alert('".sanitizer($_GET['msg'])."');</script>";
}
?>
<a href="home.php">go back</a><hr>
<?php 
include('time.php');
$query ="select * from comments";
$result = mysqli_query($conn , $query);
while($row= mysqli_fetch_assoc($result)){
    echo "<fieldset style='background-color:#ddd;'>";
    echo "<legend style='background-color:darkblue; color:white;'>#".$row['id']."</legend>";
    echo "<form style='float:right;' action='core.php?type=delete_a_blog&id=".$row['id']."' method='post'>";
    echo "<input type='submit' value='&times;'>  
          </form>";
    echo "<small>created on (".$row['createdon'].")</small><hr>";
    echo "<p>".$row['comment']."</p>";
    if(!empty($row['image']))
    {
        echo "<center><img src=".$row['image']." width='50%'></center>";
    }
    echo "</fieldset><br>";
} 
?>
<hr>
<center><form action="core.php?type=blog" method="post" enctype="multipart/form-data">
    <textarea style="width:500px; height:50px;" placeholder="release your horses here...." name="comment"></textarea><br>
    <input type="file" name="filetoupload">
    <input type="submit" name="submit">
</form><br>
<form action="core.php?type=removeblog" method="POST">
    <input type="submit" value="clear all">
</form><br><hr>
</center>
</body>
</html>