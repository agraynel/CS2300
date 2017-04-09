<?php

	error_reporting(E_ALL ^ E_NOTICE);

	$clockImageUrl = '';
	if( ! empty( $_GET[ 'image' ] ) ) {
		$fileName = $_GET[ 'image' ];

		//Strip the extension to show as title
		$title = preg_replace("/\\.[^.\\s]{3,4}$/", "", $fileName);

		//relative path
		$pathAndFile = "images/$fileName";

		//Try to read extra information embedded in the image
		$exif_data = exif_read_data ( $pathAndFile );
		
		if ( !empty( $exif_data[ 'DateTimeOriginal'] ) ) {
			$taken = strtotime( $exif_data[ 'DateTimeOriginal' ] );
			$hour =  intval( date('g', $taken ) );
			$minute =  intval( date( 'i', $taken ) );
			//$clockImageUrl = "clock.php?hour=$hour&minute=$minute";
		}

	}

	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<style type="text/css">
			img { height: 400px; }
		</style>
		<title><?php print( $title )?></title>
	</head>

	<body>
		<h1><?php print( $title )?></h1>
		<p><?php echo $detailImageUrl ?></p>
		<img src="<?php echo $pathAndFile ?>">
		<p><a href="index.php">Manage photos</a></p>
		<?php echo "<pre>" . print_r($exif_data, true) . '</pre>'; s?>
	</body>
</html>
