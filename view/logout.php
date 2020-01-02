<?php
	session_destroy();
	header("refresh:5;index.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head> 
		<meta charset="utf-8">
		<title>RestaurantMash Logout</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<header> <h1> RestaurantSmash</h1>
		</header>
	</body>
	<?php echo "Thank you for using our website. You will be direct to our main page in 5 seconds"?>
</html>
