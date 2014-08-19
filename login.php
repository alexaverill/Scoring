<?php include('header.php');
include('nav.php');
if($_POST['login']){
	$user = new user;
	$user->login($_POST['user'],$_POST['pass']);
}
?>
<html>
	<head>
		<script type="text/javascript" src="source/jquery-2.1.1.min.js"></script>
		<script src="source/jquery.jeditable.js" type="text/javascript"></script>
				<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="source/bootstrap/css/bootstrap.css">
		<!-- Extra Themes -->
		<link rel="stylesheet" href="source/parts.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="source/bootstrap/js/bootstrap.min.js"></script>
		<script src="source/editing.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Score Sheet</title>
		<script type="text/javascript" src="source/jquery-2.1.1.min.js"></script>
		
	</head>
	
	<body>
		
	<div class="class="container-fluid">
<h1>Login</h1>
		<div class="user_info">
			<form method="POST" action="">
				Username:<input type="text" name="user" class="form-control" size="25"/><br/>
				Password:<input type="password" class="form-control" name="pass" size="25"/><br/>
				<input class="btn btn-primary" value="Login" name="login" type="submit" />
				
			</form>
		</div>