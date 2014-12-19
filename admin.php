<?php
include('header.php');
include('nav.php');
$display = new display;
$events= new events;
$stats = new stats;
//check forms

?>
<h3><a href="admin_events.php">Add and Change Active Events</a></h3>
<h3><a href="admin_teams.php">Add Teams</a></h3>
<h3><a href="admin_users.php">Users and Permissions</a></h3>
<h3><a href="final.php?division=B">Confirm B Rankings</a></h3>
<h3><a href="final.php?division=C">Confirm C Rankings</a></h3>
<!--<h3>Current Competition</h3>
<table class="table table-striped table-bordered table-condensed table-hover">
    <tr><th><a href="admin_comp.php">Event Scoring Completed</a></th><th>Event Scoring Started</th><th>Event Scoring Unstarted</th></tr>
    <tr><td><?php echo $stats->numberCompleted();?>/<?php echo $events->number_events(); ?></td><td>Statistics Here</td><td>Statistics Here</td></tr>
</table>-->