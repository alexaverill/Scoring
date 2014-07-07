<?php
include('header.php');
include('nav.php');
?>
<h3>Score Counsler Select the Event:</h3>
<?php
$display = new display;
$display->list_events(2,'B');
$display->list_events(2,'C');
?>