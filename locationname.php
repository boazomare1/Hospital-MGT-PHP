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

// Function to execute a SELECT query and return the result set
function executeSelectQuery($conn, $query)
{
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        return $result;
    }
    return false;
}

// Function to get the columns of a table
function getColumns($conn, $table)
{
    $columns_query = "SHOW COLUMNS FROM $table";
    $columns_result = executeSelectQuery($conn, $columns_query);

    $columns = [];
    while ($row = $columns_result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    return $columns;
}

// Text to be searched (case-insensitive)
$searchText = "kerugoya";

// Get a list of all tables in the database
$tables_query = "SHOW TABLES";
$tables_result = executeSelectQuery($conn, $tables_query);

if ($tables_result) {
    echo "<h1>Tables and Columns with the text '$searchText' in the database '$database'</h1>";
    echo "<ul>";

    while ($row = $tables_result->fetch_row()) {
        $table_name = $row[0];

        // Get the columns of the current table
        $columns = getColumns($conn, $table_name);

        // Build a search query for each column
        $search_queries = [];
        foreach ($columns as $column) {
            $search_queries[] = "SELECT '$column' as column_name FROM $table_name WHERE $column LIKE '%$searchText%'";
        }
        $full_search_query = implode(" UNION ", $search_queries);

        // Perform the search
        $search_result = executeSelectQuery($conn, $full_search_query);

        if ($search_result) {
            while ($search_row = $search_result->fetch_assoc()) {
                $column_name = $search_row['column_name'];
                echo "<li>Table: $table_name, Column: $column_name</li>";
            }
        }
    }

    echo "</ul>";
} else {
    echo "<p>No tables found in the database.</p>";
}

// Close the database connection
$conn->close();
?>
