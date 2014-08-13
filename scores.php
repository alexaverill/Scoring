<?php
include('header.php');
$user = new user;
$display = new display;
$permissions = $user->return_permissions($_SESSION['id']);
if(isset($_GET['event'])){
    $eventId = $_GET['event'];
}else{
    
     
}
if(in_array($eventId,$permissions) || $permissions == 999){
    $display->score_sheet($eventId);
}else{
    echo 'You do not have permission to view that event.';
}

?>