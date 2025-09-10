<?php
session_start();
include 'includes/loginverify.php';
include 'db/db_connect.php';

header('Content-Type: application/json');

try {
    // Get search parameters
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;

    // Build WHERE clause for search
    $whereClause = "WHERE recordstatus <> 'deleted'";
    $searchParams = [];
    
    if (!empty($search)) {
        $whereClause .= " AND (accountssub LIKE ? OR auto_number LIKE ?)";
        $searchTerm = '%' . $search . '%';
        $searchParams = [$searchTerm, $searchTerm];
    }

    // Get total count
    $countQuery = "SELECT COUNT(*) as total FROM master_accountssub $whereClause";
    $countStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $countQuery);
    
    if (!empty($searchParams)) {
        mysqli_stmt_bind_param($countStmt, 'ss', $searchParams[0], $searchParams[1]);
    }
    
    mysqli_stmt_execute($countStmt);
    $countResult = mysqli_stmt_get_result($countStmt);
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];

    // Get paginated data
    $query = "SELECT * FROM master_accountssub $whereClause ORDER BY accountssub LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query);
    
    if (!empty($searchParams)) {
        mysqli_stmt_bind_param($stmt, 'ssii', $searchParams[0], $searchParams[1], $limit, $offset);
    } else {
        mysqli_stmt_bind_param($stmt, 'ii', $limit, $offset);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $accounts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Get parent account name
        $parentName = 'Main Account';
        if ($row['parentid'] != '0' && !empty($row['parentid'])) {
            $parentQuery = "SELECT accountssub FROM master_accountssub WHERE auto_number = ? AND recordstatus <> 'deleted'";
            $parentStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $parentQuery);
            mysqli_stmt_bind_param($parentStmt, 's', $row['parentid']);
            mysqli_stmt_execute($parentStmt);
            $parentResult = mysqli_stmt_get_result($parentStmt);
            if ($parentRow = mysqli_fetch_assoc($parentResult)) {
                $parentName = $parentRow['accountssub'];
            }
            mysqli_stmt_close($parentStmt);
        }

        $accounts[] = [
            'id' => $row['auto_number'],
            'account_name' => $row['accountssub'],
            'parent_section' => $parentName,
            'status' => $row['recordstatus'] != 'deleted' ? 'Active' : 'Inactive',
            'recordstatus' => $row['recordstatus']
        ];
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($countStmt);

    echo json_encode([
        'success' => true,
        'accounts' => $accounts,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'total' => (int)$totalRecords,
            'pages' => ceil($totalRecords / $limit)
        ]
    ]);

} catch (Exception $e) {
    error_log("Error in get_accounts_main.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error loading accounts data'
    ]);
}
?>















