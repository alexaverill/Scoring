<?php
include('header.php');
//include('nav.php');
if($_SESSION['type']!=1){
    echo '<a href="login.php">Please Login</a>';
    die();
}
$display = new display;
$events= new events;
if($_POST['changeNumber']){
    
}
$results = $display->return_top();
//var_dump($results);
echo $twig->render('adminResults.html',array('ResultsArray'=>$results));
?>