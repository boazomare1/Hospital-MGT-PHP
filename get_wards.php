<?php
session_start();
include ("db/db_connect.php");

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get wards from database - show all wards including deleted ones for now
$query = "SELECT ward, locationname, deposit_amount, auto_number, recordstatus 
          FROM master_ward 
          ORDER BY auto_number DESC";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query);

if (!$exec) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . mysqli_error($GLOBALS["___mysqli_ston"])]);
    exit;
}

// Check if we got any results
if (mysqli_num_rows($exec) === 0) {
    echo json_encode(['success' => true, 'wards' => [], 'message' => 'No wards found in database']);
    exit;
}

$wards = [];
while ($row = mysqli_fetch_assoc($exec)) {
    // Clean and format the data
    $wards[] = [
        'ward' => htmlspecialchars($row['ward']),
        'locationname' => htmlspecialchars(isset($row['locationname']) ? $row['locationname'] : ''),
        'deposit_amount' => number_format((float)(isset($row['deposit_amount']) ? $row['deposit_amount'] : 0), 2),
        'auto_number' => (int)$row['auto_number'],
        'recordstatus' => isset($row['recordstatus']) ? $row['recordstatus'] : ''
    ];
}

// Set JSON header
header('Content-Type: application/json');

// Return the data
echo json_encode(['success' => true, 'wards' => $wards]);
?>
