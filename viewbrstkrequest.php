<?php
// Replace with your database credentials
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'evofin';

// Establish a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data and group by docno
$sql = "SELECT docno, from_location, fromstore, to_location, tostore, itemcode, itemname, SUM(quantity) as quantity, MAX(updatedatetime) as updatedatetime
        FROM master_branchstockrequest
        GROUP BY docno";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "Doc No: " . $row['docno'] . ", From Location: " . $row['from_location'] . ", From Store: " . $row['fromstore'] . ", To Location: " . $row['to_location'] . ", To Store: " . $row['tostore'] . ", Item Code: " . $row['itemcode'] . ", Item Name: " . $row['itemname'] . ", Quantity: " . $row['quantity'] . ", Update Datetime: " . $row['updatedatetime'] . "<br>";
    }
} else {
    echo "No data found";
}

// Close the database connection
$conn->close();
?>
