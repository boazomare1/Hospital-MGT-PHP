<!DOCTYPE html>
<html>
<head>
    <title>Auto-Scrolling Customer Data</title>
    <style>
        /* Optional CSS to style the scrolling container */
        #scrolling-container {
            height: 500px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
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

            // Output data of each row
            foreach ($customers as $customer) {
                echo "Customer Code: " . $customer["customercode"] . "<br>";
                echo "Customer Name: " . $customer["customername"] . "<br>";
                echo "Customer Middle Name: " . $customer["customermiddlename"] . "<br>";
                echo "Customer Last Name: " . $customer["customerlastname"] . "<br>";
                echo "------------------------<br>";
            }
        } else {
            echo "No records found.";
        }

        // Close the connection
        $conn->close();
        ?>
    </div>

    <script>
        var customers = <?php echo json_encode($customers); ?>;
        var autoScrollEnabled = true; // Variable to track auto-scrolling status

        // Function to scroll the container automatically
        function autoScroll() {
            if (autoScrollEnabled) {
                var container = document.getElementById("scrolling-container");
                container.scrollTop += 2; // Adjust the scroll speed here (higher value for faster scrolling)
            }
        }

        // Call the autoScroll function every 50 milliseconds (adjust the interval as needed)
        setInterval(autoScroll, 120);

        // Function to toggle auto-scrolling when the container is clicked
        function toggleAutoScroll() {
            autoScrollEnabled = !autoScrollEnabled;
        }

        // Add event listener to the scrolling container to toggle auto-scrolling on click
        var container = document.getElementById("scrolling-container");
        container.addEventListener("click", toggleAutoScroll);
    </script>
</body>
</html>
