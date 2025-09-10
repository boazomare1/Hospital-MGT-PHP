<?php
session_start();
include ("db/db_connect.php");

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get search parameters
$search_type = isset($_GET['search_type']) ? $_GET['search_type'] : '0';
$search_account = isset($_GET['search_account']) ? $_GET['search_account'] : '';
$search_docno = isset($_GET['search_docno']) ? $_GET['search_docno'] : '';
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

// Build the query based on search parameters
$where_conditions = [];
$params = [];

if ($search_type == '1') {
    $where_conditions[] = "recordstatus = 'allocated'";
} else {
    $where_conditions[] = "(recordstatus != 'allocated' OR recordstatus IS NULL)";
}

if (!empty($search_account)) {
    $where_conditions[] = "subtype LIKE ?";
    $params[] = "%$search_account%";
}

if (!empty($search_docno)) {
    $where_conditions[] = "docno LIKE ?";
    $params[] = "%$search_docno%";
}

if (!empty($from_date)) {
    $where_conditions[] = "transactiondate >= ?";
    $params[] = $from_date;
}

if (!empty($to_date)) {
    $where_conditions[] = "transactiondate <= ?";
    $params[] = $to_date;
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Get account receivable data from database
$query = "SELECT 
            auto_number,
            transactiondate,
            subtype,
            docno,
            mode,
            instnumber,
            transactionamount,
            receivableamount,
            recordstatus
          FROM master_transactionpaylater 
          $where_clause
          ORDER BY transactiondate DESC, auto_number DESC";

$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query);

if ($stmt) {
    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$result) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database error: ' . mysqli_error($GLOBALS["___mysqli_ston"])]);
        exit;
    }
    
    $transactions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Calculate pending amount
        $pending_amount = (float)$row['receivableamount'] - (float)$row['transactionamount'];
        
        // Clean and format the data
        $transactions[] = [
            'auto_number' => (int)$row['auto_number'],
            'transactiondate' => $row['transactiondate'],
            'subtype' => htmlspecialchars($row['subtype']),
            'docno' => htmlspecialchars($row['docno']),
            'mode' => htmlspecialchars($row['mode']),
            'instnumber' => htmlspecialchars($row['instnumber']),
            'transactionamount' => number_format((float)$row['transactionamount'], 2),
            'receivableamount' => number_format((float)$row['receivableamount'], 2),
            'pending_amount' => number_format($pending_amount, 2),
            'recordstatus' => isset($row['recordstatus']) ? $row['recordstatus'] : ''
        ];
    }
    
    mysqli_stmt_close($stmt);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . mysqli_error($GLOBALS["___mysqli_ston"])]);
    exit;
}

// Set JSON header
header('Content-Type: application/json');

// Return the data
echo json_encode(['success' => true, 'transactions' => $transactions]);
?>
