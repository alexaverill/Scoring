<?php
//INSTALL SCRIPT!
//default Adming login:
//Admin
//321Scoring!

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Event Sign Up System</title>
<link rel="stylesheet" type="text/css" href="http://sciolyeventsignup.com/style.css" />
<style type="text/css">
fieldset ul, fieldset li{
border:0; margin:0; padding:0; list-style:none;
}
fieldset li{
clear:both;
list-style:none;
padding-bottom:10px;
}

fieldset input{
float:left;
}
fieldset label{
width:140px;
float:left;
}
</style>
</head>
<body>

<div id="main_container">
	<div id="header">
    	<div class="logo"><img src="source/images/logo.png" border="0" alt="" title="" /></div>       
    </div>
        <div class="menu">
        </div>
        
    <div class="center_content">
        	<div class="title_welcome"><span class="red"></span>Scoring System Setup</div>
        	<div class="text_content">
</p>
<p> Please fill out the following information for your database:</p>
<fieldset>
<legend>Database Info</legend>
<form name="database" action="" method="post">
<ul>

<li> <label for="database_user">Database User:</label>
<input type="text" name="database_user"id="name" size="30" />
</li>
<li> <label for="email">Database Password</label>
<input type="text" name="password" id="email" size="30" />
</li>

<li> <label for="psw">Database Host</label>
<input type="text" name="host" id="psw" size="30" value="localhost"/>
</li>
<li> <label for="name">Database Name</label>
<input type="text" name="data_name" id="name" size="30"/>
</li>

<li><label for="submit"></label>
<input type="submit" id="submit" value="Add Database Info"  name="submit"/> </li>
<ul>
</form>
</fieldset>
<?php
if($_POST['submit']){
	add_login();
}
function add_login(){
    $user= $_POST['database_user'];
    $pass=$_POST['password'];
    $install_value= rand(1000,9999);
    $host= $_POST['host'];
    $name= $_POST['data_name'];
    $content='<?php
    $data_username = "'.$user. '";        //Database User
    $data_password = "'.$pass.'";        //Database Password
    $data_host = "'.$host.'";   //Database Host localhost should work as defualt
    $name_database = "'.$name.'";        //Database Name*/
    $install='.$install_value.';
    ?>';

	$newlogin = "database.php";
	$new_login_open = fopen($newlogin, 'w') or die("Can't open file, please check your permissions");
	   if (fwrite($new_login_open, $content) === FALSE) {
        echo "Cannot write to file ($filename) Please check your permissions";
        exit;
    }
    fclose($new_login_open );
	insert_sql();
	    echo '<b>Success lets move on to  <a href="new_admin.php">step 2</a></b><br/>';
}
function insert_sql(){ 
    require('database.php');
    		$link = mysql_connect($data_host, $data_username,$data_password)
    		or die ("Could not connect to mysql because ".mysql_error());
    	mysql_select_db($name_database)
    		or die ("Could not select database because ".mysql_error());
    $filename='install.sql';
    //$enter= mysqli_multi_query ($insert)or die(mysql_error());
    //mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

    // Temporary variable, used to store current query
    $templine = '';
    // Read in entire file
    $lines = file($filename);
    // Loop through each line
    foreach ($lines as $line_num => $line) {
    // Only continue if it's not a comment
    if (substr($line, 0, 2) != '--' && $line != '') {
    // Add this line to the current segment
    $templine .= $line;
    // If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';') {
    // Perform the query
    mysql_query($templine) or print('Error performing query \'<b>' . $templine . '</b>\': ' . mysql_error() . '<br /><br />');
    // Reset temp variable to empty
    $templine = '';
    }
    }

    }
   //$add="UPDATE `settings` SET  `install` =  '$install' WHERE  `settings`.`tables` ='10'";
    $add=mysql_query($add)or die(mysql_error());

}



?>
</div>
</div>
</body>
</html>