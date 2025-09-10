
<?php
include ("db/db_connect.php");

$data1=$_REQUEST['store'];
$store=json_decode($data1);

$data2=$_REQUEST['username'];

$updatedatetime = date('Y-m-d H:i:s');

$locationcode=$_REQUEST['locationcode'];

$sql=' UPDATE master_employeelocation SET defaultstore="" WHERE username="'.$data2.'" and locationcode="'.$locationcode.'"';
$exec3= mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="UPDATE master_employeelocation SET defaultstore='default',lastupdate='$updatedatetime' WHERE username='$data2' and storecode='$data1'  and locationcode='$locationcode'";
$exec3= mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));

//$sql="UPDATE master_employeelocation SET lastupdate='$updatedatetime' WHERE username='$data2' and storecode='$data1'  and locationcode='$locationcode'";
//$exec3= mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in sql".mysqli_error($GLOBALS["___mysqli_ston"]));


?>