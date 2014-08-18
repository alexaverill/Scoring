<?php
include('header.php');
include('nav.php');
if($_SESSION['type']!=1){
    echo '<a href="login.php">Please Login</a>';
    die();
}
$user = new user;
if($_POST['admin']){
    $user->add_user($_POST['adminName'],$_POST['adminPass'],1,999);
}
if($_POST['score']){
    $user->add_user($_POST['scoreName'],$_POST['scorePass'],2,999);
}
if($_POST['event']){
    $user->add_user($_POST['supName'],$_POST['supPass'],3,0);
}
if($_POST['update']){
    $input = implode(",",$_POST['events']);
    $userID = $_POST['userID'];
    $user->update_permissions($userID,$input);
}
$user = new user;
$events = new events;
$UserList = $user->return_users(3);
$eventsB= $events->return_events(1,'B');
$eventsC= $events->return_events(1,'C');
echo $twig->render('adminUsers.html',array('UserList'=>$UserList,'EventListB'=>$eventsB,'EventListC'=>$eventsC));
?>
