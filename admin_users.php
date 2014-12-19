<?php
include('header.php');
include('nav.php');
if($_SESSION['type']!=1){
    echo '<a href="login.php">Please Login</a>';
    die();
}
$user = new user;
if($_POST['admin']){
    $user->add_user($_POST['adminName'],$_POST['adminPass'],1,999);
}
if($_POST['score']){
    $user->add_user($_POST['scoreName'],$_POST['scorePass'],2,999);
}
if($_POST['event']){
    $user->add_user($_POST['supName'],$_POST['supPass'],3,0);
}
if($_POST['update']){
    $input = implode(",",$_POST['events']);
    $userID = $_POST['userID'];
    $user->update_permissions($userID,$input);
}
?>
<div class="row">
 <div class="col-md-6">
<h2>Administrators</h2>
<h3>Add Administrator</h3>
<form method="POST" action="" class="form-horizontal" role="form">
    Username:<input type="text" class="form-control" name="adminName"/><br/>
    Password: <input type="text" class="form-control" name="adminPass"/><br/>
    <input type="submit" value="Add Administrator" class="btn btn-primary" name="admin"/>
</form>
<h3>Current Administrators</h3>
<?php $dis = new display; echo $dis->list_admins();?>
   </div> <div class="col-md-6">
<h2>Score Counselor</h2>
<h3>Add Score Counselor</h3>
<form method="POST" action="" class="form-horizontal" role="form">
    Username:<input type="text"  class="form-control" name="scoreName"/><br/>
    Password: <input type="text" class="form-control" name="scorePass"/><br/>
    <input type="submit" value="Add Score Couselor" class="btn btn-primary" name="score" />
</form>
<h3> Current Score Counselors</h3>
<?php $dis = new display; echo $dis->list_counselors();?>
   </div>
</div>
   
   <div class="">
<h2>Event Supervisors</h2>
<h3>Add Event Supervisor</h3>
<form method="POST" action="" class="form-horizontal" role="form">
    Username:<input type="text" class="form-control" name="supName"/><br/>
    Password: <input type="text" class="form-control" name="supPass"/><br/>
    <input type="submit" value="Add Event Supervisor" class="btn btn-primary" name="event"/>
</form>
<h3>Current Event Supervisors</h3>
<?php $dis = new display; echo $dis->event_sup_table();?>
  </div>