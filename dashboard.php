<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Management Portal</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
        h2 {
            color: #007BFF;
        }
        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .tabs button {
            padding: 10px 20px;
            border: none;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            font-size: 16px;
            background-color: transparent;
        }
        .tabs button.active {
            border-bottom: 2px solid #007BFF;
            font-weight: bold;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input[type="text"] {
            width: 70%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }
        .search-bar button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #0056b3;
        }
        .btn {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            align-items: center;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        form {
            margin-top: 20px;
        }
        form input, form button {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        form button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Intern Management Portal</h1>
        <!-- Tabs -->
        <div class="tabs">
            <button class="tab-btn active" onclick="showSection(event, 'view')">View Applicants</button>
            <button class="tab-btn" onclick="showSection(event, 'add')">Add Applicant</button>
            <button class="tab-btn" onclick="showSection(event, 'modify')">Modify Applicant</button>
            <button class="tab-btn" onclick="showSection(event, 'delete')">Delete Applicant</button>
        </div>

        <!-- Sections -->
        <div id="view" class="content-section active">
            <h2>View Applicants</h2>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search by Name or Designation">
                <button onclick="searchInterns()">Search</button>
            </div>
            <table id="applicantTable">
                <thead>
                    <tr>
                        <th>Ref No</th>
                        <th>Serial Number</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Date From</th>
                        <th>Date To</th>
                        <th>Email</th> <!-- Added email column -->
                        <th>Generate File</th>
                        <th>View File</th>
                        <th>Send File</th>
                    </tr>
                </thead>
                <tbody>
                <?php include 'view_applicants.php'; ?>
                </tbody>
            </table>
        </div>

        <div id="add" class="content-section">
            <h2>Add Applicant</h2>
            <form method="POST" action="add_applicant.php">
                <label for="ref_no">Ref No:</label>
                <input type="text" id="ref_no" name="ref_no" required><br>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required><br>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br>

                <label for="designation">Designation:</label>
                <input type="text" id="designation" name="designation" required><br>

                <label for="date_from">Date From:</label>
                <input type="date" id="date_from" name="date_from" required><br>

                <label for="date_to">Date To:</label>
                <input type="date" id="date_to" name="date_to" required><br>

                <label for="email_id">Email:</label> <!-- Added email field -->
                <input type="email" id="email_id" name="email_id" required><br>

                <button type="submit" name="submit">Add Applicant</button>
            </form>
        </div>

        <div id="modify" class="content-section">
            <h2>Modify Applicant</h2>
            <form method="POST" action="modify_applicant.php">
                <label for="ref_no">Ref No:</label>
                <input type="text" id="ref_no" name="ref_no" required><br>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date"><br>

                <label for="modify_name">Name:</label>
                <input type="text" id="modify_name" name="name" required><br>

                <label for="modify_designation">Designation:</label>
                <input type="text" id="modify_designation" name="designation"><br>

                <label for="modify_date_from">Date From:</label>
                <input type="date" id="modify_date_from" name="date_from"><br>

                <label for="modify_date_to">Date To:</label>
                <input type="date" id="modify_date_to" name="date_to"><br>

                <label for="modify_email_id">Email:</label> <!-- Added email field -->
                <input type="email" id="modify_email_id" name="email_id"><br>

                <button type="submit" name="update">Modify Applicant</button>
            </form>
        </div>

        <div id="delete" class="content-section">
            <h2>Delete Applicant</h2>
            <form method="POST" action="delete_applicant.php">
                <label for="ref_no">Ref No:</label>
                <input type="text" id="ref_no" name="ref_no" required><br>

                <button type="submit" name="delete">Delete Applicant</button>
            </form>
        </div>

    </div>

    <script>
        function showSection(event, sectionId) {
            const sections = document.querySelectorAll('.content-section');
            const buttons = document.querySelectorAll('.tab-btn');
            sections.forEach(section => section.classList.remove('active'));
            buttons.forEach(button => button.classList.remove('active'));

            document.getElementById(sectionId).classList.add('active');
            event.target.classList.add('active');
        }

        function searchInterns() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#applicantTable tbody tr');
            
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const designation = row.cells[2].textContent.toLowerCase();

                if (name.includes(searchInput) || designation.includes(searchInput)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>