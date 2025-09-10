<?php

// Include the necessary libraries
require_once "Graph.php";

?>


<?php

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "medbot");

// Check if the connection was successful
if ($conn === false) {
  die("Error connecting to database: " . mysqli_connect_error());
}

// Select the data from the master_triage table
$sql = "SELECT pulse, bpsystolic, bpdiastolic FROM master_triage";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result === false) {
  die("Error querying database: " . mysqli_error($conn));
}

// Create a new graph
$graph = new Graph();

// Add the data to the graph
$graph->addData($result);

// Set the title of the graph
$graph->setTitle("Triage Data");

// Set the x-axis label
$graph->setXAxisLabel("Time");

// Set the y-axis label
$graph->setYAxisLabel("Pulse, BP Systolic, BP Diastolic");

// Render the graph
$graph->render();

// Close the connection to the database
mysqli_close($conn);

?>
