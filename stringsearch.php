<?php
$search="KERUGOYA MEDICAL CENTRE(TOWN CLINIC)";
$conn = mysqli_connect("localhost", "root", "", "kerugoya");
$tables = mysqli_query($conn, "SHOW TABLES");
while ($table = mysqli_fetch_object($tables))
{
    $table_name = $table->{"Tables_in_kerugoya"};

   $sql = "SELECT * FROM " . $table_name . " WHERE ";
 
// An array to store all columns LIKE clause
$fields = array();
 
// Query to get all columns from table
$columns = mysqli_query($conn, "SHOW COLUMNS FROM " . $table_name);
 


?>
<table border="1">
 
    <!-- Display table name as caption -->
    <caption>
        <?php echo $table_name; ?>
    </caption>
 
    <!-- Display all columns in table header -->
    <tr>
         
        <?php
            // Loop through all columns
            while ($col = mysqli_fetch_object($columns)):
 
                // Use LIKE clause to search input in each column
                array_push($fields, $col->Field . " LIKE '%" . $search . "%'");
 
        ?>
 
            <!-- Display column in TH tag -->
            <th><?php echo $col->Field; ?></th>
 
        <?php
            endwhile;
 
            // Move cursor of $columns to 0 so it can be used again
            mysqli_data_seek($columns, 0);
        ?>
         
    </tr>
 
    <?php
        // Combine $fields array by OR clause into one string
        $sql .= implode(" OR ", $fields);
        $result = mysqli_query($conn, $sql);
 
        // Loop through all rows returned from above query
        while ($row = mysqli_fetch_object($result)):
            ?>
 
            <tr>
 
                <?php
                    // Loop through all columns of this table
                    while ($col = mysqli_fetch_object($columns)):
                ?>
 
                    <td>
 
                        <?php
                            // Display row value from column field
                            echo $row->{$col->Field};
                        ?>
 
                    </td>
 
                <?php endwhile; mysqli_data_seek($columns, 0); /* end of column while loop */ ?>
 
            </tr>
 
        <?php endwhile; /* end of row while loop */ ?>
 
</table>
<?php } ?>