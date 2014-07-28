<?php
echo '<META HTTP-EQUIV=Refresh CONTENT=".5; URL=login.php">';
include('header.php');
echo '<h1>Logout</h1>';
session_unset(); 
session_destroy(); 
echo 'You have logged out';

?>