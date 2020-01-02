<?php
// So I don't have to deal with unset $_REQUEST['user'] when refilling the form
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
			<li> <a style="color:blue" href="?currentpage=compete">Compete</a>
			<li> <a href="?currentpage=results">Results</a>
			<li> <a href="?currentpage=profile">Profile</a>
			<li> <a href="?currentpage=logout">Logout</a>
			</ul>
		</nav>
		<main>
			<h1>Compete</h1>
			<h2> Welcome, <?php echo($_SESSION['user']->getLastName()); ?>!</h2>
			<h2> Which restaurant would you rather go to?</h2>
			<form action="index.php" method="post">
				<table>
				<tr>
					<th class="choice"><button type="submit" name="choose" value="1"><?php $test= new Compete(); $test->selectrestaurants($_SESSION['user']->getUserID()); if(empty($_SESSION["restaurant1"])) echo ("No more"); else echo($_SESSION["restaurant1"]); ?></button></th>
					<th class="choice"><button type="submit" name="choose" value="0.5">Draw</button></th>
					<th class="choice"><button type="submit" name="choose" value="2"><?php if(empty($_SESSION["restaurant2"])) echo "No more"; else echo($_SESSION["restaurant2"]); ?></button></th>
				</tr>
				</table>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

