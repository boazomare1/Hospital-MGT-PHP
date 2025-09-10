<?php
session_start();
include 'includes/loginverify.php';
include 'db/db_connect.php';

header('Content-Type: application/json');

try {
    // Get search parameters
    $location = isset($_GET['location']) ? trim($_GET['location']) : '';
    $ward = isset($_GET['ward']) ? trim($_GET['ward']) : '';
    $searchPatient = isset($_GET['searchPatient']) ? trim($_GET['searchPatient']) : '';
    $searchPatientCode = isset($_GET['searchPatientCode']) ? trim($_GET['searchPatientCode']) : '';
    $searchVisitCode = isset($_GET['searchVisitCode']) ? trim($_GET['searchVisitCode']) : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;

    // Get employee code for the current user
    $username = $_SESSION['username'];
    $query1 = "SELECT employeecode FROM master_employee WHERE status = 'Active' AND username LIKE '%$username%'";
    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res1 = mysqli_fetch_array($exec1);
    $res1employeename = $res1["employeecode"];

    // Build WHERE clause for search
    $whereClause = "WHERE 1=1";
    $searchParams = [];
    
    if (!empty($location)) {
        $whereClause .= " AND locationcode = ?";
        $searchParams[] = $location;
    }
    
    if (!empty($ward)) {
        $whereClause .= " AND ward = ?";
        $searchParams[] = $ward;
    }
    
    if (!empty($searchPatient)) {
        $whereClause .= " AND patientname LIKE ?";
        $searchParams[] = '%' . $searchPatient . '%';
    }
    
    if (!empty($searchPatientCode)) {
        $whereClause .= " AND patientcode LIKE ?";
        $searchParams[] = '%' . $searchPatientCode . '%';
    }
    
    if (!empty($searchVisitCode)) {
        $whereClause .= " AND visitcode LIKE ?";
        $searchParams[] = '%' . $searchVisitCode . '%';
    }

    // Get total count for pagination
    $countQuery = "SELECT COUNT(DISTINCT CONCAT(ipb.ward, ipb.bed)) as total 
                   FROM ip_bedallocation ipb 
                   INNER JOIN master_ipvisitentry mip ON ipb.patientcode = mip.patientcode 
                   AND ipb.visitcode = mip.visitcode 
                   AND ipb.locationcode = mip.locationcode
                   WHERE ipb.recordstatus NOT IN ('discharged','transfered') 
                   AND mip.discharge NOT IN ('discharged','completed')";
    
    if (!empty($searchParams)) {
        $countQuery .= " AND " . substr($whereClause, 6);
    }
    
    $countStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $countQuery);
    
    if (!empty($searchParams)) {
        $types = str_repeat('s', count($searchParams));
        mysqli_stmt_bind_param($countStmt, $types, ...$searchParams);
    }
    
    mysqli_stmt_execute($countStmt);
    $countResult = mysqli_stmt_get_result($countStmt);
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];

    // Get paginated data
    $query = "SELECT DISTINCT 
                     ipb.ward,
                     ipb.bed,
                     ipb.patientname,
                     ipb.patientcode,
                     ipb.visitcode,
                     ipb.locationcode,
                     mip.consultationdate,
                     mip.accountfullname,
                     mip.subtype,
                     mip.age,
                     mip.gender,
                     mip.package,
                     mw.ward as ward_name,
                     mb.bed as bed_name,
                     mst.subtype as subtype_name
              FROM ip_bedallocation ipb 
              INNER JOIN master_ipvisitentry mip ON ipb.patientcode = mip.patientcode 
              AND ipb.visitcode = mip.visitcode 
              AND ipb.locationcode = mip.locationcode
              LEFT JOIN master_ward mw ON ipb.ward = mw.auto_number
              LEFT JOIN master_bed mb ON ipb.bed = mb.auto_number
              LEFT JOIN master_subtype mst ON mip.subtype = mst.auto_number
              WHERE ipb.recordstatus NOT IN ('discharged','transfered') 
              AND mip.discharge NOT IN ('discharged','completed')";
    
    if (!empty($searchParams)) {
        $query .= " AND " . substr($whereClause, 6);
    }
    
    $query .= " ORDER BY mw.ward, mb.bed LIMIT ? OFFSET ?";
    
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

    $inpatients = [];
    $totalPatients = 0;
    
    while ($row = mysqli_fetch_assoc($result)) {
        $totalPatients++;
        
        $inpatients[] = [
            'ward' => $row['ward'],
            'bed' => $row['bed'],
            'patientname' => $row['patientname'],
            'patientcode' => $row['patientcode'],
            'visitcode' => $row['visitcode'],
            'locationcode' => $row['locationcode'],
            'consultationdate' => $row['consultationdate'],
            'accountfullname' => $row['accountfullname'],
            'subtype' => $row['subtype'],
            'age' => $row['age'],
            'gender' => $row['gender'],
            'package' => $row['package'],
            'ward_name' => $row['ward_name'],
            'bed_name' => $row['bed_name'],
            'subtype_name' => $row['subtype_name']
        ];
    }

    // Get location options for filter
    $locationQuery = "SELECT DISTINCT locationcode, locationname FROM login_locationdetails ORDER BY locationname ASC";
    $locationStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $locationQuery);
    mysqli_stmt_execute($locationStmt);
    $locationResult = mysqli_stmt_get_result($locationStmt);
    
    $locations = [];
    while ($row = mysqli_fetch_assoc($locationResult)) {
        $locations[] = [
            'code' => $row['locationcode'],
            'name' => $row['locationname']
        ];
    }

    // Get ward options for filter
    $wardQuery = "SELECT DISTINCT B.auto_number, B.ward, A.wardcode 
                  FROM nurse_ward as A 
                  JOIN master_ward as B ON (B.auto_number=A.wardcode) 
                  WHERE B.recordstatus = '' 
                  ORDER BY A.defaultward DESC, B.ward ASC";
    $wardStmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $wardQuery);
    mysqli_stmt_execute($wardStmt);
    $wardResult = mysqli_stmt_get_result($wardStmt);
    
    $wards = [];
    while ($row = mysqli_fetch_assoc($wardResult)) {
        $wards[] = [
            'id' => $row['auto_number'],
            'name' => $row['ward']
        ];
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($countStmt);
    mysqli_stmt_close($locationStmt);
    mysqli_stmt_close($wardStmt);

    echo json_encode([
        'success' => true,
        'inpatients' => $inpatients,
        'locations' => $locations,
        'wards' => $wards,
        'totalPatients' => $totalPatients,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'total' => (int)$totalRecords,
            'pages' => ceil($totalRecords / $limit)
        ]
    ]);

} catch (Exception $e) {
    error_log("Error in get_active_inpatients.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error loading active inpatient data'
    ]);
}
?>
