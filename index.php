<html>
	<head>
		<script type="text/javascript" src="source/jquery-2.1.1.min.js"></script>
		<script src="source/jquery.jeditable.js" type="text/javascript"></script>
				<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="source/bootstrap/css/bootstrap.css">
		<!-- Extra Themes -->
		<link rel="stylesheet" href="source/parts.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="source/bootstrap/js/bootstrap.min.js"></script>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Score Sheet</title>
		<script type="text/javascript" src="source/jquery-2.1.1.min.js"></script>
		<script src="source/editing.js"></script>
		
	</head>
	
	<body>
	
<?php
include('header.php');
include('nav.php');
?>
<div class="class="container-fluid">
<?php
$user = new user;
$permissions = $user->return_permissions($_SESSION['id']);

if($_SESSION['type']==2){
    echo'<h3>Score Counsler Select the Event:</h3>';
    $display = new display;
    $display->list_events(2,'B');
    $display->list_events(2,'C');
}
if(($_SESSION['type']==3 && in_array(999,$permissions))){
   echo '<h3>Event Supervisor Select Your Event:</h3>';
$display = new display;
$display->list_events(1,'B');
$display->list_events(1,'C');
}
if($_SESSION['type']==3 && !in_array(999,$permissions)){
    //perms are equal to the event they are allowed to edit, thus we can do:
    $eventClass = new events;

        echo '<table class="table table-striped table-bordered table-condensed table-hover"
        style="float:left; width:400px; margin-left: 30px;"><tr><th>'.$division.' Division Events</th></tr>';
        foreach($permissions as $id){
           //echo $id;
                $div = $eventClass->get_event($id,2);
                $eventName = $eventClass->get_event($id,1);
                $link = 'scores.php?event='.$id;
                echo '<tr><td><a href='.$link.'>'.$div.' '.$eventName.'</a></td></tr>';
        }
        echo '</table>';
}
if($_SESSION['type']==1){
	   echo '<h2>Enter Scores</h2>';
$display = new display;
$display->list_events(1,'B');
$display->list_events(1,'C');
    echo'<h2>Verify Event Scores</h2>';
    $display = new display;
    $display->list_events(2,'B');
    $display->list_events(2,'C');
}
?>