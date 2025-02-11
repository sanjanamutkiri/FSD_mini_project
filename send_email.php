<?php
// Include necessary files
include 'db_connection.php';
require __DIR__ . '/vendor/autoload.php'; // Include Composer's autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get the ref_no from the URL and sanitize it
$ref_no = isset($_GET['ref_no']) ? htmlspecialchars($_GET['ref_no']) : '';

// Query to fetch the applicant's data based on ref_no
$sql = "SELECT ref_no, name, email_id FROM interns WHERE ref_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ref_no);
$stmt->execute();
$result = $stmt->get_result();

// Check if the applicant exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Path to the generated PDF certificate
    $pdfPath = __DIR__ . "/generated_certificates/{$row['ref_no']}_certificate.pdf";

    // Check if the PDF certificate exists
    if (file_exists($pdfPath)) {
        // Send the certificate via email
        $status = sendEmailWithAttachment(
            $row['email_id'],
            "Suvidha Offer Letter",
            "Greetings of the day!<br><br>
            Congratulations! We are pleased to offer you the opportunity to join Suvidha Foundation as an intern. 
            Please find attached the detailed offer letter for your reference.<br><br>
            To formally accept this offer, kindly review the attached document and return a physically or digitally signed copy of the Offer Letter within 48 hours.<br><br>
            Upon successful completion of your internship, you will receive a Certificate of Completion. Based on your performance during the internship, you may also be awarded a Letter of Recommendation.<br><br>
            We are thrilled to welcome you to our team and look forward to working with you. If you have any questions or need further clarification, please feel free to contact us.<br><br>
            Best regards,<br>Suvidha Foundation Team",
            $pdfPath
        );

        // Display email status
        echo $status;
    } else {
        echo "Certificate PDF not found.";
    }
} else {
    echo "Applicant not found.";
}

// Close database connection
$stmt->close();
$conn->close();

function sendEmailWithAttachment($to, $subject, $msg, $attachmentPath) {
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'komalkalshetti989@gmail.com'; // Your Gmail address
        $mail->Password = 'wausnmwcvlaszygl'; // Your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email headers and content
        $mail->setFrom('komalkalshetti989@gmail.com', 'Suvidha Foundation');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $msg;

        // Attachment
        $mail->addAttachment($attachmentPath);

        // Send email
        $mail->send();
        return "Email sent successfully to $to.";
    } catch (Exception $e) {
        return "Error sending email: " . $mail->ErrorInfo;
    }
}
?>
