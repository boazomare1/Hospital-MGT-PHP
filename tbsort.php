<?php
// Replace these with your actual database credentials
$host = 'localhost';
$dbname = 'evofin';
$username = 'root';
$password = '';

try {
    // Connect to the database using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sorting parameters
    $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'doc_number';
    $sortOrder = isset($_GET['order']) && strtoupper($_GET['order']) === 'DESC' ? 'DESC' : 'ASC';

    // SQL query to retrieve the desired columns from the table and apply sorting
    $sql = "SELECT doc_number, ledger_id FROM tb ORDER BY $sortColumn $sortOrder";

    // Execute the query
    $stmt = $pdo->query($sql);

    // Fetch the data and store it in a variable
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle any database connection errors
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fixed Headers Table with Sorting</title>
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
            cursor: pointer; /* Add cursor style for clickable headers */
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        // JavaScript function to handle sorting
        function sortTable(column) {
            const currentOrder = new URL(window.location.href).searchParams.get('order');
            const sortOrder = (currentOrder === 'DESC' && column === new URL(window.location.href).searchParams.get('sort')) ? 'ASC' : 'DESC';

            const url = new URL(window.location.href);
            url.searchParams.set('sort', column);
            url.searchParams.set('order', sortOrder);

            window.location.href = url.toString();
        }
    </script>
</head>
<body>
    <table>

      
	  <!-- ... (Previous PHP and HTML code) ... -->

<thead>
    <tr>
        <th onclick="sortTable('doc_number')">
            Document Number
            <?php if ($sortColumn === 'doc_number'): ?>
                <?php if ($sortOrder === 'ASC'): ?>
                    &#9650; <!-- Up arrow symbol -->
                <?php else: ?>
                    &#9660; <!-- Down arrow symbol -->
                <?php endif; ?>
            <?php endif; ?>
        </th>
        <th onclick="sortTable('ledger_id')">
            Ledger ID
            <?php if ($sortColumn === 'ledger_id'): ?>
                <?php if ($sortOrder === 'ASC'): ?>
                    &#9650; <!-- Up arrow symbol -->
                <?php else: ?>
                    &#9660; <!-- Down arrow symbol -->
                <?php endif; ?>
            <?php endif; ?>
        </th>
    </tr>
</thead>

<!-- ... (Rest of the code remains unchanged) ... -->

        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?php echo $row['doc_number']; ?></td>
                    <td><?php echo $row['ledger_id']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
