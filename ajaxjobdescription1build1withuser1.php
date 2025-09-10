<?php
//session_start();
include ("db/db_connect.php");

$searchsuppliername1 = $_REQUEST['searchsuppliername'];

$stringbuild1 = "";
$query1 = "select * from master_employee where status <> 'deleted' and is_user = 'Yes' and (employeename like '%$searchsuppliername1%' or jobdescription like '%$searchsuppliername1%') group by jobdescription order by jobdescription limit 0,10 ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1employeecode = $res1['employeecode'];
	$res1jobdescription = $res1['jobdescription'];
	$res1employeename= $res1["employeename"];

	$res1employeecode = addslashes($res1employeecode);
	$res1jobdescription = addslashes($res1jobdescription);
	$res1employeename = addslashes($res1employeename);

	$res1employeecode = strtoupper($res1employeecode);
	$res1jobdescription = strtoupper($res1jobdescription);
	$res1employeename = strtoupper($res1employeename);
	
	$res1employeecode = trim($res1employeecode);
	$res1jobdescription = trim($res1jobdescription);
	$res1employeename = trim($res1employeename);
	
	$res1employeecode = preg_replace('/,/', ' ', $res1employeecode);
	$res1employeename = preg_replace('/,/', ' ', $res1employeename);
	$res1jobdescription = preg_replace('/,/', ' ', $res1jobdescription);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = $res1employeename.'#'.$res1jobdescription.'#'.$res1employeecode;
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.$res1employeename.'#'.$res1jobdescription.'#'.$res1employeecode.',';
	}
}
echo $stringbuild1;



?>