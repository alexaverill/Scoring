<?php
include('header.php');
include('nav.php');
$display = new display;
$events= new events;
//check forms
//select from evnets where completed = 1
$display->list_comp_events();
?>