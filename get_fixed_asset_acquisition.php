<?php
session_start();
include 'includes/loginverify.php';
include 'db/db_connect.php';

header('Content-Type: application/json');

try {
    // Get search parameters
    $dateFrom = isset($_GET['dateFrom']) ? trim($_GET['dateFrom']) : date('Y-m-d', strtotime('-1 month'));
    $dateTo = isset($_GET['dateTo']) ? trim($_GET['dateTo']) : date('Y-m-d');
    $location = isset($_GET['location']) ? trim($_GET['location']) : '';
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;

    // Build WHERE clause for search
    $whereClause = "WHERE entrydate BETWEEN ? AND ? AND recordstatus = ''";
    $searchParams = [$dateFrom, $dateTo];
    
    if (!empty($location)) {
        $whereClause .= " AND locationcode = ?";
        $searchParams[] = $location;
    }
    
    if (!empty($search)) {
        $whereClause .= " AND (itemname LIKE ? OR asset_id LIKE ? OR serial_number LIKE ? OR suppliername LIKE ?)";
        $searchTerm = '%' . $search . '%';
        $searchParams[] = $searchTerm;
        $searchParams[] = $searchTerm;
        $searchParams[] = $searchTerm;
        $searchParams[] = $searchTerm;
    }

    // Get total count for pagination
    $countQuery = "SELECT COUNT(*) as total FROM assets_register $whereClause";
    $countStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $countQuery);
    
    if (!empty($searchParams)) {
        $types = str_repeat('s', count($searchParams));
        mysqli_stmt_bind_param($countStmt, $types, ...$searchParams);
    }
    
    mysqli_stmt_execute($countStmt);
    $countResult = mysqli_stmt_get_result($countStmt);
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];

    // Get paginated data
    $query = "SELECT auto_number, asset_id, itemname, itemcode, rate, entrydate, suppliername, 
                     asset_category, serial_number, asset_class, asset_department, asset_unit, 
                     asset_period, startyear, locationcode, responsible_employee 
              FROM assets_register $whereClause 
              ORDER BY auto_number DESC LIMIT ? OFFSET ?";
    
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

    $assets = [];
    $totalAcquisitionCost = 0;
    
    while ($row = mysqli_fetch_assoc($result)) {
        $totalAcquisitionCost += $row['rate'];
        
        $assets[] = [
            'auto_number' => $row['auto_number'],
            'asset_id' => $row['asset_id'],
            'itemname' => $row['itemname'],
            'itemcode' => $row['itemcode'],
            'rate' => $row['rate'],
            'entrydate' => $row['entrydate'],
            'suppliername' => $row['suppliername'],
            'asset_category' => $row['asset_category'],
            'serial_number' => $row['serial_number'],
            'asset_class' => $row['asset_class'],
            'asset_department' => $row['asset_department'],
            'asset_unit' => $row['asset_unit'],
            'asset_period' => $row['asset_period'],
            'startyear' => $row['startyear'],
            'locationcode' => $row['locationcode'],
            'responsible_employee' => $row['responsible_employee']
        ];
    }

    // Get location options for filter
    $locationQuery = "SELECT DISTINCT locationcode FROM assets_register WHERE recordstatus = '' ORDER BY locationcode ASC";
    $locationStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $locationQuery);
    mysqli_stmt_execute($locationStmt);
    $locationResult = mysqli_stmt_get_result($locationStmt);
    
    $locations = [];
    while ($row = mysqli_fetch_assoc($locationResult)) {
        $locations[] = [
            'code' => $row['locationcode'],
            'name' => $row['locationcode'] // You might want to join with master_location table for actual names
        ];
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($countStmt);
    mysqli_stmt_close($locationStmt);

    echo json_encode([
        'success' => true,
        'assets' => $assets,
        'locations' => $locations,
        'totalAcquisitionCost' => $totalAcquisitionCost,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'total' => (int)$totalRecords,
            'pages' => ceil($totalRecords / $limit)
        ]
    ]);

} catch (Exception $e) {
    error_log("Error in get_fixed_asset_acquisition.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error loading fixed asset acquisition data'
    ]);
}
?>
