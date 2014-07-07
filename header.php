<?php
include('database.php');
try{
    $dbh= new PDO('mysql:host='.$data_host.';dbname='.$name_database,$data_username,$data_password);
}catch(PDOException $e){
    echo $e->getMessage();
}
include('classes.php');

?>

		<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="source/bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="source/bootstrap/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="source/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="source/jquery-2.1.1.min.js"></script>
<script src="source/jquery.jeditable.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
$(function() {
    $(".edit_event").editable("bridges/update_event.php", { 
      indicator : "Updating...",
      submitdata: { _method: "put" },
      select : true,
      submit : 'Update',
      cssclass : "editable",
      onblur:"submit",
      width : "500",
      loadtext  : 'Updating…'
  });
  $(".edit_name").editable("bridges/update_names.php", { 
      indicator : "Updating...",
      submitdata: { _method: "put" },
      select : true,
      submit : 'Update',
      cssclass : "editable",
      onblur:"submit",
      width : "500",
      loadtext  : 'Updating…'
  });
    $(".edit_number").editable("bridges/update_number.php", { 
      indicator : "Updating...",
      submitdata: { _method: "put" },
      select : true,
      submit : 'Update',
      cssclass : "editable",
      onblur:"submit",
      width : "500",
      loadtext  : 'Updating…'
  });
        $(".edit_div").editable("bridges/update_division.php", { 
      indicator : "Updating...",
      submitdata: { _method: "put" },
      select : true,
      submit : 'Update',
      cssclass : "editable",
      onblur:"submit",
      width : "500",
      loadtext  : 'Updating…'
  });
});});
</script>