<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>My Password-Protected Site SQL</title>
	</head>
	<body>
		<h1>My Secret Page Number 3 SQL</h1>

		<?php
		if (isset($_SESSION['logged_user_by_sql'])) {
			print "<p>More secret content, ".$_SESSION['logged_user_by_sql']."!  Not everyone gets to see this, you know.</p>";
		} else {
			print "<p>You haven't logged in.</p>";
			print "<p>Go to our <a href='login.php'>login page</a></p>";
		}
		require 'navigation.php';
		?>

	</body>
</html>