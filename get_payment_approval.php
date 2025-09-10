<?php
session_start();
include 'includes/loginverify.php';
include 'db/db_connect.php';

header('Content-Type: application/json');

try {
    // Get search parameters
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $docno = isset($_GET['docno']) ? trim($_GET['docno']) : '';
    $dateFrom = isset($_GET['dateFrom']) ? trim($_GET['dateFrom']) : date('Y-m-d', strtotime('-2 month'));
    $dateTo = isset($_GET['dateTo']) ? trim($_GET['dateTo']) : date('Y-m-d');
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;

    // Build WHERE clause for search
    $whereClause = "WHERE transactiontype = 'PURCHASE' AND transactionmode <> 'CREDIT'";
    $searchParams = [];
    
    if (!empty($search)) {
        $whereClause .= " AND suppliername LIKE ?";
        $searchTerm = '%' . $search . '%';
        $searchParams[] = $searchTerm;
    }
    
    if (!empty($docno)) {
        $whereClause .= " AND paymentvoucherno LIKE ?";
        $docnoTerm = '%' . $docno . '%';
        $searchParams[] = $docnoTerm;
    }
    
    if (!empty($dateFrom) && !empty($dateTo)) {
        $whereClause .= " AND transactiondate BETWEEN ? AND ?";
        $searchParams[] = $dateFrom;
        $searchParams[] = $dateTo;
    }

    // Get total count for pagination
    $countQuery = "SELECT COUNT(DISTINCT paymentvoucherno) as total FROM master_transactionpharmacy $whereClause";
    $countStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $countQuery);
    
    if (!empty($searchParams)) {
        $types = str_repeat('s', count($searchParams));
        mysqli_stmt_bind_param($countStmt, $types, ...$searchParams);
    }
    
    mysqli_stmt_execute($countStmt);
    $countResult = mysqli_stmt_get_result($countStmt);
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];

    // Get paginated data
    $query = "SELECT DISTINCT paymentvoucherno, transactiondate, paymentmode, appvdcheque, suppliername, bankcode, appvdbank FROM master_transactionpharmacy $whereClause ORDER BY auto_number DESC LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query);
    
    if (!empty($searchParams)) {
        $types = str_repeat('s', count($searchParams)) . 'ii';
        $params = array_merge($searchParams, [$limit, $offset]);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    } else {
        mysqli_stmt_bind_param($stmt, 'ii', $limit, $offset);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $payments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Get total amount for this payment voucher
        $amountQuery = "SELECT SUM(approved_amount) as total_amount FROM master_transactionpharmacy WHERE paymentvoucherno = ?";
        $amountStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $amountQuery);
        mysqli_stmt_bind_param($amountStmt, 's', $row['paymentvoucherno']);
        mysqli_stmt_execute($amountStmt);
        $amountResult = mysqli_stmt_get_result($amountStmt);
        $amountRow = mysqli_fetch_assoc($amountResult);
        $totalAmount = isset($amountRow['total_amount']) ? $amountRow['total_amount'] : 0;
        mysqli_stmt_close($amountStmt);

        // Get bank account number
        $bankQuery = "SELECT accountnumber FROM master_bank WHERE bankcode = ? ORDER BY auto_number DESC LIMIT 1";
        $bankStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $bankQuery);
        mysqli_stmt_bind_param($bankStmt, 's', $row['bankcode']);
        mysqli_stmt_execute($bankStmt);
        $bankResult = mysqli_stmt_get_result($bankStmt);
        $bankRow = mysqli_fetch_assoc($bankResult);
        $accountNumber = isset($bankRow['accountnumber']) ? $bankRow['accountnumber'] : '';
        mysqli_stmt_close($bankStmt);

        // Check if payment voucher exists in master_purchase
        $purchaseQuery = "SELECT paymentvoucherno FROM master_purchase WHERE paymentvoucherno = ? AND billnumber IN (SELECT billnumber FROM master_transactionpharmacy WHERE paymentvoucherno = ? AND transactiontype = 'PURCHASE' AND transactionmode <> 'CREDIT')";
        $purchaseStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $purchaseQuery);
        mysqli_stmt_bind_param($purchaseStmt, 'ss', $row['paymentvoucherno'], $row['paymentvoucherno']);
        mysqli_stmt_execute($purchaseStmt);
        $purchaseResult = mysqli_stmt_get_result($purchaseStmt);
        $purchaseExists = mysqli_num_rows($purchaseResult) > 0;
        mysqli_stmt_close($purchaseStmt);

        // Only include if not in master_purchase
        if (!$purchaseExists) {
            $date = explode(" ", $row['transactiondate']);
            
            $payments[] = [
                'date' => $date[0],
                'docno' => $row['paymentvoucherno'],
                'mode' => $row['paymentmode'],
                'instrument_number' => $row['appvdcheque'],
                'supplier_name' => $row['suppliername'],
                'bank_code' => $row['bankcode'],
                'bank_name' => $row['appvdbank'],
                'account_number' => $accountNumber,
                'amount' => $totalAmount
            ];
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($countStmt);

    echo json_encode([
        'success' => true,
        'payments' => $payments,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'total' => (int)$totalRecords,
            'pages' => ceil($totalRecords / $limit)
        ]
    ]);

} catch (Exception $e) {
    error_log("Error in get_payment_approval.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error loading payment approval data'
    ]);
}
?>
