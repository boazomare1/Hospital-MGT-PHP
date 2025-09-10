<?php
// Include your database connection code here
$host = 'locationhost';
$dbname = 'evofin';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data for pie chart
    $specificDate = '2023-08-23'; // Change to your desired date
    $queryPie = "SELECT billamount FROM master_billing WHERE DATE(billingdatetime) = :specificDate";
    $stmtPie = $db->prepare($queryPie);
    $stmtPie->bindParam(':specificDate', $specificDate);
    $stmtPie->execute();
    $pieData = $stmtPie->fetchAll(PDO::FETCH_COLUMN);

    // Fetch data for bar chart
    $queryBar = "SELECT DATE(billingdatetime) AS billingdate, SUM(billamount) AS totalamount FROM master_billing GROUP BY billingdate";
    $stmtBar = $db->query($queryBar);
    $barData = $stmtBar->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chart Example</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Pie and Bar Charts Example</h1>
    <div style="width: 50%; margin: auto;">
        <canvas id="pieChart"></canvas>
        <canvas id="barChart"></canvas>
    </div>

    <script>
        // Pie Chart
        var pieCtx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Bill 1', 'Bill 2', 'Bill 3'], // You can customize these labels
                datasets: [{
                    data: <?php echo json_encode($pieData); ?>,
                    backgroundColor: ['red', 'blue', 'green'], // You can customize these colors
                }],
            },
        });

        // Bar Chart
        var barCtx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($barData, 'billingdate')); ?>,
                datasets: [{
                    label: 'Total Amount',
                    data: <?php echo json_encode(array_column($barData, 'totalamount')); ?>,
                    backgroundColor: 'blue', // You can customize this color
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>
</body>
</html>
