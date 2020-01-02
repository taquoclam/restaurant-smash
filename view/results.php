<?php
	if(!isset($_REQUEST["reset"])) $_REQUEST["reset"] = 5;
    header("refresh:".$_REQUEST["reset"].";?currentpage=results");
	if(!isset($_REQUEST["Select"])) $_REQUEST["Select"] = 20;
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
			<li> <a style="color:blue" href="?currentpage=results">Results</a>
			<li> <a href="?currentpage=profile">Profile</a>
			<li> <a href="?currentpage=logout">Logout</a>
			</ul>
		</nav>
		<main>
			<h1>Top <?php echo $_REQUEST["Select"] ?> Restaurants</h1>
			<form method="post">
				<table>
				<tr> <th>Ranking </th><th>Restaurant</th><th> Rating</th> <th> Wins</th> <th> Losses</th> <th> Draws</th> <th> Velocity</th> </tr>
				Select top: <select name="Select" value="Select">
					    <option value="10">10</option>
  						<option value="20" selected>20</option>
  						<option value="50">50</option>
  						<option value="100">100</option>
				</select>
				Reset Time: <select name="reset" value="reset time">
					    <option value="5">5</option>
  						<option value="10" selected>10</option>
  						<option value="50">50</option>
				</select>
				<input type="submit" value="Show">
				<?php
					$s = "";
					$counter = 0;
					$result = $_SESSION["database"]->execute_query("Select resname, point, wins, losses, draws, point - (oldpoint1 + oldpoint2)/2 as velc from appres order by point desc limit $1","restaurant_list",array($_REQUEST["Select"]));
					while($row = pg_fetch_array($result)){
						$counter++;
            					$s = $s . "<tr><td>" .$counter."</td><td>".$row["resname"]."</td><td>".$row["point"]."</td><td>".$row["wins"] ."</td><td>".$row["losses"]."</td><td>".$row["draws"]."</td><td>".$row["velc"]."</td></tr>";
					}
					echo($s);
              ?>
				</table>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

