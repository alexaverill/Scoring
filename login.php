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
				Username:<input type="text" name="user" class="form-control" size="25"/><br/>
				Password:<input type="password" class="form-control" name="pass" size="25"/><br/>
				<input class="btn btn-primary" value="Login" name="login" type="submit" />
				
			</form>
		</div>