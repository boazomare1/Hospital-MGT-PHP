<?php
// Connect to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$database = "rfh";

$conn = mysqli_connect($servername, $username, $password, $database);
if ($conn === false) {
  die("Error: Could not connect to database.");
}

// Insert data into the database
$sql = "INSERT INTO `rfh`.`master_consultationtype` (`auto_number`, `consultationtype`, `department`, `consultationfees`, `recordstatus`, `ipaddress`, `recorddate`, `username`, `paymenttype`, `subtype`, `locationname`, `locationcode`, `condefault`, `doctorcode`, `doctorname`) VALUES (NULL, 'CARDIOLOGY - Review', '2', '3000.00', '', '127.0.0.1', '0000-00-00 00:00:00', 'admin', '3', '6', '1', 'LTC-1', 'on', '03-2000-1733', 'DR. PAKA');

";

if (mysqli_query($conn, $sql)) {
  echo "Data inserted successfully.";
} else {
  echo "Error: Could not insert data.";
}

// Close the MySQL connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
<title>Insert MySQL DB Query</title>
</head>
<body>
<form action="insert.php" method="post">
<input type="text" name="consultationtype" placeholder="Consultation Type">
<input type="submit" value="Submit">
</form>
</body>
</html>
