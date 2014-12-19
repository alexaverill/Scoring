<?php
require('../database.php');
try{
    $dbh= new PDO('mysql:host='.$data_host.';dbname='.$name_database,$data_username,$data_password);
}catch(PDOException $e){
    echo $e->getMessage();
}
$event = $_POST['event'];
$school = $_POST['school'];
$place = $_POST['place'];
$tier = $_POST['tier'];
$score = $_POST['score'];
$tiePlace = $_POST['placeInTie'];
$final = $_POST['locked'];
$sql = "SELECT * FROM  scores WHERE eventName=? AND teamName=? ";
$check = $dbh->prepare($sql);
$check->execute(array($event,$school));
$hold = $check->fetchAll();
$locked = $hold[0]['locked'];
if($check->rowCount() == 0){
    //if the schools record does not exist insert a new one
    $nextSQL = "INSERT INTO scores(eventName,teamName,score,placeInTie,tier,place) VALUES (?,?,?,?,?,?)";
    $addRaw = $dbh->prepare($nextSQL);
    $addRaw->execute(array($event,$school,$score,$tiePlace,$tier,$place));
}else if($final == 1 && $locked !=1 ){
    //If the submission is the final submission, it will lock the event, then will set the event to be completed in the event table
    $update = "UPDATE scores SET score=?,tier=?,place=?,locked=? WHERE eventName=? AND teamName=?";
    $updateRaw = $dbh->prepare($update);
    $updateRaw->execute(array($score,$tier,$place,1,$event,$school));
    //This locks the event in the events table.
    $setComplete = "UPDATE events SET completed=? WHERE eventName=?";
    $set = $dbh->prepare($setComplete);
    $set->execute(array(1,$event));
}else if($locked != 1){
    //as long as the scores are not locked, and there exists a school row, just update
    $update = "UPDATE scores SET score=?,placeInTie=?,tier=?,place=? WHERE eventName=? AND teamName=?";
    $updateRaw = $dbh->prepare($update);
    $updateRaw->execute(array($score,$tiePlace,$tier,$place,$event,$school));
    
}else{
    echo "Scores are locked";
}
?>
