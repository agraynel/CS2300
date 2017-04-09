<!DOCTYPE html>
<html>
  <head>
    <title>2300 Movie DB - Add / Edit</title>
	<?php 
		require_once "includes/functions.php";
		//add_versioned_file( 'js/scripts.js', 'JavaScript' );
		add_versioned_file( 'css/style.css', 'Style' );
	?>
  </head>

	<?php
		//Display the POST data for debugging
		//echo '<pre>' . print_r( $_POST, true ) . '</pre>';
		
		//Get the $fields variable, which is in a separate file in order to share with index.php
		require_once "includes/settings.php";
		
		//Try to get the movie_id from a URL parameter
		$movie_id = filter_input( INPUT_GET, 'movie_id', FILTER_SANITIZE_NUMBER_INT );
		if( empty( $movie_id ) ) {
			//Try to get it from the POST data (form submission)
			$movie_id = filter_input( INPUT_POST, 'movie_id', FILTER_SANITIZE_NUMBER_INT );
		}

		$message = '';
		//Get the connection info for the DB. 
		require_once 'includes/config.php';
		
		//Establish a database connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($mysqli->errno) {
			print "<p>$mysqli->error</p>";
			exit();
		}
		
		//Was the "Save" button clicked?
		if( ! empty( $_POST[ 'save_movie' ] ) ) {
			//Try to retrieve values from the POST data

			//Initialize an array to hold field values found in the $_POST data
			$field_values = array();
			
			//Loop through the expected fields
			foreach( $fields as $field ) {
				$field_name = $field[ 'term' ];
				$filter = $field[ 'filter' ];
				
				//Does this term exist in the POST data submitted by the add/edit movie form?
				if( !empty( $_POST[ $field_name ] ) ) {
					//Get the value for this term from the POST data
					$field_value = filter_input( INPUT_POST, $field_name, $filter );
					
					//Store the field values
					$field_values[ $field_name ] = $field_value;
				}
			}

			//Is this a new movie being added?
			if( empty( $movie_id ) ) {
				//add 
				if( empty( $field_values['title'] ) || empty( $field_values['year'] ) ) {
					$message .= '<p>Movie not added. Title and Year are required.';
				} else {
					//debugging
					//echo '<pre>' . print_r( $field_values, true ) . '</pre>';
					
					//Get an array of the field names that have data
					$field_name_array = array_keys( $field_values );
					
					//Comma delimited list of fields
					//equivalent to $field_list = "title, year, length";
					$field_list = implode( ',', $field_name_array );
					
					//comma delimited list of values - need quotes around values
					$value_list = implode( "','", $field_values );
					
					//Build the SQL for adding a movie - later we'll improve security and quoting
					$sql = "INSERT INTO movies ( $field_list ) VALUES ( '$value_list' );";
				}
				
			} else { 
				//update
				$update_fields = array();
				if( empty( $field_values['title'] ) || empty( $field_values['year'] ) ) {
					$message .= '<p>Movie not updated. Title and Year are required.';
				} else {
					foreach( $field_values as $field_name => $field_value ) {
						$update_fields[] = "$field_name = '$field_value'";
					}
					$sets = implode( ', ', $update_fields );
					
					//Build the SQL for adding a movie - later we'll improve security and quoting
					$sql = "UPDATE movies SET $sets WHERE movie_id=$movie_id";
					
				}
			}
			
			//Anything to save?
			if( ! empty( $sql ) ) {
				if( $mysqli->query($sql) ) {
					$message .= '<p>Movie Saved.</p>';
					
					//Was this an "add"?
					if( empty( $movie_id ) ) {
						//Get the primary key of the newly added movie
						$movie_id = $mysqli->insert_id;
					}
				} else {
					$message .= "<p>Error saving movie.</p><p>$mysqli->error</p>";
				}
				
			}
		}
		
		$db_values = array();
		//Anything to load?
		if( ! empty( $movie_id ) ) {
			//Load values from the db
			$sql_load = "SELECT * FROM movies WHERE movie_id=$movie_id";
			$result = $mysqli->query($sql_load);
			if( $result ) {
				$row = $result->fetch_assoc();
				$db_values['title'] = $row['title'];
				$db_values['year'] = $row['year'];
				$db_values['length'] = $row['length'];
				
			} else {
				$message .= "<p>Couldn't load movie from the database.</p><p>$mysqli->error</p>";
				$db_values['title'] = 'STeve';
				$db_values['year'] = '1234';
				$db_values['length'] = '2';
			}
			
		} else {
			//Nothing to load
			$db_values['title'] = '';
			$db_values['year'] = '';
			$db_values['length'] = '';
		}
	?>

  <body class="add-edit">
	<?php
		if( empty( $movie_id ) ) {
			$action = 'Add';
		} else {
			$action = 'Edit';
		}
		
		print "<h1>2300 Movie DB - $action</h1>";
		print $message;
		
		if( ! empty( $sql ) ) {
			$html_safe_sql = htmlentities( $sql );
			print( "<p>SQL query <br>$html_safe_sql</p>");
		}

		//Start a form that submits to this same page
		print '<form method="post">';
			//If there is a movie_id then this is an edit form and needs a hidden field
				//for the primary key so that the UPDATE query knows which record to update
			if( !empty( $movie_id ) ) {
				print("<input type='hidden' name='movie_id' value='$movie_id'>");
			}
			
			//The fields
			foreach ( $fields as $field ) {
				$term = $field['term'];
				$field_heading = $field['heading'];
				$field_value = $db_values[$term];
				
				print("<p class='$term'><label>$field_heading</label><input type='text' name='$term' value='$field_value'></p>");
			}
			
			//Submit / Save
			print("<input type='submit' name='save_movie' value='Save'>");
		print '</form>';
	?>
	<p><a href='index.php'>View All Movies</a></p>
	
  </body>
</html>
