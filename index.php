<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Clear the output buffer
ob_clean();

// Set content type to output an image
header('Content-Type: image/jpeg');
// Define the paths to assets
$imagePath = "Certificate.jpg"; // Path to your certificate template
$fontName = "calibrib.TTF"; // Font for name
$fontOther = "calibrib.TTF"; // Font for other details

// Load the certificate image
$image = imagecreatefromjpeg($imagePath);
if (!$image) {
    die("Error: Unable to load certificate template image. Check the file path.");
}
// Allocate text color
$color = imagecolorallocate($image, 0, 0, 0); // Black

// Dynamic values
$ref_no = "SF12345";
$date = "22nd Dec 2024";
$name = "Vishal Gupta";
$designation = "Web Development Intern";
$dateFrom = "1st Jan 2024";
$dateTo = "31st Dec 2024";
// Add Ref No
imagettftext($image, 20, 0, 950, 362, $color, $fontOther, "$ref_no");

// Add Date
imagettftext($image, 20, 0, 250, 362, $color, $fontOther, "$date");

// Add Name
imagettftext($image, 20, 0, 200, 550, $color, $fontName, $name);

// Add Designation
imagettftext($image, 20, 0, 705, 638, $color, $fontOther, "$designation");

// Add Date From
imagettftext($image, 20, 0, 480, 793, $color, $fontOther, "$dateFrom");

// Add Date To
imagettftext($image, 20, 0, 680, 793, $color, $fontOther, "$dateTo");
// Output the final image
imagejpeg($image);

// Free memory
imagedestroy($image);
?>