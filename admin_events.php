<?php
include('header.php');
include('nav.php');
if($_SESSION['type']!=1){
    echo '<a href="login.php">Please Login</a>';
    die();
}
$display = new display;
$events= new events;
if($_POST['activate']){
         foreach($_POST['setActive'] as $event){
                 $events->updateActive($event,1);
            }
}
if($_POST['deactivate']){
     foreach($_POST['setActive'] as $event){
                 $events->updateActive($event,2);
            }
}
if($_POST['delete']){
     foreach($_POST['setActive'] as $event){
                 $events->deleteEvent($event);
            }
}
if($_POST['add']){
    $events->add_events($_POST['event_name'],$_POST['division'],$_POST['type'],$_POST['method']);
}
if($_POST['unlock']){
    $events->unlock($_POST['eventName']);
}
?>
<h1>Events</h1>
<h2> Current Events</h2>
<ul>
<li>Click on the event name to edit.</li>
<li>Event being run will show up for event supervisors to add scores.</li></ul>
<form method="POST" action="">
    <h4>B Events</h4>

<?php
$display->admin_events('B');
?>
<h4>C Events</h4>
<?php
$display->admin_events('C');
?>

<input type="submit" name="activate" class="btn btn-primary" value="Being Run"/>
<input type="submit"  class="btn btn-warning" name="deactivate" value="Not Being Run"/>
<input type="submit"  class="btn btn-danger" name="delete" value="Delete Events"/>
</form>
<br/>
<h2>Add Events</h2>
<form method="POST" action="" class="form-horizontal col-xs-3" role="form">
    Event Name:<input type="text" class="form-control col-xs-3" name="event_name"/>
    <br/>Event Type:<select class="form-control col-xs-3" name="type"><option value="event" selected=selected>Official Event</option><option value="trial">Trial Event</option></select>
    <br/> Division: <select class="form-control col-xs-3" name="division"><option></option><option value="B">B</option><option value="C">C</option></select>
    <br/> Scoring Method: <select class="form-control col-xs-3" name="method"><option></option><option value="high">High Score Wins</option><option value="low">Low Score Wins</option></select>
    <br/><input class="btn btn-primary" type="submit" name="add" value="Add Event"/>
</form>
