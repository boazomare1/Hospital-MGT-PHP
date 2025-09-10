<?php
//session_start();
include ("db/db_connect.php");

$searchsuppliername = $_REQUEST['searchsuppliername'];
$searchsubtypeanum1 = $_REQUEST['searchsubtypeanum1'];

$stringbuild1 = "";
$query2 = "select auto_number, scheme_name, scheme_id,scheme_expiry from master_planname where scheme_active_status ='ACTIVE' and scheme_name like '%$searchsuppliername%' and subtype = '".$searchsubtypeanum1."' and  scheme_expiry > now() group by scheme_id";// order by accountname limit 0, 15";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$res2anum = $res2['scheme_id'];
	$res2accountname = $res2['scheme_name'];	$scheme_id = $res2['scheme_id'];
	$res2expirydate = $res2['scheme_expiry'];
	$res2id ='';
	
	$res2accountname = addslashes($res2accountname);

	$res2accountname = strtoupper($res2accountname);
	
	$res2accountname = trim($res2accountname);
	
	$res2accountname = preg_replace('/,/', ' ', $res2accountname); // To avoid comma from passing on to ajax url.
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$res2accountname.'#'.$res2anum.'#'.$res2expirydate.'#'.$res2id;
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$res2accountname.'#'.$res2anum.'#'.$res2expirydate.'#'.$res2id;
	}
}

echo $stringbuild1;



?>