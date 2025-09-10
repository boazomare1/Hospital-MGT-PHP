<?php
session_start();
require_once('html2pdf/html2pdf.class.php');
include ("db/db_connect.php");

$sql = "INSERT INTO master_radiologytemplate VALUES(";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die('Bad query!'.mysqli_error($GLOBALS["___mysqli_ston"]));  

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){        
    $db_pdf = $row['templatedata']; // No stripslashes() here.
}

?>
