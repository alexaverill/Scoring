<?php
require('../database.php');
try{
    $dbh= new PDO('mysql:host='.$data_host.';dbname='.$name_database,$data_username,$data_password);
}catch(PDOException $e){
    echo $e->getMessage();
}
$id = $_POST['id'];
$value = $_POST['value'];
$sql="UPDATE teams SET teamName=? WHERE teamName=?";
$run=$dbh->prepare($sql);
$run->execute(array($value,$id));
echo $value;
?>
