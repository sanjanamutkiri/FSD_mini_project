<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ref_no = $_POST['ref_no'];           // Reference Number to identify record
    $new_name = $_POST['new_name'] ?? null;  // Updated name
    $designation = $_POST['designation'] ?? null;
    $date_from = $_POST['date_from'] ?? null;
    $date_to = $_POST['date_to'] ?? null;
    $date = $_POST['date'] ?? null; 
    $email_id=$_POST['email_id'] ?? null;     // Update date if necessary

    // Check if ref_no is provided
    if (empty($ref_no)) {
        echo "Error: Reference number is required to update records.";
        exit;
    }

    // Initialize the query and fields
    $query = "UPDATE interns SET ";
    $fields = [];
    $params = [];
    $types = "";

    // Add fields to update
    if (!empty($new_name)) {
        $fields[] = "name = ?";
        $params[] = $new_name;
        $types .= "s";
    }
    if (!empty($designation)) {
        $fields[] = "designation = ?";
        $params[] = $designation;
        $types .= "s";
    }
    if (!empty($date_from)) {
        $fields[] = "date_from = ?";
        $params[] = $date_from;
        $types .= "s";
    }
    if (!empty($date_to)) {
        $fields[] = "date_to = ?";
        $params[] = $date_to;
        $types .= "s";
    }
    if (!empty($date)) {
        $fields[] = "date = ?";
        $params[] = $date;
        $types .= "s";
    }
    if (!empty($email_id)) {
        $fields[] = "email_id=?";
        $params[] = $email_id;
        $types .= "s";
    }



    // Build the final query
    if (!empty($fields)) {
        $query .= implode(", ", $fields) . " WHERE ref_no = ?";
        $params[] = $ref_no;
        $types .= "s";

        // Prepare and execute the query
        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Intern details updated successfully.";
            } else {
                echo "No record updated. Please check the provided reference number.";
            }
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "No fields provided to update.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>