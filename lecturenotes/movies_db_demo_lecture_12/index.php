<!DOCTYPE html>
<html>
  <head>
    <title>2300 Movie DB</title>
	<?php 
		require_once "includes/functions.php";
		//add_versioned_file( 'js/scripts.js', 'JavaScript' );
		add_versioned_file( 'css/style.css', 'Style' );
	?>
  </head>

	<?php
		//Get the $fields variable, which is in a separate file in order to share with add-edit.php
		require_once "includes/settings.php";
		
		//Initialize an array for search clauses
		$searches = array();
		foreach( $fields as $field ) {
			$search_term = $field[ 'term' ];
			$filter = $field[ 'filter' ];
			
			//Does this term exist in the POST data submitted by the search form?
			if( !empty( $_POST[ $search_term ] ) ) {
				//Get the value for this term from the POST data
				$search_value = filter_input( INPUT_POST, $search_term, $filter );
				
				//Add the search clause
				$searches[] = "$search_term REGEXP '$search_value'";
			}
		}
		
		//Uncomment this to see the $_POST array
		//echo '<pre>' . print_r( $_POST, true ) . '</pre>';
		
		//Uncomment this to see the searches array
		//echo '<pre>' . print_r( $searches, true ) . '</pre>';
		
		//Try to get the 'sort' parameter from the URL and filter out bad stuff
			//Better security would make sure it is one of our expected $fields
		$sort = filter_input( INPUT_GET, 'sort', FILTER_SANITIZE_STRING );

		//Get the connection info for the DB. 
		require_once 'includes/config.php';
		
		//Establish a database connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		//Was there an error connecting to the database?
		if ($mysqli->errno) {
			//The page isn't worth much without a db connection so display the error and quit
			print($mysqli->error);
			exit();
		}
		
		$sql = 'SELECT * FROM Movies';
		
		//Were there search terms?
		if( !empty( $searches ) ) {
			//Build the WHERE clause
			$sql .= ' WHERE ';
			
			//Add the searches by joining any elements together with AND
			$sql .= implode(' AND ', $searches );
		}
		
		//Is this sorted?  $sort will be empty if the parameter was not set in the URL
		if ( !empty( $sort ) ) {
			$sql .= " ORDER BY $sort";
		}
		
		//Finish off the SQL statement
		$sql .= ';';
		
		//echo $sql;
		
		//Get the data
		$result = $mysqli->query($sql);
			
		//If no result, print the error
		if (!$result) {
			print($mysqli->error);
			exit();
		}
	?>

  <body>

	<h1>2300 Movie DB</h1>

	<?php
		$html_safe_sql = htmlentities( $sql );
		print( "<p>Showing movies using the SQL query <br>$html_safe_sql</p>");
		print("<table>");
			print("<thead><tr>");
				foreach ($fields as $field ) {
					$field_term = $field['term'];
					$field_heading = $field['heading'];
					//Make the header a link for sorting
					print("<th><a href='?sort=$field_term'>$field_heading</a></th>");
				}
				//Add empty header cell for the "modify" row
				print( '<th></th>' );
			print("</tr></thead>");
			
			
			//Loop through the $result rows fetching each one as an associative array
			while ($row = $result->fetch_assoc()) {
				//start the HTML table row
				print("<tr>");
					print( "<td class='title'>{$row[ 'title' ]}</td>" );
					print( "<td class='year'>{$row[ 'year' ]}</td>" );
					print( "<td class='length'>{$row[ 'length' ]}</td>" );
					
					//Build the URL for modifying the row
					$movie_id = $row['movie_id'];
					$href = "add-edit.php?movie_id=$movie_id";
					print("<td><a href='$href' title='$href'>Edit</a></td>");
				print("</tr>");
			}
			
		print("</table>");
	?>
	<p><a href='add-edit.php'>Add a movie</a></p>

	<h2>Search</h2>
	<form method="post">
		<?php			
			
			print '<table>';
				print '<thead>';
					print( '<tr>' );
						foreach ($fields as $field) {
							$field_heading = $field[ 'heading' ];
							print("<th>$field_heading</th>");
						}
						//Add empty header cell for the button
						print( '<th></th>' );
					print( '</tr>' );
				print("</thead>");
				
				print("<tr>");
					foreach ($fields as $field ) {
						$search_term = $field[ 'term' ];
						print("<td><input type='text' name='$search_term'></td>");
					}
					print("<td><input type='submit' name='search' value='Search'></td>");
				print("</tr>");
			print("</table>");
		?>
	</form>

  </body>
</html>
