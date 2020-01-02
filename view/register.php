<?php
	$_REQUEST['user']=!empty($_REQUEST['user'])? $_REQUEST['user'] : ''; 
	$_REQUEST['password']=!empty($_REQUEST['password'])? $_REQUEST['password']: '';
	
?>
<DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>RestaurantSmash</title>
	</head>
	<body>	
		
		<header><h1>RestaurantMash</h1></header>
		<main>
		<h1> Sign Up</h1>
		<form action="index.php" method="POST">
			<fieldset>
				<legend>Sign Up</legend>
			<table>      	
				<tr><th><label for="user" >User</label></th><td><input type="text" name="user" value="<?php echo($_REQUEST['user']); ?>"  required autofocus></td></tr>
      				
				<tr><th><label for="password">Password:</label></th><td>
					<input type="password" name="password" required></input> </td></tr>
				<tr><th><label for="passwordConfirmation">Confirm Password:</label></th><td>
					<input type="password" name="passwordConfirmation" required></input></td></tr>
				

				<tr><th><label for="firstName">First Name:</label></th><td>
					<input type="text" name="firstName" value="<?php echo($_REQUEST['firstName']); ?>" required></input></td></tr>
				<tr><th><label for="lastName">Last Name:</label></th><td>
					<input type="text" name="lastName" value="<?php echo($_REQUEST['lastName']); ?>" required></input> </td></tr>
				<tr><th><label for="email">Email:</label></th><td>
					<input type="email" name="email" value="<?php echo($_REQUEST['email']); ?>" required></input></td></tr>
				<tr><th><label for="Gender">Gender:</label></th><td>
					<input type="radio" name="gender" value="female" checked required>female</input>
					<input type="radio" name="gender" value="male" required>male</input></td></tr>
				<tr><th>&nbsp;</th><td><button type="submit" name="submit" value="1">Sign Up</button></td></tr>
				<tr><th>&nbsp;</th><td><?php echo(view_errors($errors)); ?></td></tr>
				<tr><th>&nbsp;</th><td></td></tr>
			</table>
		</form>
		<a href="?currentpage=login">Back to login</a>
		</main>
		<footer></footer>
	</body>
</html>
