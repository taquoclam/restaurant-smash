<?php
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
		<nav>
			<ul>
			<li> <a href="?currentpage=compete">Compete</a>
			<li> <a href="?currentpage=results">Results</a>
			<li> <a style="color:blue" href="?currentpage=profile">Profile</a>
			<li> <a href="?currentpage=logout">Logout</a>
			</ul>
		</nav>
		<main>
		<h1>Login</h1>
			<form action="index.php" method="post">
				<fieldset>
				<legend>Profile</legend>
			<table>      	
				<tr><th><label for="user">Username:</label></th><td>
					<input type="text" name="user" required autofocus value="<?php echo($_SESSION['user']->getUsername()); ?>"> 
					</input></td></tr> 
      				
				<tr><th><label for="password" $>Password:</label></th><td>
					<input type="password" name="password" required></input> </td></tr>

				<tr><th><label for="firstName" >First Name:</label></th><td>
					<input type="text" name="firstName" required value="<?php echo($_SESSION['user']->getFirstName()); ?>"></input></td></tr>
				<tr><th><label for="lastName" >Last Name:</label></th><td>
					<input type="text" name="lastName" required value="<?php echo($_SESSION['user']->getLastName()); ?>"></input> </td></tr>
				<tr><th><label for="email" >Email:</label></th><td>
					<input type="email" name="email" required value="<?php echo($_SESSION['user']->getEmail()); ?>"></input></td></tr>
					<tr><th><label for="Gender">Gender:</label></th><td>
					<input type="radio" name="gender" value="female" <?php if ($_SESSION['user']->getGender() == 'female') echo("checked"); ?> required>female</input>
					<input type="radio" name="gender" value="male" <?php if ($_SESSION['user']->getGender() == 'male') echo("checked"); ?> required>male</input></td></tr>
				<tr><th>&nbsp;</th><td><?php echo(view_errors($errors)); ?></td></tr>
				<tr><th>&nbsp;</th><td><button type="submit" name="submit" value="profile">Update Profile</button></td></tr>
				<tr><th>&nbsp;</th><td></td></tr>
			</table>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

