<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Lookup and Update</title>
</head>
<body>

<form method="post" action="">
    <label for="patientVisitCode">Enter Patient Visit Code:</label>
    <input type="text" name="patientvisitcode" id="patientVisitCode" required>
    
    <label for="newStore">Enter New Store Number:</label>
    <input type="text" name="newstore" id="newStore">
    
    <button type="submit">Submit</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a database connection established
    $servername = "127.0.0.1";
    $username = "flofrica_server";
    $password = "gyAhd9l2wX7V";
    $dbname = "flofrica_rfh_live";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize the input values to prevent SQL injection
    $patientvisitcode = mysqli_real_escape_string($conn, $_POST['patientvisitcode']);
    $newstore = mysqli_real_escape_string($conn, $_POST['newstore']);

    // Query to fetch the store number based on patientvisitcode
    $sql = "SELECT store FROM master_consultationpharm WHERE patientvisitcode = '$patientvisitcode'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $currentStore = $row["store"];
            echo "Current Store Number: " . $currentStore;
        }

        // Update the store number if a new store number is provided
        if (!empty($newstore)) {
            $updateSql = "UPDATE master_consultationpharm SET store = '$newstore' WHERE patientvisitcode = '$patientvisitcode'";
            if ($conn->query($updateSql) === TRUE) {
                echo "<br>Store Number updated successfully to: " . $newstore;
            } else {
                echo "<br>Error updating store number: " . $conn->error;
            }
        }
    } else {
        echo "No results found for the given patient visit code.";
    }

    // Close the database connection
    $conn->close();
}
?>

</body>
</html>
