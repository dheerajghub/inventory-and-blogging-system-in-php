<?php
function timepicker($string){
    if($string == "#1") 
    {
        date_default_timezone_set("Asia/Kolkata");
        $time =  Date("j M, g:i a");
        return $time;
    }
}

?>