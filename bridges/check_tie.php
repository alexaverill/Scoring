<?php
require('../database.php');
try{
    $dbh= new PDO('mysql:host='.$data_host.';dbname='.$name_database,$data_username,$data_password);
}catch(PDOException $e){
    echo $e->getMessage();
}
$school = $_POST['team'];
$place = $_POST['place'];
$sql = "SELECT * FROM scores WHERE confirmedPlace=? AND teamName=?";
$check = $dbh->prepare($sql);
$check->execute(array($place,$school));
$number = $check->rowCount();
echo $number;

?>
