<?php 
	include("header.php"); 
	include("query.php");		
?>
<!--
	CREDITS: All of the photos and background are from my roommate, Chuan Huang
      I downloaded from his loft: http://akimotoyasushi.lofter.com/
      Others were sent to me from him by e-mail
-->

<!-- Body -->
<?php 

	//CREDIT: from lecture notes
	//if it need log in or has logged in

	if (isset($_POST['logout']) && isset($_SESSION['logged_user'])) { 
	// If log out
		//echo '<pre>'.print_r($_SESSION['logged_user'], true).'</pre>';

		unset($_SESSION[ 'logged_user' ] );
		unset( $_SESSION );
		$_SESSION = array();
		session_destroy();

		print("<h1>Return to the <a href='login.php'>login form.</a></h1>");
		//echo '<pre>'.print_r($_SESSION['logged_user'], true).'</pre>';
	} else {
		// input filter
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING); 
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

		if (!isset($_SESSION['logged_user']) && (empty($username) || empty($password))) {
		//need log in, display log in form
?>
			<div class="form_container">
            <h1>LOG IN</h1>
            	<form id = "login_form" name = "login_form" class = "form" method = "POST" action = "login.php" onsubmit = "return validLogin()">
				 	<div class="form_item">
                    	<h6>Please enter your name: </h6>
						<input id='username' type='text' placeholder='User name' name='username' >
					</div>
					<div class="form_item">
                    	<h6>Please enter your password: </h6>
						<input id='password' type='password' placeholder='Password' name='password'><br>
					</div>
					<div class="form_item">
						<input type='submit' class="button" name='login' value='LOGIN'>
					</div>
					<h3 id="login_error_message" class="add_error_message"></h3>
				</form>
			</div>
<?php 
		} else { 
		// Check for logged in user
			$query0 = new Query(); 
      		$user = $query0->get_user($username);
            $db_hash_password  = $user->get_pwd();
            //echo '<pre>'.print_r($db_hash_password, true).'</pre>';
            if( password_verify( $password, $db_hash_password ) ) {
				$_SESSION['logged_user'] = $user->get_name();
				//echo '<pre>'.print_r($_SESSION['logged_user'], true).'</pre>';
			}

			//successfully logged in
			if (isset($_SESSION['logged_user'])) {
				$logged_user = $_SESSION['logged_user']; 

				echo "<h2>Welcome, " . $logged_user . "!<br>You can use all functions here!</h2>";
?> 
				<form name='logout' action='login.php' method='POST'>
					<input class='button' type='submit' name='logout' value='logout'>
				</form>	
<?php			
			} else { 
			// If password not match!
?> 
			<div class = "display_information">
				<h1>Username and password not match!</h1>
				<h1>Please <a href='login.php'>log in</a> again.</h1>
			</div>
<?php	
			}
		}
	}
	
?>

</body>
</html>