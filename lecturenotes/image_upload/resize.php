<?php
/*
 * Saves a thumbnail of the given image
 * 
 * Parameters
 * $source: the path and file name relative to the current directory
 * $thumbPathAndFile: the path and file name of the thumbnail to be created (relative to the current directory)
 * $thumbWidth: the width of the thumbnail being created
 */
function save_thumbnail( $source, $thumbPathAndFile, $thumb_width = 200 ) {
	//Create a new image from the given image
	$img = imagecreatefromjpeg( $source );
	
	//Calculate the dimensions
	$width = imagesx($img);
	$height = imagesy($img);

	//Set the new dimensions by proportionally scaling the height to the given width
	$new_width = $thumb_width;
	$new_height = floor($height * ($thumb_width/$width));

	//Create a new image
	$new_img = imagecreatetruecolor($new_width, $new_height);

	//Copy and resize the original into the new
	imagecopyresampled($new_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

	//Save the image to the given path
	$return = imagejpeg($new_img, $thumbPathAndFile);

	//Free up memory
	imageDestroy($img);
	imageDestroy($new_img);
	
	//Return the success/failure status
	return $return;
}
?>
