<?php
// So I don't have to deal with unset $_REQUEST['user'] when refilling the form
$_REQUEST['user']=!empty($_REQUEST['user']) ? $_REQUEST['user'] : '';
$_REQUEST['password']=!empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
$errors[]=!empty($errors) ? $errors : '';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>RestaurantMash</title>
	</head>
	<body>
		<header><h1>RestaurantMash</h1></header>
		<!--
		<nav>
			<ul>
			<li> <a href="">Class</a>
			<li> <a href="">Profile</a>
			<li> <a href="">Logout</a>
			</ul>
		</nav>
		-->
		<main>
			<h1>Login</h1>
			<form action="index.php" method="post">
				<fieldset>
				<legend>Login</legend>
				<table>
					<!-- Trick below to re-fill the user form field -->
					<tr><th><label for="user" >User</label></th><td><input type="text" name="user" required autofocus value="<?php echo($_REQUEST['user']); ?>" /></td></tr>
					<tr><th><label for="password">Password</label></th><td> <input type="password" name="password" required/></td></tr>
					<tr><th>&nbsp;</th><td><input type="submit" name="submit" value="login" /></td></tr>
					<tr><th>&nbsp;</th><td><?php echo(view_errors($errors)); ?></td></tr>
				</table>
			</form>
			<a href="?currentpage=register">New Member</a>
		</main>
		<footer>
		</footer>
	</body>
</html>

