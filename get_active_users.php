<?php
session_start();
include 'includes/loginverify.php';
include 'db/db_connect.php';

header('Content-Type: application/json');

try {
    // Get search parameters
    $searchUser = isset($_GET['searchUser']) ? trim($_GET['searchUser']) : '';
    $searchEmployee = isset($_GET['searchEmployee']) ? trim($_GET['searchEmployee']) : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;

    // Build WHERE clause for search
    $whereClause = "WHERE dl.logouttime = '0000-00-00 00:00:00'";
    $searchParams = [];
    
    if (!empty($searchUser)) {
        $whereClause .= " AND dl.username LIKE ?";
        $searchParams[] = '%' . $searchUser . '%';
    }
    
    if (!empty($searchEmployee)) {
        $whereClause .= " AND me.employeename LIKE ?";
        $searchParams[] = '%' . $searchEmployee . '%';
    }

    // Get total count for pagination
    $countQuery = "SELECT COUNT(*) as total 
                   FROM details_login dl 
                   LEFT JOIN master_employee me ON dl.username = me.username 
                   $whereClause";
    
    $countStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $countQuery);
    
    if (!empty($searchParams)) {
        $types = str_repeat('s', count($searchParams));
        mysqli_stmt_bind_param($countStmt, $types, ...$searchParams);
    }
    
    mysqli_stmt_execute($countStmt);
    $countResult = mysqli_stmt_get_result($countStmt);
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];

    // Get paginated data
    $query = "SELECT dl.auto_number, dl.username, dl.logintime, dl.logouttime,
                     me.employeename, me.employeecode, me.departmentname, me.job_title
              FROM details_login dl 
              LEFT JOIN master_employee me ON dl.username = me.username 
              $whereClause 
              ORDER BY dl.logintime DESC LIMIT ? OFFSET ?";
    
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

    $activeUsers = [];
    $totalActiveUsers = 0;
    
    while ($row = mysqli_fetch_assoc($result)) {
        $totalActiveUsers++;
        
        // Calculate session duration
        $loginTime = new DateTime($row['logintime']);
        $currentTime = new DateTime();
        $duration = $currentTime->diff($loginTime);
        $sessionDuration = '';
        
        if ($duration->h > 0) {
            $sessionDuration = $duration->h . 'h ' . $duration->i . 'm';
        } else {
            $sessionDuration = $duration->i . 'm';
        }
        
        $activeUsers[] = [
            'auto_number' => $row['auto_number'],
            'username' => $row['username'],
            'logintime' => $row['logintime'],
            'logouttime' => $row['logouttime'],
            'employeename' => $row['employeename'] ?: 'Unknown User',
            'employeecode' => $row['employeecode'] ?: 'N/A',
            'department' => $row['departmentname'] ?: 'N/A',
            'designation' => $row['job_title'] ?: 'N/A',
            'session_duration' => $sessionDuration,
            'status' => 'Active'
        ];
    }

    // Get summary statistics
    $totalUsersQuery = "SELECT COUNT(DISTINCT username) as total_users FROM details_login WHERE logouttime = '0000-00-00 00:00:00'";
    $totalUsersStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $totalUsersQuery);
    mysqli_stmt_execute($totalUsersStmt);
    $totalUsersResult = mysqli_stmt_get_result($totalUsersStmt);
    $totalUsers = mysqli_fetch_assoc($totalUsersResult)['total_users'];

    // Get departments summary
    $deptQuery = "SELECT me.departmentname, COUNT(*) as user_count 
                   FROM details_login dl 
                   LEFT JOIN master_employee me ON dl.username = me.username 
                   WHERE dl.logouttime = '0000-00-00 00:00:00' 
                   AND me.departmentname IS NOT NULL AND me.departmentname != ''
                   GROUP BY me.departmentname 
                   ORDER BY user_count DESC";
    $deptStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $deptQuery);
    mysqli_stmt_execute($deptStmt);
    $deptResult = mysqli_stmt_get_result($deptStmt);
    
    $departments = [];
    while ($row = mysqli_fetch_assoc($deptResult)) {
        $departments[] = [
            'name' => $row['departmentname'],
            'count' => (int)$row['user_count']
        ];
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($countStmt);
    mysqli_stmt_close($totalUsersStmt);
    mysqli_stmt_close($deptStmt);

    echo json_encode([
        'success' => true,
        'activeUsers' => $activeUsers,
        'totalActiveUsers' => $totalActiveUsers,
        'totalUsers' => $totalUsers,
        'departments' => $departments,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'total' => (int)$totalRecords,
            'pages' => ceil($totalRecords / $limit)
        ]
    ]);

} catch (Exception $e) {
    error_log("Error in get_active_users.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error loading active users data'
    ]);
}
?>
