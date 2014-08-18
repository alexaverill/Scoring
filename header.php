<?php
include('database.php');
require_once './Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader, array(
    
));
if (version_compare(phpversion(), '5.5.0', '<')) {
    //If the php Version is not supporting password hash, lets include it
    require('source/lib/password.php');
}
try{
    $dbh= new PDO('mysql:host='.$data_host.';dbname='.$name_database,$data_username,$data_password);
}catch(PDOException $e){
    echo $e->getMessage();
}
session_start();
include('classes.php');

?>
<?php
/*if(!($_SESSION['loggedin'])){
    echo '<a href="login.php">Please Login</a>';
    //die();
}*/
?>
