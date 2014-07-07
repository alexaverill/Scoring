<?php
include('header.php');

$display = new display;
if(isset($_GET['event'])){
    $eventId = $_GET['event'];
}else{
    
     
}
if($eventId == 0 ){
   
}else{
    $display->score_sheet($eventId);
}

?>