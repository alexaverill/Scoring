<?php
include('header.php');
$events = new events;
$eventsB= $events->return_events(1,'B');
$eventsC= $events->return_events(1,'C');

echo $twig->render('eventList.html',array('eventB'=>$eventsB,'eventC'=>$eventsC));
?>