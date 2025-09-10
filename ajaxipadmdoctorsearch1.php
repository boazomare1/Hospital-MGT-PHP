<?php
session_start();
include ("db/db_connect.php");
$logiddocno = $_SESSION["docno"];
$term = $_REQUEST['term'];
$a_json = array();
$a_json_row = array();  
$stringbuild1 = "";
$todate=date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') -7, date('Y')));
$query1 = "select  consultingdoctor as name  from master_ipvisitentry where  consultingdoctor like '%$term%'  UNION  select  doctorname as name   from ipconsultation_services where   doctorname like '%$term%'   UNION select  doctorname as name from ipprivate_doctor where   doctorname like '%$term%' order by name  limit 10";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$doctorname = $res1['name'];
	$auto_number = '';
	$a_json_row["id"] = trim($auto_number);
	$a_json_row["value"] = trim($doctorname);
	$a_json_row["label"] = trim($doctorname);
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
?>