<?php
// Include the necessary database connection file
include 'db_connection.php';

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
    
    // Path to the generated certificate image
    $certificatePath = "generated_certificates/{$row['ref_no']}_certificate.jpg";
    
    // Check if the certificate file exists
    if (file_exists($certificatePath)) {
        // Display the certificate image
        echo '<html>';
        echo '<head>';
        echo '<style>';
        echo 'body, html {';
        echo '    margin: 0;';
        echo '    padding: 0;';
        echo '    height: 100%;';
        echo '    display: flex;';
        echo '    justify-content: center;';
        echo '    align-items: center;';
        echo '    overflow: hidden;';
        echo '}';
        echo 'img {';
        echo '    width: 100%;';
        echo '    height: 100%;';
        echo '    object-fit: contain;';
        echo '}';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        echo "<h2>Certificate for " . htmlspecialchars($row['name']) . "</h2>";
        echo "<img src='$certificatePath' alt='Certificate' />";
        echo '</body>';
        echo '</html>';
    } else {
        echo "Certificate not found.";
    }
} else {
    echo "Applicant not found.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
