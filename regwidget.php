<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medbot";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the count of patients from master_customer table
$sql = "SELECT COUNT(*) AS patient_count FROM master_customer";
$result = $conn->query($sql);

// Check if the query was successful
if ($result && $result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();
    $patientCount = $row["patient_count"];

    // Output the patient count
    echo "Total number of patients: " . $patientCount;
} else {
    // Handle the case when there are no patients or an error occurred
    echo "Error: Unable to fetch patient count.";
}

// Close the database connection
$conn->close();
?>
