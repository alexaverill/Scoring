<?php
include('header.php');
include('nav.php');
$user = new user;
$permissions = $user->return_permissions($_SESSION['id']);

if($_SESSION['type']==2){
    echo'<h3>Score Counsler Select the Event:</h3>';
    $display = new display;
    $display->list_events(2,'B');
    $display->list_events(2,'C');
}
if($_SESSION['type']==3 && in_array(999,$permissions)){
   echo '<h3>Event Supervisor Select Your Event:</h3>';
$display = new display;
$display->list_events(1,'B');
$display->list_events(1,'C');
}
if($_SESSION['type']==3 && !in_array(999,$permissions)){
    //perms are equal to the event they are allowed to edit, thus we can do:
    $eventClass = new events;

        echo '<table class="table table-striped table-bordered table-condensed table-hover"
        style="float:left; width:400px; margin-left: 30px;"><tr><th>'.$division.' Division Events</th></tr>';
        foreach($permissions as $id){
           //echo $id;
                $div = $eventClass->get_event($id,2);
                $eventName = $eventClass->get_event($id,1);
                $link = 'scores.php?event='.$id;
                echo '<tr><td><a href='.$link.'>'.$div.' '.$eventName.'</a></td></tr>';
        }
        echo '</table>';
}
if($_SESSION['type']==1){
    $display = new display;
$events= new events;
$stats = new stats;
//check forms


echo '
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
';
}
?>