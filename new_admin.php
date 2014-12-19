<?php
include('header.php');
?>

<form name="passform" method="POST" action="">
	Admin Username:<input type="text" name="schoolname"/><br/>
	Admin Email:<input type="text" name="email"/><br/>
	Password:<input name="passbox" type="password">
	<!--<input type="button" value="Generate" onClick="javascript:formSubmit()" tabindex="2">--> <br/>
	<input type="submit" value="Add user" name="adduser"/>
</form>
<?php
if ($_POST['adduser'])
{ 
    add_first_admin();
}


function add_first_admin(){
        global $dbh;
	//echo 'Adding Admin';
	echo '<br/> Please Keep this information:<br/>';
	echo 'The Following is your login information for you installation.<br/>';
	echo 'Username: ' .$_POST['schoolname'].'<br/>';
	echo 'Email: '.$_POST['email'].'<br/>';
	echo 'Password: ' .$_POST['passbox']. '<br/>';
	$password=$_POST['passbox'];
	$password=stripslashes($password); //injection cleaner
	$password = password_hash($password, PASSWORD_DEFAULT);
	$mpass = $password;

	$user= $_POST['schoolname'];
	$user= stripslashes($user);
	$user= mysql_real_escape_string($user);
	$email=$_POST['email'];
	$name= $_POST['schoolname'];
	$name= stripslashes($name);
	$name = mysql_real_escape_string($name);
	$check = "SELECT * FROM `team` WHERE name =?";
	$qry =$dbh->prepare($check);
        $qry->execute(array($user));
	//$num_rows = mysql_num_rows($qry);
        try{

                $sql="INSERT INTO `members` (`name`, `password`,`email`,`rank`) VALUES (?, ?,?,1)";
                $insert=$dbh->prepare($sql);
                $insert->execute(array($name,$mpass,$email));
        }catch(PDOException $e){
            echo $e->getMessage();
        }
		//$insert = mysql_query( "INSERT INTO `members` (`name`, `password`,`email`,`rank`) VALUES ('$name', '$mpass','$email',1);")
		//sor die("Could not insert data because ".mysql_error());
		echo "<span class=\"success\">Your user account has been created!<br/><h1> Now please delete new_admin.php as well as install.php</h1></span><br>";
	//}
}

?>
