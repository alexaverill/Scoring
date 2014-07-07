<?php
include('header.php');
include('nav.php');
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
if($_POST['add']){
    $events->add_events($_POST['event_name'],$_POST['division'],$_POST['type'],$_POST['method']);
}
if($_POST['unlock']){
    $events->unlock($_POST['eventName']);
}
?>
<h1>Events</h1>
<h2> Current Events</h2>
<form method="POST" action="">
    <h4>B Events</h4>
<?php
$display->admin_events('B');
?>
<h4>C Events</h4>
<?php
$display->admin_events('C');
?>
<input type="submit" name="activate" value="Activate"/><input type="submit" name="deactivate" value="Deactivate"/>
</form>
<br/>
<h2>Add Events</h2>
<form method="POST" actio="">
    Event Name:<input type="text" name="event_name"/>
    <br/>Event Type:<select name="type"><option></option><option value="event">Normal Event</option><option value="trial">Trial Event</option></select>
    <br/> Division: <select name="division"><option></option><option value="B">B</option><option value="C">C</option></select>
    <br/> Scoring Method: <select name="method"><option></option><option value="high">High Score Wins</option><option value="low">Low Score Wins</option></select>
    <br/><input type="submit" name="add" value="Add Event"/>
</form>
