<?php
// Establish a database connection (replace with your credentials)
$host = 'localhost';
$db   = 'evofin';
$user = 'root';
$pass = '';

try {
    $dsn = "mysql:host=$host;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get the selected date range from the user (replace with your own implementation)
$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];

// Prepare the SQL query to fetch the data within the date range
$sql = "SELECT DATE(billing_date) AS date, SUM(totalamount) AS total
        FROM billing_ip
        WHERE billing_date BETWEEN :start_date AND :end_date
        GROUP BY DATE(billing_date)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':start_date', $startDate);
$stmt->bindParam(':end_date', $endDate);
$stmt->execute();

// Fetch the results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the data for the chart
$labels = [];
$data = [];

foreach ($results as $row) {
    $labels[] = $row['date'];
    $data[] = $row['total'];
}

// Generate the JavaScript code for the chart using Chart.js library
?>
<!DOCTYPE html>
<html>
<head>
    <title>Line Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="lineChart"></canvas>
    <script>
        var ctx = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Total Amount',
                    data: <?php echo json_encode($data); ?>,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Total Amount'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
