<?php
include('header.php');
include('nav.php');
?>
<h3>Event Supervisor Select Your Event:</h3>
<?php
$display = new display;
$display->list_events(1,'B');
$display->list_events(1,'C');
?>