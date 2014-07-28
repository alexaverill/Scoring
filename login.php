<?php include('header.php');
include('nav.php');
if($_POST['login']){
	$user = new user;
	$user->login($_POST['user'],$_POST['pass']);
}
?>
<h1>Login</h1>
		<div class="user_info">
			<form method="POST" action="">
				Username:<input type="text" name="user" size="25"/><br/>
				Password:<input type="password" name="pass" size="25"/><br/>
				<input class="myButton" value="Login" name="login" type="submit" />
				
			</form>
		</div>