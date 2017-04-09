<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Roller coasters</title>
		<style type="text/css">
			.ride-count { text-align: center; }
		</style>
	</head>

  <body>

	<h1>Rollercoasters</h1>

	<?php
		//Just code the name of the data file once
		$data_file_name = 'rollercoaster.txt';
		
		//Make sure the file is there
		if( ! file_exists( $data_file_name ) ) {
			print("<p>Can't find the file $data_file_name</p>");
			exit;
		}

		//Reference
		// file_exists( 'filename' )  - Returns TRUE if the file exists and FALSE otherwise
		// fopen(filename, mode)
			// Opens the file filename for reading and/or writing depending on mode (see below)
			// Returns a file pointer if file is opened successfully, or “false” if not
		// fclose( $file_pointer ) – closes a file opened with fopen, returns true if successful
		// fputs($file_pointer, $string) - Writes $string to the file given by $file_pointer
		// fgets($file_pointer) - Returns the next line from the file given by $file_pointer
		// feof($file_pointer) - Returns true if the end of file has been reached
		// file(filename) - Returns an array in which each entry is a line of filename

		//Open Modes
		//	Mode	Read	Write	Overwrite	Create	Pointer
		//	r		X									beginning
		//	r+		X		X							beginning
		//	w				X		X			X		beginning
		//	w+		X		X		X			X		beginning
		//	a				X					X		end
		//	a+		X		X					X		end

		
		//ToDo: Open the data file for reading and store the pointer variable returned by the open command
		$file_pointer = fopen( $data_file_name, 'r' );
		
		
		//ToDo: If the open wasn't successful, display an error message and exit
		if ( ! $file_pointer ) {  
			print( 'error' );  
			exit;
		}
		
		
		//Initialize an array of coasters
		$coasters = array();

		//ToDo: Loop through all the lines of the file until there are no more lines
		while( ! feof( $file_pointer )				) {
			//ToDo: Read the value of the line (which is a string)
			$line = fgets( $file_pointer );
			
			//ToDo: Separate the line into an array of data for this coaster
			$coaster = explode( "\t", $line ); 
			
			//ToDo: Add this coaster to the array of coasters
			if( !empty ($coaster) ) {
				//Strip the "\n" off the end of the value
				$coaster[3] = intval( $coaster[3] );
				
				//Add this coaster to the array of coasters
				$coasters[] = $coaster;
			}
		}
		//ToDo: Clean up - close the file
		unset( $coaster );
		unset ( $line );
		fclose( $file_pointer );

		
		//Exit if the file load didn't produce an array
		if ( ! is_array( $coasters ) ) {
			print("<p>There was an error reading the file $data_file_name</p>");
			exit;
		}

		//Keep track of whether there are changes that need to be written to the file
		$update = false;
		
		//Loop through the rows of the text file which are in the $coasters array
		for ($i = 0; $i < count($coasters); $i++) {
			//Check to see if the increment button was clicked for this ride
			if (isset($_POST["ride$i"])) {
				//Get the current coaster, which is an array, from the array of coasters
				$coaster = $coasters[$i];
				
				//Get the current number of rides for this roller coaster
				$ride_count = trim($coaster[3]);
				
				//Increment the number
				$ride_count++;
				
				//Update the rides array for this ride, given by $i 
					//and the count in the in the fourth position, given by 3
				$coasters[$i][3] = $ride_count;

				//The array will need to be written back to the file
				$update = true;
			}
		}
		//Don't need these variables outside this loop
		unset( $ride_count );
		unset( $coaster );

		//Check to see if the "Add new" submit button was clicked
		//Only checking to see if it is set, not using the value, so its safe to use $_POST directly
		if (isset($_POST["new_coaster"])) {
			//Get the post data and clean it up so it is safe
			$coaster_name = filter_input( INPUT_POST, 'coaster', FILTER_SANITIZE_STRING );
			$coaster_type = filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING );
			$park_name = filter_input( INPUT_POST, 'park', FILTER_SANITIZE_STRING );
			$ride_count = filter_input( INPUT_POST, 'ride_count', FILTER_SANITIZE_NUMBER_INT );
			
			//Check to see if there is sufficient input to add a new coaster
			if ( ! empty($coaster_name) && ! empty($coaster_type) && ! empty($park_name) ) {
				//If a ride_count wasn't given, set it to zero
				if( empty( $ride_count ) ) {
					$ride_count = 0;
				}
				//Add the new coaster to the $coasters array
				$new_coaster = array( $coaster_name, $coaster_type, $park_name, $ride_count );
				$coasters[] = $new_coaster;
				
				//Since a coaster was added, the data file will need to be written
				$update = true;
			}
		}

		//If the file needs updating, erase it and write the content
		if ($update) {
			//ToDo: Open the data file and store the pointer variable returned by the open command
			$file_pointer = fopen($data_file_name,'w');
			
			//ToDo: If the open wasn't successful, display an error message and exit
			if (!$file_pointer) {
				print( "<p>Can't open $data_file_name for writing.</p>");
				exit;
			}
			
			//Initialize an array of lines that will be written to the file
			$lines = array();
			
			//Loop through the array of roller coasters and build up the array of lines to be written
			foreach ($coasters as $coaster) {
				//ToDo: Convert this line to a tab-delimited string
				$line = implode( "\t", $coaster );
				
				//ToDo: Add this line to the array of lines to be written
				$lines[] = $line;
			}
			
			//ToDo: Convert the contents to one string in preparation for writing
			//Note: make sure the string does not have a trailing \n which would cause an extra row
			$contents = implode( "\n", $lines );
			
			//ToDo: Write the contents
			fputs($file_pointer, $contents );
			
			//ToDo: Close and show a status message - change the following line so it closes the file and returns the success or failure
			$closed = fclose( $file_pointer );
			if( $closed ) {
				print '<p>Saved the update</p>';
			} else {
				print '<p>Update failed</p>';
			}
		}
		//Debugging - show the array of rides and / or post data
		//echo '<pre>' . print_r($coasters, true) . '</pre>';
		//echo '<pre>' . print_r($_POST, true) . '</pre>';
	?>

		<form method="post">
			<table border="1">
				<thead>
					<th>Roller coaster</th>
					<th>Type</th>
					<th>Park</th>
					<th># of rides</th>
					<th>Increment</th>
				</thead>

				<?php
					foreach ($coasters as $coasterindex => $coaster) {
						print("<tr>");
						//$row = explode("\t",$coaster);
						//write the row elements
						foreach ($coaster as $elementIndex => $element) {
							$safe_element = htmlentities( $element );
							//The fourth column gets a special class
							if ( $elementIndex == 3 ) {
								$class = "class='ride-count'";
							} else {
								$class = '';
							}
							print("<td $class>$safe_element</td>");
						}
						print("<td><input type='submit' name='ride$coasterindex' value='Increment' \></td>");
						print("</tr>");
					}
				?>

				<tr>
					<td><input type="text" name="coaster" /></td>
					<td>
						<select name="type">
							<option value="Wood">Wood</option>
							<option value="Steel">Steel</option>
						</select>
					</td>
					<td><input type="text" name="park" /></td>
					<td><input type="text" name="ride_count" /></td>
					<td><input type="submit" name="new_coaster" value="Add new"/></td>
				</tr>
			</table>
		</form>      
	</body>
</html>
