<?php
// Database connection settings
$host = 'localhost';
$dbname = 'evofin';
$username = 'root';
$password = '';

// Record the start time
$start_time = microtime(true);

try {
    // Connect to the database using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to retrieve the desired columns from the table
    $sql = "SELECT ledger_id, transaction_amount FROM tb ORDER BY ledger_id";

    // Execute the query
    $stmt = $pdo->query($sql);

    // Fetch the data and store it in a variable
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate the running total and find highest and lowest amounts
    $runningTotal = 0;
    $highestAmount = PHP_INT_MIN;
    $lowestAmount = PHP_INT_MAX;

    foreach ($data as &$row) {
        $runningTotal += $row['transaction_amount'];
        $row['running_total'] = number_format($runningTotal, 2); // Format to two decimal places

        // Find highest amount
        if ($row['transaction_amount'] > $highestAmount) {
            $highestAmount = $row['transaction_amount'];
        }

        // Find lowest amount
        if ($row['transaction_amount'] < $lowestAmount) {
            $lowestAmount = $row['transaction_amount'];
        }
    }
} catch (PDOException $e) {
    // Handle any database connection errors
    die("Connection failed: " . $e->getMessage());
}

// Record the end time
$end_time = microtime(true);

// Calculate the time taken to fetch the data
$time_taken = $end_time - $start_time;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fixed Headers Table with Running Total and Alternating Row Colors</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        /* Alternating row colors */
        tbody tr:nth-child(odd) {
            background-color: #e6f7e7; /* Light green color for odd rows */
        }

        tbody tr:nth-child(even) {
            background-color: #e7f3ff; /* Light blue color for even rows */
        }

        /* Right-align data in the columns */
        td {
            text-align: right;
        }

        /* Highlight highest and lowest amounts with yellow color */
        .highlight-highest td {
            background-color: yellow;
        }

        .highlight-lowest td {
            background-color: yellow;
        }
    </style>
</head>
<body>
    <p>Time taken to fetch data: <?php echo round($time_taken, 4); ?> seconds</p>

    <table>
        <thead>
            <tr>
                <th>Ledger ID</th>
                <th>Transaction Amount</th>
                <th>Running Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr <?php if ($row['transaction_amount'] === $highestAmount) echo 'class="highlight-highest"'; ?>
                    <?php if ($row['transaction_amount'] === $lowestAmount) echo 'class="highlight-lowest"'; ?>>
                    <td><?php echo $row['ledger_id']; ?></td>
                    <td><?php echo number_format($row['transaction_amount'], 2); ?></td>
                    <td><?php echo $row['running_total']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
