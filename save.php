<?php
require('database.php');
try{
    $dbh= new PDO('mysql:host='.$data_host.';dbname='.$name_database,$data_username,$data_password);
}catch(PDOException $e){
    echo $e->getMessage();
}
$event = $_POST['event'];
$scores = $_POST['scores'];
$sql = "SELECT * FROM rawScores WHERE event=?";
$check = $dbh->prepare($sql);
$check->execute(array($event));
if($check->rowCount() == 0){
    $nextSQL = "INSERT INTO rawScores(event,scoreArray) VALUES (?,?)";
    $addRaw = $dbh->prepare($nextSQL);
    $addRaw->execute(array($event,$scores));
}else{
    $update = "UPDATE rawScores SET scoreArray =? WHERE event=?";
    $updateRaw = $dbh->prepare($update);
    $updateRaw->execute(array($scores,$event));
    
}
?>