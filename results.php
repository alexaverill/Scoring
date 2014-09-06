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
		<script src="source/editing.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Score Sheet</title>
		
	</head>           
              
              <?php
include('header.php');
$display = new display();
$events = new events();
$settings = new settings();
$division = 'B';
$teams = $display->return_teams_sorted($division);
$numTeams = $display->number_teams($division);
$listEvents = $events->return_events(1,$division);
$open = $settings->returnResultsDisplaySettings();
global $dbh;

?>
<?php include('nav.php');
if($open !=1){
       Echo '<h1>Results have not been made public yet, please check back later</h1>'
       die();
}
?>
              
<h1>B Division</h1><table  class="table table-striped table-condensed table-hover table-header-rotated"><thead><tr><th>Teams:</th>
<?php

foreach($listEvents as $event){
       echo '<th class="rotate-45"><div><span>'.$event['eventName'].'</span></div></th>';
    }

echo '<th class="rotate-45"><div><span>Final Score</span></div></th><th class="rotate-45"><div><span>Rank</span></div></th></tr></thead>';
$x=0;
foreach($teams as $team){
    $teamA = $team['teamNumber'].' '.$team['teamName'];
    echo '<tr><td id="'.$x.'team">'.$teamA.'</td>';
    $score =0;
    foreach($listEvents as $event){
        $eventName = $event['eventName'];
        //echo '<td>'.$eventName.'</td>';
        $sql = "SELECT * FROM scores WHERE eventName=? AND teamName=?";
        $returnPlace = $dbh->prepare($sql);
        $returnPlace->execute(array($eventName,$teamA));
        $returnPlace = $returnPlace->fetchAll();
        if($event['type']=='event'){ //only add to final score if not a trial.
              $score += $returnPlace[0]['confirmedPlace'];
        }
        echo '<td>'.$returnPlace[0]['confirmedPlace'].'</td>';
    }
    echo '<td id="'.$x.'score">'.$score.'</td>';
    echo '<td id="'.$x.'rank">'.$team['rank'].'</td></tr>';
    $x++;
    }
    
?>


</table>
<?php
$division = 'C';
$teams = $display->return_teams_sorted($division);
$numTeams = $display->number_teams($division);
$listEvents = $events->return_events(1,$division);
?>
<h1>C Division</h1><table  class="table table-striped table-condensed table-hover table-header-rotated"><thead><tr><th>Teams:</th>
<?php
foreach($listEvents as $event){
       echo '<th class="rotate-45"><div><span>'.$event['eventName'].'</span></div></th>';
    }

echo '<th class="rotate-45"><div><span>Final Score</span></div></th><th class="rotate-45"><div><span>Rank</span></div></th></tr></thead>';
$x=0;
foreach($teams as $team){
    $team = $team['teamNumber'].' '.$team['teamName'];
    echo '<tr><td id="'.$x.'team">'.$team.'</td>';
    $score =0;
    foreach($listEvents as $event){
        $eventName = $event['eventName'];
        //echo '<td>'.$eventName.'</td>';
        $sql = "SELECT * FROM scores WHERE eventName=? AND teamName=?";
        $returnPlace = $dbh->prepare($sql);
        $returnPlace->execute(array($eventName,$team));
        $returnPlace = $returnPlace->fetchAll();
        if($event['type']=='event'){ //only add to final score if not a trial.
              $score += $returnPlace[0]['confirmedPlace'];
        }
        echo '<td>'.$returnPlace[0]['confirmedPlace'].'</td>';
    }
    echo '<td id="'.$x.'score">'.$score.'</td>';
    echo '<td id="'.$x.'rank"></td></tr>';
    $x++;
    }
    
?>


</table>