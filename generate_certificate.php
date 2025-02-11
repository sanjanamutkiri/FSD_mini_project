<?php
// Include necessary files
include 'db_connection.php';
require('fpdf/fpdf.php'); // Include FPDF library

// Get the ref_no from the URL
$ref_no = $_GET['ref_no'];

// Query to fetch the applicant's data based on ref_no
$sql = "SELECT ref_no, name, designation, date_from, date_to, serial_number, date FROM interns WHERE ref_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ref_no);
$stmt->execute();
$result = $stmt->get_result();

// Check if the applicant exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Image creation
    $img = imagecreatefromjpeg('Certificate.jpg'); // Your base certificate image
    $black = imagecolorallocate($img, 0, 0, 0); // Text color

    // Add applicant details to the certificate
    imagettftext($img, 20, 0, 200, 550, $black, 'calibrib.ttf', $row['name']); // Name
    imagettftext($img, 20, 0, 950, 362, $black, 'calibrib.ttf', $row['ref_no']); // Ref Number
    imagettftext($img, 20, 0, 250, 362, $black, 'calibrib.ttf', $row['date']); // Date
    imagettftext($img, 19, 0, 690, 638, $black, 'calibrib.ttf', $row['designation']); // Designation
    imagettftext($img, 20, 0, 480, 793, $black, 'calibrib.ttf', $row['date_from']); // Date From
    imagettftext($img, 20, 0, 680, 793, $black, 'calibrib.ttf', $row['date_to']); // Date To

    // Save the new image with applicant data inserted
    $certificateImagePath = "generated_certificates/{$row['ref_no']}_certificate.jpg";
    imagejpeg($img, $certificateImagePath);

    // Free up memory
    imagedestroy($img);

    // Create PDF from the generated image
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->Image($certificateImagePath, 0, 0, 210, 297); // Full A4 size
    $pdfPath = "generated_certificates/{$row['ref_no']}_certificate.pdf";
    $pdf->Output('F', $pdfPath); // Save the PDF file

    // Display success message with links to view and email
    echo "Certificate generated successfully.<br>";
    echo "<a href='view_file.php?ref_no={$row['ref_no']}'>View Certificate</a><br>";
    echo "<a href='send_email.php?ref_no={$row['ref_no']}'>Send Certificate via Email</a>";
} else {
    echo "Applicant not found.";
}

// Close database connection
$stmt->close();
$conn->close();
?>