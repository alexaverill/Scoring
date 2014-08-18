<?php
include('header.php');
include('nav.php');
if($_SESSION['type']!=1){
    echo '<a href="login.php">Please Login</a>';
    die();
}
$display = new display;
$events= new events;
$settings = new settings;
if($_POST['udateTeamRankB']){
   $settings->updateTeamsToRank('B',$_POST['numberB']);
}
if($_POST['udateTeamRankC']){
   $settings->updateTeamsToRank('C',$_POST['numberC']);
}
$numTeamsB = $display->number_teams('B');
$numRankB = $settings->teamsToRank('B');
$numRankC = $settings->teamsToRank('C');
$numTeamsC = $display->number_teams('C');
if($_POST['teams']){
   $display->add_teams($_POST['teamName'],$_POST['teamNumber'],$_POST['div']);
}
if($_POST['up']){
   $up = new uploads;
    $up->upload($_FILES['uploadedfile']['name'],$_FILES['uploadedfile']['tmp_name']);
}
echo $twig->render('adminTeam.html',array());
?>
