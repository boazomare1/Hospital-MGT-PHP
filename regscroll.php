<!DOCTYPE html>
<html>
<head>
    <title>Customer Data</title>
    <style>
        /* Add any CSS styles for the table here */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table id="customer-table">
        <thead>
            <tr>
                <th>Customer Code</th>
                <th>Customer Name</th>
                <th>Gender</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated here using PHP -->
            <?php include('fetch_data.php'); ?>
        </tbody>
    </table>

    <script>
        // JavaScript code for scrolling down slowly after data is populated
        function scrollToBottom() {
            const table = document.getElementById('customer-table');
            const tableHeight = table.scrollHeight;
            window.scrollTo({
                top: tableHeight,
                behavior: 'smooth'
            });
        }

        // Call the function after the page is loaded
        window.onload = function() {
            scrollToBottom();
        };
    </script>
</body>
</html>


<?php
// Replace the database credentials with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evofin";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the master_customer table
$sql = "SELECT customercode, customername, gender FROM master_customer";
$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Loop through the data and create table rows
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["customercode"] . "</td>";
        echo "<td>" . $row["customername"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No data found.</td></tr>";
}

// Close the connection
$conn->close();
?>
