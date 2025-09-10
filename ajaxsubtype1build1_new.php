<?php
//session_start();
include ("db/db_connect.php");

$searchsuppliername1 = $_REQUEST['searchsuppliername1'];
// $searchsuppliername1 ='AON INSURANCE';

$stringbuild1 = "";
$query2 = "SELECT * from master_subtype where subtype like '%$searchsuppliername1%' ";// order by subtype limit 0, 15";
// $query2 = "select * from master_subtype where subtype like '%$searchsuppliername1%' and recordstatus <> 'Deleted'";// order by subtype limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2anum = $res2['auto_number'];
	$res2subtype = $res2['subtype'];
	
	$res2subtype = addslashes($res2subtype);

	$res2subtype = strtoupper($res2subtype);
	
	$res2subtype = trim($res2subtype);
	
	$res2subtype = preg_replace('/,/', ' ', $res2subtype); // To avoid comma from passing on to ajax url.
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		 $stringbuild1 = $res2subtype.'#'.$res2anum;
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		 $stringbuild1 = $stringbuild1.','.$res2subtype.'#'.$res2anum;
	}
}

echo $stringbuild1;



?>