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
if($_POST['resultsDis']){
    $settings->updateDisplaySetting($_POST['publicDisplay']);
}
if($_POST['statsDis']){
    $settings->updateStatsSetting($_POST['publicStats']);
}
$resultsDisplay = $settings->returnResultsDisplaySettings();
$statsDisplay = $settings->returnStatsSetting();

//var_dump($results);
echo $twig->render('adminSettings.html',array('DiplaySettings'=>$resultsDisplay,'DisplayStats'=>$statsDisplay));
?>