<!DOCTYPE html>
<html>
<head>
    <title>Customer Data</title>
    <style>
        /* Optional CSS to style the scrolling container */
        #data-table {
            width: 100%;
            border-collapse: collapse;
        }

        #data-table th,
        #data-table td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        #data-table th {
            background-color: #f2f2f2;
        }

        #data-table tr {
            cursor: pointer;
        }

        #data-table tr.highlight {
            background-color: yellow;
        }
    </style>
</head>
<body>
    <table id="data-table">
        <tr>
            <th>Customer Code</th>
            <th>Customer Name</th>
            <th>Customer Middle Name</th>
            <th>Customer Last Name</th>
        </tr>
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

        // Initial number of rows to fetch
        $limit = 10;

        // SQL query to fetch data with limit
        $sql = "SELECT customercode, customername, customermiddlename, customerlastname FROM master_customer LIMIT $limit";

        // Execute the query
        $result = $conn->query($sql);

        // Check if there are any results
        if ($result->num_rows > 0) {
            // Output data in an HTML table
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["customercode"] . "</td>";
                echo "<td>" . $row["customername"] . "</td>";
                echo "<td>" . $row["customermiddlename"] . "</td>";
                echo "<td>" . $row["customerlastname"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found.</td></tr>";
        }

        // Close the connection
        $conn->close();
        ?>
    </table>

    <script>
        var highlightedRow = null; // Reference to the currently highlighted row
        var limit = <?php echo $limit; ?>;
        var offset = <?php echo $limit; ?>;

        // Function to highlight a row with yellow color
        function highlightRow(row) {
            if (highlightedRow) {
                highlightedRow.classList.remove("highlight");
            }
            row.classList.add("highlight");
            highlightedRow = row;
        }

        // Function to fetch more data using AJAX when scrolling to the bottom
        function fetchMoreData() {
            var table = document.getElementById("data-table");
            var rows = table.getElementsByTagName("tr");
            var lastRow = rows[rows.length - 1];

            var rect = lastRow.getBoundingClientRect();
            if (rect.bottom <= window.innerHeight) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        var data = JSON.parse(xhr.responseText);
                        if (data.length > 0) {
                            for (var i = 0; i < data.length; i++) {
                                var newRow = document.createElement("tr");
                                newRow.innerHTML = "<td>" + data[i].customercode + "</td><td>" + data[i].customername + "</td><td>" + data[i].customermiddlename + "</td><td>" + data[i].customerlastname + "</td>";
                                table.appendChild(newRow);
                            }
                            offset += data.length;
                        }
                    }
                };
                xhr.open("GET", "get_data.php?limit=" + limit + "&offset=" + offset, true);
                xhr.send();
            }
        }

        // Event listener for scrolling on window
        window.addEventListener("scroll", fetchMoreData);

        var rows = document.getElementsByTagName("tr");
        for (var i = 1; i < rows.length; i++) {
            rows[i].addEventListener("click", function() {
                highlightRow(this);
            });
        }
    </script>
</body>
</html>
