<?php

// Load the original image
$image = imagecreatefromjpeg("original.jpg");

// Create a new image with the same size as the original image
$new_image = imagecreatetruecolor(imagesx($image), imagesy($image));

// Set the drawing color to black
$black = imagecolorallocate($new_image, 0, 0, 0);

// Draw a line on the new image
imageline($new_image, 0, 0, imagesx($new_image), imagesy($new_image), $black);

// Save the new image
imagejpeg($new_image, "new_image.jpg");

?>
