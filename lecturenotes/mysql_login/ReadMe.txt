These files demonstrate session logins using a MySQL users table

File setup 
	-rename config-sample.php to config.php
	-fill in your own database connection information
	-move it up one folder level or change the require_once call in login.php that calls it.
	
Database setup
	-Locate the "Create" statement for the database table in login.php
	-Copy that statement into phpMyAdmin in the SQL tab and execute it
	-Use phpMyAdmin to add a user
	-You can find out what the hash of a password is by uncommenting the "Hashed Password" echo statement in login.php and then submitting a password.
	
The main file is login.php