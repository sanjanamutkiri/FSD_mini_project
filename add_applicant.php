<?php
if (isset($_POST['submit'])) {
    // Retrieve form data
    $ref_no = $_POST['ref_no'];        // New field
    $date = $_POST['date'];           // New field
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];
    $email_id = $_POST['email_id'];   // New field

    // Include database connection
    include 'db_connection.php';

    // Prepare SQL statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO interns (ref_no, date, name, designation, date_from, date_to, email_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $ref_no, $date, $name, $designation, $date_from, $date_to, $email_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "New applicant added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>