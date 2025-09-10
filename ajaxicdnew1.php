<?php
//session_start();
include ("db/db_connect.php");

$searchdisease1 = $_REQUEST['searchdisease1'];
//echo $searchsuppliername1;
$stringbuild1 = "";

$query2 = "select * from master_icd where (description like '%$searchdisease1%' OR icdcode like '%$searchdisease1%') and recordstatus = 'active' order by auto_number LIMIT 20";// order by subtype limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2anum = $res2['auto_number'];
	$res2disease = $res2['disease'];
	$res2icdcode = $res2['icdcode'];
	$res2chapter = $res2['chapter'];
		$res2description = $res2['description'];
	$res2disease = addslashes($res2disease);
	$res2disease = strtoupper($res2disease);
	$res2disease = trim($res2disease);
	$res2disease = preg_replace('/,/', ' ', $res2disease); // To avoid comma from passing on to ajax url.
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$res2description.'||'.$res2icdcode.'||'.$res2chapter.'';
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$res2description.'||'.$res2icdcode.'||'.$res2chapter.'';
	}
}

echo $stringbuild1;



?>