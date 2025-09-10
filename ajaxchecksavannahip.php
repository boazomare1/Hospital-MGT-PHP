<?php
//session_start();
include ("db/db_connect.php");
$customercode = trim($_REQUEST['patientcode']);
 $query1 = "select subtype,planname from master_customer where customercode = '$customercode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$subtype=$res1['subtype'];
$planname=$res1['planname'];
$query2 = "select * from master_subtype where auto_number = '$subtype' and is_savannah = '1' ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($exec2)>0)
{
$returnst ='true';
$onclick = '';

$onclick.= "return funfetchsavannah('".mysqli_num_rows($exec2)."','".mysqli_num_rows($exec2)."');";
echo $returnst.'||'.$onclick;
}
else
{
echo 'false';
}

?>
