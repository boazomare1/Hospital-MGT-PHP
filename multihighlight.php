<!DOCTYPE html>
<html>
<head>
    <title>Multi-Highlight Table Rows on Click</title>
    <style>
        /* Define the CSS for the highlighted rows */
        .highlight {
            background-color: yellow;
        }
    </style>
</head>
<body>
    <h1>Customer Information</h1>
    <table border="1" id="customerTable">
        <tr>
            <th>Customer Code</th>
            <th>Customer Name</th>
            <th>Customer Middle Name</th>
            <th>Customer Last Name</th>
        </tr>

        <?php
        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "medbot";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to retrieve data from the master_customer table
        $sql = "SELECT customercode, customername, customermiddlename, customerlastname FROM master_customer";
        $result = $conn->query($sql);

        // Check if there are any rows to display
        if ($result->num_rows > 0) {
            // Loop through the rows and display the data
            while ($row = $result->fetch_assoc()) {
                $customerName = $row['customername'];
                $customerLastName = $row['customerlastname'];

                // Add the condition here to determine which rows to highlight
                $highlightClass = ($customerLastName === 'Smith') ? 'highlight' : '';

                echo "<tr class='customer-row $highlightClass' data-row-id='{$row['customercode']}'>";
                echo "<td>" . $row['customercode'] . "</td>";
                echo "<td>" . $customerName . "</td>";
                echo "<td>" . $row['customermiddlename'] . "</td>";
                echo "<td>" . $customerLastName . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found.</td></tr>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </table>

    <script>
        // JavaScript code to handle row highlighting on click
        document.addEventListener('DOMContentLoaded', function() {
            const tableRows = document.querySelectorAll('.customer-row');

            tableRows.forEach((row) => {
                row.addEventListener('click', () => {
                    // Toggle the 'highlight' class on clicking the row
                    row.classList.toggle('highlight');
                });
            });
        });
    </script>
</body>
</html>
