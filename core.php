<?php
session_start();
include('dbconnection.php');
include('sanitizer.php');
include('time.php');
function err($msg,$identifier){ 
    if($identifier =="reg"){
        header("Location:register.php?msg=".$msg);
        return false;
    }
    elseif($identifier == "log"){
        header('location:login.php?msg='.$msg);
        return false;
    }
    elseif($identifier == "supplier"){
       header("location:addsupplier.php?msg=".$msg); 
       return false;    
    }
    elseif($identifier == "editsupplier"){
        header("location:editsupplier.php?msg=".$msg); 
        return false;    
     }
     elseif($identifier == "deletesupplier"){
        header("location:showsupplier.php?msg=".$msg); 
        return false;    
     }
     elseif($identifier == "deletesupplier"){
        header("location:showsupplier.php?msg=".$msg); 
        return false;    
     } 
     elseif($identifier == "blog"){
        header("location:blog.php?msg=".$msg); 
        return false;    
     }
}
if($_SERVER['REQUEST_METHOD']== 'POST' && $_GET['type'] == 'log')
{
    function email_or_username($input){
        if(preg_match('/^[a-zA-Z]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',$input)){
            $identifier =  "email";
            return $identifier;
        }
        elseif(preg_match('/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/' , $input)){
            $identifier = "username";
            return $identifier;
        }
    }
    $input = sanitizer($_POST['input']);
    $password = sanitizer($_POST['password']);
    $query = "select * from user where ".email_or_username($input)." = '$input'";
    $result = mysqli_query($conn , $query);
    $exist = mysqli_num_rows($result); 
    if($exist > 0){
        $row = mysqli_fetch_assoc($result);
        $database_input = $row[email_or_username($input)];
        $database_pass = $row['password'];
        $username = $row['username'];
        if($input == $database_input && password_verify($password , $database_pass)){
            $_SESSION['user']=$username;
            header('location:home.php');
        }
        else{
            $msg = "wrong username/password combination!";
            err($msg , "log");
        }
    }
    else{
        $msg ="wrong login credentials!!";
        err($msg , "log");
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['type'] == 'reg'){
    
    function check_ones($username ,$email){
        global $conn;
        $query_username= "select * from user where username = '$username'";
        $query_email = "select * from user where email = '$email'";
        $result_username = mysqli_query($conn,$query_username);
        $result_email = mysqli_query($conn , $query_email);
        $exist_email = mysqli_num_rows($result_email);
        $exist_username = mysqli_num_rows($result_username); 
        if($exist_username >0 || $exist_email>0){
            return 1;
        }
        else{
            return 0;
        }
    }
    $username = sanitizer($_POST['username']);
    $email = sanitizer($_POST['email']);
    $age = sanitizer($_POST['age']);
    $pass = sanitizer($_POST['pass']);
    $cpass = sanitizer($_POST['cpass']);
    $hashed_pass = password_hash($pass , PASSWORD_DEFAULT);
    if(empty($username))
    {
        $msg = 'username is required!!';
        err($msg ,"reg");
    }
    elseif(empty($email)){
        $msg = 'email is required!!';
        err($msg , "reg");
    }
    elseif(empty($age)){
        $msg = 'age is required!!';
        err($msg, "reg");
    }
    elseif(empty($pass)){
        $msg ='password is required!!';
        err($msg, "reg");
    }
    elseif(empty($cpass)){
        $msg = 'confirm password!!';
        err($msg, "reg");
    }
    elseif(!is_numeric($age)||$age<=0|| $age>=100){
        $msg = "Invalid age";
        err($msg , "reg");
    }
    elseif(!preg_match("/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/",$username)){
        $msg = "invalid username!!";
        err($msg , "reg");
    }
    elseif(!preg_match("/^[a-zA-Z]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/" ,$email )){
        $msg = 'Invalid email!';
        err($msg , "reg");  
    }
    elseif(!preg_match("/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/" , $pass)){
        $msg = 'Invalid password';
        err($msg , "reg");
    }
    elseif($pass != $cpass){
        $msg = 'password is not matched!';
        err($msg, "reg");
    }
    elseif(check_ones($username ,$email)){
        $msg = 'Account with this name or email is already exist';
        err($msg ,"reg"); 
    }
    else
    {
        $query = "insert into user(username , email , age , password) values ('$username' ,'$email', '$age', '$hashed_pass')";
        $result = mysqli_query($conn , $query);
        if($result){
            $_SESSION['user'] = $username;
            header('location: home.php');
        }else{
            $msg = 'Request rejected';
            err($msg , "reg");
        }
    }
}
if($_SERVER['REQUEST_METHOD']=="POST" && $_GET['type']=="addsupplier"){
    $supplier_name = sanitizer($_POST['suppliername']);
    $supplier_company = sanitizer($_POST['suppliercompany']);
    $supplier_address = sanitizer($_POST['supplieraddress']);
    $supplier_contact = sanitizer($_POST['suppliercontact']);
    $supplier_email= sanitizer($_POST['supplieremail']);
    if(empty($supplier_name))
    {
        $msg="please enter supplier name";
        err($msg , "supplier");
    }
    elseif(empty($supplier_company))
    {
        $msg="please enter supplier company";
        err($msg , "supplier");
    }
    elseif(empty($supplier_address))
    {
        $msg="please enter supplier address";
        err($msg , "supplier");
    }
    elseif(empty($supplier_contact))
    {
        $msg="please enter supplier contact";
        err($msg , "supplier");
    }
    elseif($supplier_contact<0){
        $msg="neagtive number !!!";
        err($msg , "supplier");
    }
    elseif(!preg_match("/^[a-zA-Z]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",$supplier_email)){
        $msg="Invalid email!!";
        err($msg , "supplier");
    }
    elseif(!is_numeric($supplier_contact)){
        $msg="contact number should be number not characters!!!";
        err($msg , "supplier");
    }
    elseif(strlen($supplier_contact)!=12 && strlen($supplier_contact)!=10){
        $msg="invalid contact number!!";
        err($msg , "supplier");
    }
    else{
        $query = "insert into supplier(suppliername , suppliercompany ,supplieremail , supplieraddress , suppliercontact) values('$supplier_name' , '$supplier_company' , '$supplier_email'  , '$supplier_address' , '$supplier_contact')";
        $result = mysqli_query($conn , $query);
        if($result)
        {
            header('location:showsupplier.php');
        }
        else{
            $msg="Error occured";
            err($msg, "supplier");
        }
    }
}
if($_SERVER['REQUEST_METHOD']=="POST" && $_GET['type']=='editsupplier'){   
    $id = sanitizer($_GET['id']);
    $supplier_name = sanitizer($_POST['suppliername']);
    $supplier_company = sanitizer($_POST['suppliercompany']);
    $supplier_address = sanitizer($_POST['supplieraddress']);
    $supplier_contact = sanitizer($_POST['suppliercontact']);
    $supplier_email= sanitizer($_POST['supplieremail']);
    if(empty($supplier_name))
    {
        $msg="please enter supplier name";
        err($msg , "editsupplier");
    }
    elseif(empty($supplier_company))
    {
        $msg="please enter supplier company";
        err($msg , "editsupplier");
    }
    elseif(empty($supplier_address))
    {
        $msg="please enter supplier address";
        err($msg , "editsupplier");
    }
    elseif(empty($supplier_contact))
    {
        $msg="please enter supplier contact";
        err($msg , "editsupplier");
    }
    elseif($supplier_contact<0){
        $msg="neagtive number !!!";
        err($msg , "editsupplier");
    }
    elseif(!preg_match("/^[a-zA-Z]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",$supplier_email)){
        $msg="Invalid email!!";
        err($msg , "editsupplier");
    }
    elseif(!is_numeric($supplier_contact)){
        $msg="contact number should be number not characters!!!";
        err($msg , "editsupplier");
    }
    elseif(strlen($supplier_contact)!=12 && strlen($supplier_contact)!=10){
        $msg="invalid contact number!!";
        err($msg , "editsupplier");
    }
    else{
        $query = "update supplier set suppliername='$supplier_name' , suppliercompany = '$supplier_company' , supplieraddress = '$supplier_address' , supplieremail = '$supplier_email' , suppliercontact = '$supplier_contact' where id = '$id'";
        $result = mysqli_query($conn , $query);
        if($result)
        {
            header('location:showsupplier.php');
        }
        else{
            $msg="Error occured";
            err($msg, "editsupplier");
        }
    }
}   
if($_SERVER['REQUEST_METHOD']=="POST" && $_GET['type']=="delete"){
    $id = $_GET['id'];
    $query = "delete from supplier where id = '$id'";
    $result = mysqli_query($conn , $query);
    if($result){
        header('location:showsupplier.php');
    }
    else{
        $msg="Error occured";
        err($msg, "deletesupplier");
    }
}
if($_SERVER["REQUEST_METHOD"]=="POST" && $_GET["type"]=="blog"){
    $comment = sanitizer($_POST['comment']);
    $createdon = timepicker('#1');
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["filetoupload"]["name"]);
    $file = basename($_FILES['filetoupload']['name']);
    $imagetype = strtolower(pathinfo($target_file , PATHINFO_EXTENSION));
    if(empty($comment) && empty($file)){
        $msg="Comment section is empty!!";
        err($msg , "blog");
    }
    elseif(!empty($file))
    {   
        $check = getimagesize($_FILES['filetoupload']['tmp_name']);
        if($check == false){
                $msg = "choosen file".$target_file." is not an image!!!";
                err($msg,"blog");
        }
        elseif($_FILES['filetoupload']['size']>2000000)
        {
                $msg = "file is too large";
                err($msg , "blog");
        }
        elseif($imagetype!= "png" && $imagetype!= "gif" && $imagetype!= "jpeg" && $imagetype!= "jpg"){
                $msg = "image extension not matched!!";
                err($msg ,"blog");
        }
        elseif(move_uploaded_file($_FILES['filetoupload']['tmp_name'],$target_file))
                {
                        $query = "insert into comments(comment, createdon ,image) values('$comment','$createdon','$target_file')";
                        $result = mysqli_query($conn,$query);
                        if($result){
                            header('location:blog.php');
                        }
                        else{
                            $msg = "Error occured in query!!";
                            err($msg , "blog");
                        }
                }
                else{
                        $msg = "file is not uploaded!";
                        err($msg , "blog");
                }
    }
    elseif(empty($file))
    {
                    $query = "insert into comments(comment,createdon) values('$comment','$createdon')";
                    $result = mysqli_query($conn,$query);
                    if($result){
                        header('location:blog.php');
                    }
                    else{
                        $msg = "Error occured in query!!";
                        err($msg , "blog");
                    }
    }
}
if($_SERVER['REQUEST_METHOD']=="POST" && $_GET['type']=="delete_a_blog"){
    $query1 = "select image from comments where id =".$_GET['id'];
    $result1 = mysqli_query($conn , $query1);
    $row = mysqli_fetch_assoc($result1);
    if(!empty($row['image'])){
        unlink($row['image']);
    }
    $query2 = "delete from comments where id=".$_GET['id'];
    $result2 = mysqli_query($conn , $query2);
    if($result2){
        header('location:blog.php');
    }
    else{
        $msg ="Error in Query";
        err($msg , "blog");
    }
}
if($_SERVER['REQUEST_METHOD']=="POST" && $_GET['type']=="removeblog")
{
    $query = "select image from comments";
    $result = mysqli_query($conn ,$query);
    while($row = mysqli_fetch_assoc($result)){
        unlink($row['image']);
    }
    $query1 = "truncate table comments";
    $result1= mysqli_query($conn , $query1);
    if($result1){
        header('location:blog.php');
    }
    else{
        $msg = "Error in Query!!";
        err($msg ,"blog");
    }
}
?>