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
$rationalNum = $resultsNum+1;
$results = $display->return_top($rationalNum);
//var_dump($results);
echo $twig->render('adminResults.html',array('ResultsArray'=>$results,'NumberAwards'=>$resultsNum));
?>