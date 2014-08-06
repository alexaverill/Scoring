<?php
include('header.php');
include('nav.php');
if($_SESSION['type']!=1){
    echo '<a href="login.php">Please Login</a>';
    die();
}
$display = new display;
$events= new events;
if($_POST['teams']){
   $display->add_teams($_POST['teamName'],$_POST['teamNumber'],$_POST['div']);
}
?>
<h1>Teams</h1> 
<form method="POST" action="">
    Team Number:<input type="text" name="teamNumber"/>  Team Name:<input type="text" name="teamName"/>  Division: <select name="div"><option></option><option value="B">B</option><option value="C">C</option></select>
    <input type="submit" value="Add Team" name="teams"/>
</form>
           <h3>Upload Teams</h3>
        <b>Your Excel (.xls) should look like <a href="source/example.xls">this</a></b> 
        <br/><br/>
        <form enctype="multipart/form-data" action="" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
            Choose a sheet to upload: <input name="uploadedfile" id="file" type="file" /><br/>
            <input type="submit" name="up" value="Upload File" />
        </form>
<h3>Current Teams</h3>
<ul>
   <li>Click to edit</li>
</ul>
<?php
    $display->table_of_teams();
?>