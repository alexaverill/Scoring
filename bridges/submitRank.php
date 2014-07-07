<?php
require('../database.php');
try{
    $dbh= new PDO('mysql:host='.$data_host.';dbname='.$name_database,$data_username,$data_password);
}catch(PDOException $e){
    echo $e->getMessage();
}
$school = $_POST['school'];
$rank= $_POST['rank'];
    $update = "UPDATE teams SET rank=? WHERE teamName=?";
    $updateRaw = $dbh->prepare($update);
    $updateRaw->execute(array($rank,$school));

?>
