<?php
include('header.php');
//include('nav.php');
if($_SESSION['type']!=1){
    echo '<a href="login.php">Please Login</a>';
    die();
}
$display = new display;
$events= new events;
$settings = new settings;
if($_POST['changeNumber']){
    $settings->changeAwards($_POST['number']);
}
$resultsNum = $settings->getAwards();
echo $resultsNum
$results = $display->return_top($resultsNum);
//var_dump($results);
echo $twig->render('adminResults.html',array('ResultsArray'=>$results));
?>