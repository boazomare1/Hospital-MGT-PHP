<!DOCTYPE html>
<html>
<head>
    <title>IP Bills Daily Revenue Line Chart</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>IP Bills Daily Revenue Line Chart</h1>
    <canvas id="lineChart" width="800" height="400"></canvas>

    <?php
    // Replace with your database connection credentials
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "evofin";

    // Connect to the database
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Replace 'selected_month' with the month you want to display (e.g., '2023-07')
    $selected_month = 'selected_month';

    // Query to fetch the total amount for each day in the selected month from the 'billing_ip' table
    $query = "SELECT DATE(billdate) AS date, SUM(totalamount) AS total_amount
              FROM billing_ip
              WHERE DATE_FORMAT(billdate, '%Y-%m') = '$selected_month'
              GROUP BY DATE(billdate)";

    $result = mysqli_query($conn, $query);

    // Prepare the data for the chart
    $data_labels = [];
    $data_values = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data_labels[] = $row['date'];
            $data_values[] = $row['total_amount'];
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    <script>
        // Convert PHP data to JavaScript arrays
        var labels = <?php echo json_encode($data_labels); ?>;
        var data = <?php echo json_encode($data_values); ?>;

        // Create a line chart using Chart.js
        var ctx = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Revenue',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day'
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
