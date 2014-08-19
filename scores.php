<?php
include('header.php');
$user = new user;
$display = new display;
$permissions = $user->return_permissions($_SESSION['id']);
$settings = new settings;
$event = new events;
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
    //event not found.
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
$teams = $display->return_teams($division);
$teamsToRank = $settings->teamsToRank($division);
if(in_array($id,$permissions) || in_array(999,$permissions)){
    echo $twig->render('scores.html',array('TeamList'=>$teams,'SortMethod'=>$numRankType,'NumberTeams'=>$numTeams,'EventName'=>$eventName,'TeamsToRank'=>$teamsToRank));
}else{   
    echo 'You do not have permission to view that event.';
}

?>