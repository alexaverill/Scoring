<?php
include('header.php');
//include('nav.php');
if($_SESSION['type']!=2){
    echo 'You do not have permission to view this page.';
    die();
}
$display = new display;
$event = new events;
$settings = new settings;
if(is_numeric($_GET['event'])){
    $id = $_GET['event'];
}else{
    $id = 0;
}
if($id !=0){
$eventName = $event->get_event($id,1);
$division = $event->get_event($id,2);
$numTeams = $display->number_teams($division);
}else{
    //throw error;
}
$rankType=$event->get_method($id);
if($rankType=='high'){
    $rankType='High to Low';
    $numRankType = 2;
}else if($rankType=='low'){
    $rankType='Low to High';
    $numRankType = 1;
}else{
    $rankType='High to Low';
    $numRankType = 2;
}
$teamsToRank = $settings->teamsToRank($division);
$scores = new scores;
$scoreData = $scores->return_scores($eventName);
//var_dump($scoreData);
echo $twig->render('counselor.html',array('ScoreData'=>$scoreData,'SortMethod'=>$numRankType,'NumberTeams'=>$numTeams,'EventName'=>$eventName,'TeamsToRank'=>$teamsToRank))
?>