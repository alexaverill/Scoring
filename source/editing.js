
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