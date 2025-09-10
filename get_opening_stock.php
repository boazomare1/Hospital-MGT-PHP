<?php
session_start();
include ("db/db_connect.php");

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get opening stock entries from database
$query = "SELECT docno, storename, location, username, auto_number 
          FROM openingstock_dataentry 
          WHERE recordstatus = '' 
          ORDER BY auto_number DESC";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query);

if (!$exec) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . mysqli_error($GLOBALS["___mysqli_ston"])]);
    exit;
}

$opening_stock = [];
while ($row = mysqli_fetch_assoc($exec)) {
    // Clean and format the data
    $opening_stock[] = [
        'docno' => htmlspecialchars($row['docno']),
        'storename' => htmlspecialchars($row['storename']),
        'location' => htmlspecialchars($row['location']),
        'username' => htmlspecialchars($row['username']),
        'auto_number' => (int)$row['auto_number']
    ];
}

// Set JSON header
header('Content-Type: application/json');

// Return the data
echo json_encode($opening_stock);
?>
