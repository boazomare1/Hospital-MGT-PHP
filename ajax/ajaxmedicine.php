<?php
//session_start();
include ("../db/db_connect.php");

//$searchclientgroup = $_REQUEST['searchclientgroup'];

$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 
$purchasetype=$_REQUEST['purchasetype'];
$a_json = array();
$a_json_row = array();
 $querymed = "select * from master_medicine where status <> 'Deleted' and itemname like '%$term%' and type = '$purchasetype' order by itemcode";
$execmed = mysqli_query($GLOBALS["___mysqli_ston"], $querymed) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($resmed = mysqli_fetch_array($execmed))
{
	//$res1autonumber = $res1['auto_number'];
	$res1itemcode = $resmed['itemcode'];
	
	$res1itemname = $resmed['itemname'];
	$res1itemname = addslashes($res1itemname);
	/*$res1customermiddlename = addslashes($res1customermiddlename);
	$res1customerlastname = addslashes($res1customerlastname);
	$res1nationalidnumber = addslashes($res1nationalidnumber);
	$res1mobilenumber = addslashes($res1mobilenumber);
*/
	//$res1autonumber = strtoupper($res1autonumber);
	$res1itemname = strtoupper($res1itemname);
	/*$res1customermiddlename = strtoupper($res1customermiddlename);
	$res1customerlastname = strtoupper($res1customerlastname);
	$res1nationalidnumber = strtoupper($res1nationalidnumber);
	$res1mobilenumber = strtoupper($res1mobilenumber);
	*/
	//$res1autonumber = trim($res1autonumber);
	$res1itemname = trim($res1itemname);
	
	//$res1itemcode = preg_replace('/,/', ' ', $res1itemcode);
	$res1itemname = preg_replace('/,/', ' ', $res1itemname);
	
	
	//$clientname = $res2['clientname'];
	//$auto_number = $res2['auto_number'];
	//$docno = trim($res2['docno']);
	
	//$clientname = preg_replace('/,/', ' ', $clientname); // To avoid comma from passing on to ajax url.
	$a_json_row["label"] = $res1itemname;
	$a_json_row["itemcode"] = $res1itemcode;
	$a_json_row["iteamname"] = $res1itemname;
	//$a_json_row["auto_number"] = $auto_number;
	//$a_json_row["docno"] = $docno;
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);
flush();






?>