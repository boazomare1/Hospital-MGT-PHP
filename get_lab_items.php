<?php
session_start();
include ("db/db_connect.php");

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get lab items from database
$query = "SELECT itemcode, itemname, categoryname, itemname_abbreviation as unit, purchaseprice as price, 
          CASE WHEN status = '' OR status IS NULL THEN 'active' ELSE 'inactive' END as status, 
          auto_number 
          FROM master_lab 
          WHERE status <> 'deleted' 
          ORDER BY auto_number DESC";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query);

if (!$exec) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . mysqli_error($GLOBALS["___mysqli_ston"])]);
    exit;
}

$lab_items = [];
while ($row = mysqli_fetch_assoc($exec)) {
    // Clean and format the data
    $lab_items[] = [
        'itemcode' => htmlspecialchars($row['itemcode']),
        'itemname' => htmlspecialchars($row['itemname']),
        'categoryname' => htmlspecialchars($row['categoryname']),
        'unit' => htmlspecialchars($row['unit'] ?: ''),
        'price' => number_format((float)$row['price'], 2),
        'status' => $row['status'],
        'auto_number' => (int)$row['auto_number']
    ];
}

// Set JSON header
header('Content-Type: application/json');

// Return the data
echo json_encode($lab_items);
?>
