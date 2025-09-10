<?php
//session_start();
include ("db/db_connect.php");

$term=$_REQUEST['term'];

$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select itemcode,itemname from master_lab where status <> 'Deleted' AND itemname like '%$term%' AND rateperunit <> 0 group by itemname order by itemcode limit 200";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec1);
while ($res1 = mysqli_fetch_array($exec1))
{
	//$res1autonumber = $res1['auto_number'];
	$res1itemcode=$res1['itemcode'];
	$res1itemname = $res1['itemname'];
	/*$res1customermiddlename = $res1['customermiddlename'];
	$res1customerlastname = $res1['customerlastname'];
	$res1nationalidnumber = $res1['nationalidnumber'];
	$res1mobilenumber = $res1['mobilenumber'];
	*/
	
	//$res1autonumber = addslashes($res1autonumber);
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
	
	$a_json_row["code"] = $res1itemcode;
	$a_json_row["value"] = $res1itemname;
	$a_json_row["label"] = $res1itemname;
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);

?>