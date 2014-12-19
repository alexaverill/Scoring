<?php
/*
calculate final scores and store them in the database. Then for every score check if there are other scores like it, if so,
pull those scores out of the database. Then for each team that is tied, check to see its total number of each place, then loop through till all
ties are broken
*/

include('header.php');
$division = 'B';
calculateScores($division);
rank($division);
function calculateScores($division){
    global $dbh;
    $display = new display();
    $events = new events();
    $teams = $display->return_teams($division);
    $numTeams = $display->number_teams($division);
    $listEvents = $events->return_events(1,$division);
foreach($teams as $team){
    $trueTeam = $team['teamName'];
    $team = $team['teamNumber'].' '.$team['teamName'];
    $score =0;
        foreach($listEvents as $event){
            $eventName = $event['eventName'];
            //echo '<td>'.$eventName.'</td>';
            $sql = "SELECT * FROM scores WHERE eventName=? AND teamName=?";
            $returnPlace = $dbh->prepare($sql);
            $returnPlace->execute(array($eventName,$team));
            $returnPlace = $returnPlace->fetchAll();
            $score += $returnPlace[0]['confirmedPlace'];
        }
        $updateScores= "UPDATE teams SET finalScore=? WHERE teamName=?";
        $addScore = $dbh->prepare($updateScores);
        $addScore->execute(array($score,$trueTeam));
    }
    
}
function check_ties($score,$division){
    global $dbh;
    $sql= "SELECT * FROM teams WHERE division=? and finalScore =?";
    $get = $dbh->prepare($sql);
    $get->execute(array($division,$score));
    $row = $get->rowCount();
    if($row>1){
        return true;
    }else{
        return false;
    }
}
function get_place($school,$place){
       global $dbh;
    $sql = "SELECT * FROM scores WHERE confirmedPlace=? and teamName=?";
    $getting = $dbh->prepare($sql);
    $getting->execute(array($place,$school));
    $places = $getting->rowCount();
    return $places;
}

function fix_ties($score,$division,$place,$call,$placeEnter){
    global $dbh;
    echo $call.'<br/>';
    echo $placeEnter.'<br/>';
    $num_score = $score;
    $sql= "SELECT * FROM teams WHERE division=? and finalScore =?";
    $get = $dbh->prepare($sql);
    $get->execute(array($division,$score));
    $information = array();
    $x=0;
    //get places and store them.
    foreach($get->fetchAll() as $score){
        $places = get_place($score['teamNumber'].' '.$score['teamName'],$place);
        $sql = "UPDATE teams SET numberPlaces =? WHERE teamName=? AND tieBroken=0";
        $up = $dbh->prepare($sql);
        $up->execute(array($places,$score['teamName']));
        $x++;
    }
    //now that we have places lets sort?
    $sql = "SELECT * FROM teams WHERE finalScore=? and division=? and tieBroken=0 ORDER BY numberPlaces DESC";
    $order = $dbh->prepare($sql);
    $order->execute(array($num_score,$division));
   $order = $order->fetchAll();
   $length  = count($order);
   $x = 0;
   //var_dump($order);
   for($y = 0; $y<$length; $y++){
    //echo $place.':'.$order[$y]['numberPlaces'].' '.$order[$y+1]['numberPlaces'].' '.$order[$y-1]['numberPlaces'].'<br/>';
    if($y-1>=0 && $y+1<=$length){
    if($order[$y]['numberPlaces'] != $order[$y-1]['numberPlaces'] && $order[$y]['numberPlaces'] != $order[$y+1]['numberPlaces']   ){
        $sql = "UPDATE teams SET tieBroken = ? WHERE teamName=?";
        $go = $dbh->prepare($sql);
        $go->execute(array($placeEnter,$order[$y]['teamName']));
        echo 'Updated '.$placeEnter.'<br/>';
        $placeEnter+=1;
    }else{
        fix_ties($num_score,$division,$place+1,$call+1,$placeEnter);
    }
    }
   }
   echo '<br/>';
}
function rank($division){
    global $dbh;
    $sql = "SELECT * FROM teams WHERE division=? ORDER BY finalScore ASC";
    $get = $dbh->prepare($sql);
    $get->execute(array($division));
    $x=0;
    $scores = array();
    foreach ($get->fetchAll() as $data){
        $update = "UPDATE teams SET rank=? WHERE teamName=?";
        $go = $dbh->prepare($update);
        $go->execute(array(($x+1),$data['teamName']));
        $scores[$x]=$data['finalScore'];
        $x++;
    }
    fix_ties(11,'B',1,1,1);
     var_dump(array_keys($scores,11));
}