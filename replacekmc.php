<?php
// Replace these values with your actual database credentials
$host = 'localhost';
$username = 'root'; // Assuming no password is set
$password = '';
$database = 'medbot';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to execute an update query
function executeUpdate($conn, $query)
{
    return $conn->query($query);
}

// Text to be replaced and its replacement
$oldText = "locationaname";
$newText = "Presto Hospitals";

// Get a list of all tables in the database
$tables_query = "SHOW TABLES";
$tables_result = executeUpdate($conn, $tables_query);

if ($tables_result) {
    while ($row = $tables_result->fetch_row()) {
        $table_name = $row[0];

        // Get the columns of the current table
        $columns_query = "SHOW COLUMNS FROM $table_name";
        $columns_result = executeUpdate($conn, $columns_query);

        while ($column_row = $columns_result->fetch_assoc()) {
            $column_name = $column_row['Field'];
            $column_type = $column_row['Type'];

            // Check if the column name contains "locationaname"
            if (stripos($column_name, $oldText) !== false) {
                // Update the 'locationaname' column in the table
                $update_query = "UPDATE $table_name SET $column_name = REPLACE($column_name, '$oldText', '$newText')";
                $update_result = executeUpdate($conn, $update_query);

                if ($update_result) {
                    echo "Updated table: $table_name, Column: $column_name<br>";
                } else {
                    echo "Error updating table: $table_name, Column: $column_name<br>";
                }
            }
        }
    }
} else {
    echo "No tables found in the database.<br>";
}

// Close the database connection
$conn->close();
?>
