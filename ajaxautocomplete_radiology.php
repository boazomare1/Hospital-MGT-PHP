<?php
//session_start();
include ("db/db_connect.php");
$res111subtype=trim($_REQUEST['subtype']);
$query13r = "select radtemplate from master_subtype where auto_number = '$res111subtype' order by subtype";
$exec13r = mysqli_query($GLOBALS["___mysqli_ston"], $query13r) or die ("Error in Query13r".mysqli_error($GLOBALS["___mysqli_ston"]));
$res13r = mysqli_fetch_array($exec13r);
$tablenamer = $res13r['radtemplate'];
if($tablenamer == '')
{
  $tablenamer = 'master_radiology';
}
$locationcode=trim($_REQUEST['loc']);
$term = $_REQUEST['term'];

$query1 = "select * from $tablenamer where itemname like'%".$term."%' and status != 'deleted'  AND rateperunit <> 0 order by itemname limit 10";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	//$res1autonumber = $res1['auto_number'];
	$res1itemcode=$res1['itemcode'];
	$res1itemname= $res1['itemname'];
	
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
	$res1itemname= strtoupper($res1itemname);
	/*$res1customermiddlename = strtoupper($res1customermiddlename);
	$res1customerlastname = strtoupper($res1customerlastname);
	$res1nationalidnumber = strtoupper($res1nationalidnumber);
	$res1mobilenumber = strtoupper($res1mobilenumber);
	*/
	//$res1autonumber = trim($res1autonumber);
	$res1itemname = trim($res1itemname);
	
	//$res1itemcode = preg_replace('/,/', ' ', $res1itemcode);
	//$res1itemname = preg_replace('/,/', ' ', $res1itemname);
	$stringbuild100[]= ''.$res1itemcode.'||'.$res1itemname.'';
	
}
echo json_encode($stringbuild100);

?>