<?php
//session_start();
include ("db/db_connect.php");

$searchsuppliername1 = $_REQUEST['disease1'];
//echo $searchsuppliername1;
$stringbuild1 = "";

$query2 = "select * from master_icd where disease like '%$searchsuppliername1%' and recordstatus = '' order by auto_number LIMIT 10";// order by subtype limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2anum = $res2['auto_number'];
	$res2disease = $res2['disease'];
	$res2icdcode = $res2['icdcode'];
	$res2chapter = $res2['chapter'];
	$res2disease = addslashes($res2disease);
	$res2disease = strtoupper($res2disease);
	$res2disease = trim($res2disease);
	$res2disease = preg_replace('/,/', ' ', $res2disease); // To avoid comma from passing on to ajax url.
	$res2icdcode = addslashes($res2icdcode);
	$res2icdcode = strtoupper($res2icdcode);
	$res2icdcode = trim($res2icdcode);
	$res2icdcode = preg_replace('/,/', ' ', $res2icdcode);
	$res2chapter = addslashes($res2chapter);
	$res2chapter = strtoupper($res2chapter);
	$res2chapter = trim($res2chapter);
	$res2chapter = preg_replace('/,/', ' ', $res2chapter);
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$res2disease.'||'.$res2icdcode.'||'.$res2chapter.'';
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$res2disease.'||'.$res2icdcode.'||'.$res2chapter.'';
	}
}

echo $stringbuild1;



?>