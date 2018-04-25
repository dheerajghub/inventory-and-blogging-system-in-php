<?php
function sanitizer($string){
    global $conn;
    $string = htmlspecialchars($string);
    $string = stripslashes($string);
    $string = trim($string);
    $string = strip_tags($string); 
    $string = mysqli_real_escape_string($conn ,$string);
    return $string;
}?>