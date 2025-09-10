<?php

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "evofin");

// Select the data from the master_menusub table where mainmenuid IDs are MM006,MM010,MM002,MM030 and status is not equal to deleted
$query = "SELECT * FROM master_menusub WHERE mainmenuid IN ('MM006', 'MM010', 'MM002', 'MM030') AND status != 'deleted'";
$result = mysqli_query($conn, $query);

// Create a table to display the data
echo "<table border='1'>";
echo "<tr>";
echo "<th>Main Menu ID</th>";
echo "<th>Main Menu Text</th>";
echo "<th>Sub Menu Text</th>";
echo "</tr>";

// Loop through the results and add each row to the table
while ($row = mysqli_fetch_assoc($result)) {
	$menu_id=$row['mainmenuid'];
$query881 = "select * from master_menumain where mainmenuid='$menu_id'";

$exec881 = mysqli_query($conn, $query881);

$res881 = mysqli_fetch_assoc($exec881);

$menumain_name = $res881['mainmenutext'];	
  echo "<tr>";
  echo "<td>{$row['mainmenuid']}</td>";
  echo "<td>$menumain_name </td>";
  echo "<td>{$row['submenutext']}</td>";
  echo "</tr>";
}

echo "</table>";

// Close the database connection
mysqli_close($conn);

?>
