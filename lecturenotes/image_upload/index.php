<?php
	session_start();
	//Is the user asking to delete photos
	if( ! empty( $_POST[ 'clearphotos' ] ) ) {
		$_SESSION['photos' ] = array();
		
		//Delete the files from the images directory
		$files = glob('images/*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
			unlink($file); // delete file
		}
		
		//Delete the files from the thumbnails directory
		$files = glob('thumbnails/*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
			unlink($file); // delete file
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<style>
			img { height: 200px; }
			label {width: 150px; display: inline-block; }
		</style>
		<title>My Photo Album</title>
	</head>

	<body>

		<h1>Manage photos</h1>
		<form method="post" enctype="multipart/form-data">
			<p>
				<label for="new-photo">Single photo upload: </label>
				<input id="new-photo" type="file" name="newphoto">
				<input type="submit" value="Upload photo">
			</p>
		</form>
		<form method="post" enctype="multipart/form-data">
			<p>
				<label for="new-photos">Multiple photo upload: </label>
				<input id="new-photos" type="file" name="newphotos[]" multiple>
				<input type="submit" value="Upload photo(s)">
			</p>
		</form>
		<form method="post">
			<p><input type="submit" name="clearphotos" value="Clear photo(s)"></p>
		</form>
		<br>

		<?php

			//Check to see if a file was uploaded using the "single file" form
			if ( ! empty( $_FILES['newphoto'] ) ) {
				$newPhoto = $_FILES['newphoto'];
				$originalName = $newPhoto['name'];
				if ( $newPhoto['error'] == 0 ) {
					$tempName = $newPhoto['tmp_name'];
					move_uploaded_file( $tempName, "images/$originalName");
					$_SESSION['photos'][] = $originalName;
					print("<p>The file $originalName was uploaded successfully.</p>");

					require_once 'resize.php';
					save_thumbnail( "images/$originalName", "thumbnails/$originalName", 200 );
				} else {
					print("<p>Error: The file $originalName was not uploaded.</p>");
				}
			}

			//Check to see if files were uploaded using the "multiple file" form
			if ( isset( $_FILES['newphotos'] ) ) {
				require_once 'resize.php';
				$newPhotos = $_FILES['newphotos'];
				for ( $i = 0; $i < count( $newPhotos['name'] ); $i++) {
					$originalName = $newPhotos['name'][$i];
					if ($newPhotos['error'][$i] == 0 ) {
						$tempName = $newPhotos['tmp_name'][$i];
						
						//Debugging
						//echo "Moving $tempName to images/$originalName";
						move_uploaded_file( $tempName, "images/$originalName" );
						$_SESSION['photos'][] = $originalName;
						print("<p>The file $originalName was uploaded successfully.</p>");
						save_thumbnail( "images/$originalName", "thumbnails/$originalName", 200 );
					} else {
						print("<p>The file $originalName was not uploaded.</p>");
					}
				}
			}
			
			//Debugging: This formats the $_FILES array nicely but hides it from view
				//so you can see it in the inspector or HTML source
			echo '<pre style="display:none;">FILES: ' . print_r( $_FILES, true ) . '</pre>';
			echo '<pre style="display:none">SESSION: ' . print_r($_SESSION, true) . '</pre>';
			?>
			<h1>Uploaded photos</h1>
	
			<?php
			if( !empty( $_SESSION[ 'photos' ] ) ) {
				foreach ($_SESSION['photos'] as $photo) {
					$file = "images/$photo";
					$imagesize = getimagesize( $file );
					$size = "Actual size: $imagesize[3]";
					$taken = '';
					$exif_data = exif_read_data ( $file );
					echo '<pre style="display:none;">Exif data: ' . print_r( $exif_data, true ) . '</pre>';
					if ( !empty( $exif_data[ 'DateTimeOriginal' ] ) ) {
						$taken = " Taken: {$exif_data[ 'DateTimeOriginal' ]}";
					}
					//print("<img src='$file' alt='$photo' title='$photo $size $taken'><br />\n");
					$file_url = urlencode( $photo );
					print("<a href='photo-detail.php?image=$file_url'><img src='$file' alt='$photo' title='$photo $size $taken'></a><br />\n");
				}
			} else {
				print "<p>No photos to display.</p>";
			}
		?>
	</body>
</html>
