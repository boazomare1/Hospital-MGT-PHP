<?php
//session_start();
include ("db/db_connect.php");
$customercode = trim($_REQUEST['patientcode']);
 $query1 = "select subtype,planname from master_customer where customercode = '$customercode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$subtype=$res1['subtype'];
$planname=$res1['planname'];
//$query2 = "select * from master_subtype where auto_number = '$subtype' and is_savannah = '1' ";
//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$query21 = "select * from master_planname where auto_number = '$planname' and smartap > 0 ";
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
//
if(mysqli_num_rows($exec21)>0)
{
$res4 = mysqli_fetch_array($exec21);
$returnst ='true';
$onclick = '';

$onclick.= "return funfetchsavannah('".$res4['smartap']."');";
echo $returnst.'||'.$onclick.'||'.$res4['smartap'];
}
else
{
echo 'false';
}

?>