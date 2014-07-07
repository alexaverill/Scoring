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
    $update = "UPDATE scores SET confirmedScore=?,confirmedPlace=?,confirmed=? WHERE eventName=? AND teamName=?";
    $updateRaw = $dbh->prepare($update);
    $updateRaw->execute(array($score,$place,1,$event,$school));
    //set completed to 1 in event table
    $complete = "UPDATE events SET completed=? WHERE eventName=?";
    $setComplete = $dbh->prepare($complete);
    $setComplete->execute(array(1,$event));
    
?>
