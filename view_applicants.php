<?php
// Include the database connection file
include 'db_connection.php';

// Query to fetch data from your database table
$sql = "SELECT ref_no, serial_number, date, name, designation, date_from, date_to, email_id FROM interns"; 

$result = $conn->query($sql);

// Check if the result has any rows
if ($result->num_rows > 0) {
    // Loop through each row and create table rows dynamically
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['ref_no']) . "</td>";
        echo "<td>" . htmlspecialchars($row['serial_number']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['designation']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date_from']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date_to']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email_id']) . "</td>"; // Display email ID
        echo "<td><button onclick=\"generateFile('" . $row['ref_no'] . "')\">Generate</button></td>";
        echo "<td><button onclick=\"viewFile('" . $row['ref_no'] . "')\">View</button></td>";
        echo "<td><button onclick=\"sendEmail('" . $row['email_id'] . "')\">Send</button></td>"; // Add Send button
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='12'>No applicants found</td></tr>";
}

$conn->close();
?>

<script>
    function generateFile(ref_no) {
        window.location.href = "generate_certificate.php?ref_no=" + ref_no;
    }

    function viewFile(ref_no) {
        window.open("view_file.php?ref_no=" + ref_no, "_blank", "width=800, height=600");
    }

    function sendEmail(email_id) {
        // Redirect to a script that handles email sending
        window.location.href = "send_email.php?email_id=" + encodeURIComponent(email_id);
    }
</script>