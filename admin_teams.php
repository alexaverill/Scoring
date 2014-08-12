<?php
include('header.php');
include('nav.php');
if($_SESSION['type']!=1){
    echo '<a href="login.php">Please Login</a>';
    die();
}
$display = new display;
$events= new events;
$settings = new settings;
if($_POST['udateTeamRankB']){
   $settings->updateTeamsToRank('B',$_POST['numberB']);
}
if($_POST['udateTeamRankC']){
   $settings->updateTeamsToRank('C',$_POST['numberC']);
}
$numTeamsB = $display->number_teams('B');
$numRankB = $settings->teamsToRank('B');
$numRankC = $settings->teamsToRank('C');
$numTeamsC = $display->number_teams('C');
if($_POST['teams']){
   $display->add_teams($_POST['teamName'],$_POST['teamNumber'],$_POST['div']);
}
if($_POST['up']){
   $up = new uploads;
    $up->upload($_FILES['uploadedfile']['name'],$_FILES['uploadedfile']['tmp_name']);
}

?>
<h1>Teams</h1> 
<form method="POST" action="" class="form-inline" role="form">
    Team Number:<input type="text" class="form-control" placeholder="B01" name="teamNumber"/>
    Team Name:<input type="text" class="form-control" placeholder="Team A" name="teamName"/>
    Division: <select class="form-control" name="div"><option></option><option value="B">B</option><option value="C">C</option></select>
    <input type="submit"  value="Add Team" class="btn btn-primary" name="teams"/>
</form>
           <h3>Upload Teams</h3>
        <b>Your Excel (.xls) should look like <a href="source/example.xls">this</a></b> 
        <br/><br/>
        <form enctype="multipart/form-data" action="" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
            Choose a sheet to upload: <input name="uploadedfile" id="file" type="file" /><br/>
            <input type="submit" name="up" class="btn btn-primary" value="Upload File" />
        </form>
<h3>Current Teams</h3>
<ul>
   <li>Click team names or numbers to edit</li>
</ul>
<h3>Number of Teams to Rank B</h3>
<form method="POST" action="">
   Suggested: <?php echo ceil($numTeamsB/2);  ?><br/>
   <select name="numberB">
      <?php
      for($x=0;$x<=$numTeamsB; $x++){
         if($x == $numRankB){
            echo '<option value="'.$x.'" selected=selected>'.$x.'</option>';
         }else{
            echo '<option value="'.$x.'">'.$x.'</option>';
         }
      }
      ?>
   </select>
   <input type="Submit" value="Update" name="udateTeamRankB"/>
</form>
<h3>Number of Teams to Rank C</h3>
<form method="POST" action="">
   Suggested: <?php echo  ceil($numTeamsC/2); ?><br/>
   <select name="numberC">
      <?php
      for($x=0;$x<=$numTeamsC; $x++){
         if($x == $numRankC){
            echo '<option value="'.$x.'" selected=selected>'.$x.'</option>';
         }else{
            echo '<option value="'.$x.'">'.$x.'</option>';
         }
      }
      ?>
   </select>
   <input type="Submit" value="Update" name="udateTeamRankC"/>
</form>
<h3>Teams</h3>
<?php
    $display->table_of_teams();
?>