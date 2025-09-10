<?php
session_start();
include 'includes/loginverify.php';
include 'db/db_connect.php';

header('Content-Type: application/json');

try {
    // Get search parameters
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $mainAccount = isset($_GET['mainAccount']) ? trim($_GET['mainAccount']) : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;

    // Build WHERE clause for search
    $whereClause = "WHERE s.recordstatus <> 'deleted'";
    $searchParams = [];
    
    if (!empty($search)) {
        $whereClause .= " AND (s.accountssub LIKE ? OR s.shortname LIKE ? OR s.id LIKE ?)";
        $searchTerm = '%' . $search . '%';
        $searchParams[] = $searchTerm;
        $searchParams[] = $searchTerm;
        $searchParams[] = $searchTerm;
    }
    
    if (!empty($mainAccount)) {
        $whereClause .= " AND s.accountsmain = ?";
        $searchParams[] = $mainAccount;
    }

    // Get total count for pagination
    $countQuery = "SELECT COUNT(*) as total FROM master_accountssub s $whereClause";
    $countStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $countQuery);
    
    if (!empty($searchParams)) {
        $types = str_repeat('s', count($searchParams));
        mysqli_stmt_bind_param($countStmt, $types, ...$searchParams);
    }
    
    mysqli_stmt_execute($countStmt);
    $countResult = mysqli_stmt_get_result($countStmt);
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];

    // Get paginated data with main account names
    $query = "SELECT s.auto_number, s.accountsmain, s.accountssub, s.id, s.shortname, s.recorddate, s.username, m.accountsmain as main_account_name FROM master_accountssub s LEFT JOIN master_accountsmain m ON s.accountsmain = m.auto_number $whereClause ORDER BY s.auto_number DESC LIMIT ? OFFSET ?";
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

    $accounts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $accounts[] = [
            'auto_number' => $row['auto_number'],
            'main_account_id' => $row['accountsmain'],
            'main_account_name' => $row['main_account_name'],
            'accountssub' => $row['accountssub'],
            'id' => $row['id'],
            'shortname' => $row['shortname'],
            'recorddate' => $row['recorddate'],
            'username' => $row['username']
        ];
    }

    // Get main account options for filter
    $mainAccountsQuery = "SELECT auto_number, accountsmain FROM master_accountsmain WHERE recordstatus = '' ORDER BY accountsmain ASC";
    $mainAccountsStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $mainAccountsQuery);
    mysqli_stmt_execute($mainAccountsStmt);
    $mainAccountsResult = mysqli_stmt_get_result($mainAccountsStmt);
    
    $mainAccounts = [];
    while ($row = mysqli_fetch_assoc($mainAccountsResult)) {
        $mainAccounts[] = [
            'id' => $row['auto_number'],
            'name' => $row['accountsmain']
        ];
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($countStmt);
    mysqli_stmt_close($mainAccountsStmt);

    echo json_encode([
        'success' => true,
        'accounts' => $accounts,
        'mainAccounts' => $mainAccounts,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'total' => (int)$totalRecords,
            'pages' => ceil($totalRecords / $limit)
        ]
    ]);

} catch (Exception $e) {
    error_log("Error in get_accounts_sub.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error loading accounts sub data'
    ]);
}
?>
