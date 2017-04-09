<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Password-Protected Site</title>
	</head>
	<body>
		<h1>My Secret Site using database login</h1>
		<?php 
		$post_username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
		$post_password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
		if ( empty( $post_username ) || empty( $post_password ) ) {
		?>
			<h2>Log in</h2>
			<form action="login.php" method="post">
				Username: <input type="text" name="username"> <br>
				Password: <input type="password" name="password"> <br>
				<input type="submit" value="Submit">
			</form>
			
		<?php

		} else {
			/* SQL to create a table that matches the fields used here
			 * username and password are the important fields. Since username
			 * has to be unique, you could use it for a primary key instead of creating
			 * a specific auto number field as I did here.
			 * You'll have to decide whether to have fields for first name, last name and anything else about users
			 *
			CREATE TABLE IF NOT EXISTS `users` (
			  `userID` int(11) NOT NULL AUTO_INCREMENT,
			  `hashpassword` varchar(255) NOT NULL,
			  `username` varchar(50) NOT NULL,
			  `name` varchar(50),
			  PRIMARY KEY (`userID`),
			  UNIQUE KEY `idx_unique_username` (`username`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
			*/

			//Get the config file which is positioned 1 folder level above this one
			require_once '../config.php';
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			if( $mysqli->connect_errno ) {
				//uncomment the next line for debugging
				echo "<p>$mysqli->connect_error<p>";
				die( "Couldn't connect to database");
			}
			//hash the entered password for comparison with the db hashed password
			//$hashed_password = password_hash("mypassword", PASSWORD_DEFAULT) . '<br>';

			//Un-comment this line to print out the hash of a password you enter.
			//This value is what you need to enter into the hashpassword field in the database
			//echo "<p>Hashed password: $hashed_password</p>";
			
			//Check for a record that matches the POSTed username
			//Note: This SQL lacks proper security. That's coming later
			$query = "SELECT * 
						FROM users
						WHERE
							username = '$post_username'";

			$result = $mysqli->query($query);
			
			//Uncomment the next line for debugging
			//echo "<pre>" . print_r( $mysqli, true) . "</p>";

			//Make sure there is exactly one user with this username
			if ( $result && $result->num_rows == 1) {
				
				$row = $result->fetch_assoc();
				//Debugging
				//echo "<pre>" . print_r( $row, true) . "</p>";
				
				$db_hash_password = $row['hashpassword'];
				
				if( password_verify( $post_password, $db_hash_password ) ) {
					$db_username = $row['username'];
					$_SESSION['logged_user_by_sql'] = $db_username;
				}
			} 
			
			$mysqli->close();
			
			if ( isset($_SESSION['logged_user_by_sql'] ) ) {
				print("<p>Congratulations, $db_username. You have accessed the secret content of this page.<p>");
			} else {
				echo '<p>You did not login successfully.</p>';
				echo '<p>Please <a href="login.php">try</a> again.</p>';
			}
			
		} //end if isset username and password
			
		
		require 'navigation.php';
		?>
	</body>
</html>
