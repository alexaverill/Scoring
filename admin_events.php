<?php
include('header.php');
include('nav.php');
if($_SESSION['type']!=1){
    echo '<a href="login.php">Please Login</a>';
    die();
}
$display = new display;
$events= new events;
if($_POST['activate']){
         foreach($_POST['setActive'] as $event){
                 $events->updateActive($event,1);
            }
}
if($_POST['deactivate']){
     foreach($_POST['setActive'] as $event){
                 $events->updateActive($event,2);
            }
}
if($_POST['delete']){
     foreach($_POST['setActive'] as $event){
                 $events->deleteEvent($event);
            }
}
if($_POST['add']){
    $events->add_events($_POST['event_name'],$_POST['division'],$_POST['type'],$_POST['method']);
}
if($_POST['unlock']){
    $events->unlock($_POST['eventName']);
}
$EventClass = new events;
$eventsB = $EventClass->return_events(3,'B');
$eventsC = $EventClass->return_events(3,'C');
echo $twig->render('adminEvent.html',array('BEvents'=>$eventsB,'CEvents'=>$eventsC));
?>
