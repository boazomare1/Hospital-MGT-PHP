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
$search_account = isset($_GET['search_account']) ? $_GET['search_account'] : '';
$as_on_date = isset($_GET['as_on_date']) ? $_GET['as_on_date'] : date('Y-m-d');

// Build the query based on search parameters
$where_conditions = [];
$params = [];

// Base condition for outstanding amounts (unpaid bills)
$where_conditions[] = "billstatus = 'unpaid'";

// Filter by insurance/corporate accounts (subtype contains insurance company names)
$where_conditions[] = "subtype IS NOT NULL AND subtype != ''";

if (!empty($search_account)) {
    $where_conditions[] = "accountname LIKE ?";
    $params[] = "%$search_account%";
}

if (!empty($as_on_date)) {
    $where_conditions[] = "billdate <= ?";
    $params[] = $as_on_date;
}

$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);

// Get corporate outstanding data from database
$query = "SELECT 
            auto_number,
            billdate as transactiondate,
            accountname as description,
            patientcode as mrdnumber,
            billno as billnumber,
            billdate as dispatchdate,
            totalamount as transactionamount,
            totalamount as receivableamount,
            DATEDIFF('$as_on_date', billdate) as days_outstanding
          FROM billing_paylater 
          $where_clause
          ORDER BY billdate DESC, auto_number DESC";

// Debug: Log the query for troubleshooting
error_log("Corporate Outstanding Query: " . $query);
error_log("Where conditions: " . print_r($where_conditions, true));

$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query);

if ($stmt) {
    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    $execute_result = mysqli_stmt_execute($stmt);
    if (!$execute_result) {
        error_log("Execute error: " . mysqli_stmt_error($stmt));
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Execute error: ' . mysqli_stmt_error($stmt)]);
        exit;
    }
    
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$result) {
        error_log("Get result error: " . mysqli_stmt_error($stmt));
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Get result error: ' . mysqli_stmt_error($stmt)]);
        exit;
    }
    
    $transactions = [];
    $total_outstanding = 0;
    $age_buckets = [
        '0-30' => 0,
        '31-60' => 0,
        '61-90' => 0,
        '91-120' => 0,
        '120+' => 0
    ];
    
    $row_count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $row_count++;
        // For billing_paylater, the outstanding amount is the total amount since billstatus = 'unpaid'
        $outstanding_amount = (float)$row['transactionamount'];
        $days = (int)$row['days_outstanding'];
        
        // Skip if no outstanding amount
        if ($outstanding_amount <= 0) {
            continue;
        }
        
        // Calculate age bucket
        $age_bucket = '';
        if ($days <= 30) {
            $age_bucket = '0-30';
            $age_buckets['0-30'] += $outstanding_amount;
        } elseif ($days <= 60) {
            $age_bucket = '31-60';
            $age_buckets['31-60'] += $outstanding_amount;
        } elseif ($days <= 90) {
            $age_bucket = '61-90';
            $age_buckets['61-90'] += $outstanding_amount;
        } elseif ($days <= 120) {
            $age_bucket = '91-120';
            $age_buckets['91-120'] += $outstanding_amount;
        } else {
            $age_bucket = '120+';
            $age_buckets['120+'] += $outstanding_amount;
        }
        
        $total_outstanding += $outstanding_amount;
        
        // Clean and format the data
        $transactions[] = [
            'auto_number' => (int)$row['auto_number'],
            'transactiondate' => $row['transactiondate'],
            'description' => htmlspecialchars($row['description']),
            'mrdnumber' => htmlspecialchars($row['mrdnumber']),
            'billnumber' => htmlspecialchars($row['billnumber']),
            'dispatchdate' => $row['dispatchdate'],
            'transactionamount' => number_format((float)$row['transactionamount'], 2),
            'receivableamount' => number_format((float)$row['receivableamount'], 2),
            'outstanding_amount' => number_format($outstanding_amount, 2),
            'days_outstanding' => $days,
            'age_bucket' => $age_bucket
        ];
    }
    
    error_log("Total rows processed: $row_count, Transactions array size: " . count($transactions));
    
    mysqli_stmt_close($stmt);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . mysqli_error($GLOBALS["___mysqli_ston"])]);
    exit;
}

// Set JSON header
header('Content-Type: application/json');

// Return the data with summary
echo json_encode([
    'success' => true, 
    'transactions' => $transactions,
    'summary' => [
        'total_outstanding' => number_format($total_outstanding, 2),
        'total_count' => count($transactions),
        'age_buckets' => [
            '0-30' => number_format($age_buckets['0-30'], 2),
            '31-60' => number_format($age_buckets['31-60'], 2),
            '61-90' => number_format($age_buckets['61-90'], 2),
            '91-120' => number_format($age_buckets['91-120'], 2),
            '120+' => number_format($age_buckets['120+'], 2)
        ]
    ]
]);
?>
