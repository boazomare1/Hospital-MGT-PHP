<?php
include ("db/db_connect.php");

// convert code
$res = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW TABLES");
while ($row = mysqli_fetch_array($res))
{
    foreach ($row as $key => $table)
    {
        mysqli_query($GLOBALS["___mysqli_ston"], "ALTER TABLE " . $table . " ENGINE = INNODB");
        echo $key . " =&gt; " . $table . " CONVERTED<br />";
    }
}
?> 
