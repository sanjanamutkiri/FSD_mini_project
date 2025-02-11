<?php
// Include necessary files
include 'db_connection.php';

// Get the ref_no from URL
$ref_no = $_GET['ref_no'];

// Fetch applicant details
$sql = "SELECT name, email FROM interns WHERE ref_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ref_no);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $to = $row['email'];
    $subject = "Your Certificate";
    $message = "Dear " . $row['name'] . ",\n\nPlease find your certificate attached.\n\nBest Regards,\nTeam";

    $headers = "From: your_email@example.com\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-".rand()."\"\r\n";

    $attachmentPath = "generated_certificates/{$ref_no}_certificate.jpg";
    $attachment = chunk_split(base64_encode(file_get_contents($attachmentPath)));

    $body = "--PHP-mixed-".rand()."\r\n";
    $body .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $message."\r\n";
    $body .= "--PHP-mixed-".rand()."\r\n";
    $body .= "Content-Type: application/octet-stream; name=\"certificate.jpg\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"certificate.jpg\"\r\n\r\n";
    $body .= $attachment."\r\n";
    $body .= "--PHP-mixed-".rand()."--";

    if (mail($to, $subject, $body, $headers)) {
        echo "Certificate sent successfully!";
    } else {
        echo "Failed to send the certificate.";
    }
} else {
    echo "Applicant not found.";
}

$stmt->close();
$conn->close();
?>
