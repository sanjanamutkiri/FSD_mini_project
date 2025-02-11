<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ref_no = $_POST['ref_no'];  // Reference Number to identify record

    // Check if ref_no is provided
    if (empty($ref_no)) {
        echo "Error: Reference number is required to delete records.";
        exit;
    }

    // Prepare the SQL query
    $query = "DELETE FROM interns WHERE ref_no = ?";

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $ref_no);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Intern deleted successfully.";
        } else {
            echo "No record found with the provided reference number.";
        }
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}
$conn->close();
?>
