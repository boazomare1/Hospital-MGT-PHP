<?php
include ("db/db_connect.php");

// convert code
$res = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW TABLES");
while ($row = mysqli_fetch_array($res))
{
    foreach ($row as $key => $table)
    {
        mysqli_query($GLOBALS["___mysqli_ston"], "ALTER TABLE " . $table . " CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci");
        echo $key . " =&gt; " . $table . " CONVERTED<br />";
    }
}
?> 