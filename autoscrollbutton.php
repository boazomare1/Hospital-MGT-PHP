<!DOCTYPE html>
<html>
<head>
    <title>Auto-Scrolling Customer Data</title>
    <style>
        /* Optional CSS to style the scrolling container */
        #scrolling-container {
            height: 400px;
            overflow-y: auto;
        }

        /* Add space below the button */
        #scrolling-container + br {
            display: block;
            margin: 2em 0;
        }
    </style>
</head>
<body>
    <button onclick="toggleAutoScroll()">Toggle Auto-Scroll</button>

    <!-- Add two lines of space below the button -->
    <br>
    <br>

    <div id="scrolling-container">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "evofin";

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to fetch data
        $sql = "SELECT customercode, customername, customermiddlename, customerlastname FROM master_customer";

        // Execute the query
        $result = $conn->query($sql);

        // Check if there are any results
        $customers = array();
        if ($result->num_rows > 0) {
            // Store data of each row in the $customers array
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }

            // Output data in an HTML table
            echo "<table>";
            echo "<tr><th>Customer Code</th><th>Customer Name</th><th>Customer Middle Name</th><th>Customer Last Name</th></tr>";
            foreach ($customers as $customer) {
                echo "<tr>";
                echo "<td>" . $customer["customercode"] . "</td>";
                echo "<td>" . $customer["customername"] . "</td>";
                echo "<td>" . $customer["customermiddlename"] . "</td>";
                echo "<td>" . $customer["customerlastname"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No records found.";
        }

        // Close the connection
        $conn->close();
        ?>
    </div>

    <script>
        var customers = <?php echo json_encode($customers); ?>;
        var autoScrollEnabled = false; // Auto-scrolling is initially disabled
        var intervalId; // Variable to store the interval ID
        var scrollSpeed = 2; // Fixed auto-scrolling speed

        // Function to scroll the container automatically
        function autoScroll() {
            if (autoScrollEnabled) {
                var container = document.getElementById("scrolling-container");
                container.scrollTop += scrollSpeed; // Fixed scroll speed (change this value for slower/faster scrolling)
            }
        }

        // Function to toggle auto-scrolling when the button is clicked
        function toggleAutoScroll() {
            autoScrollEnabled = !autoScrollEnabled;
            if (autoScrollEnabled) {
                // Start auto-scrolling when the button is clicked
                intervalId = setInterval(autoScroll, 150);
            } else {
                // Stop auto-scrolling when the button is clicked again
                clearInterval(intervalId);
            }
        }
    </script>
</body>
</html>
