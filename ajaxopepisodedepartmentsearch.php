<?php
session_start();
include ("db/db_connect.php");
$departmentname = trim($_REQUEST['departmentname']);
$lct = $_REQUEST['lct'];
$stringbuild1 = "";
$username = $_SESSION["username"];
$docno = $_SESSION['docno'];

$query11 = "select auto_number,department from master_department where  department like '$departmentname%' and  recordstatus = ''  order by auto_number ASC";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res11 = mysqli_fetch_array($exec11))
{
$res11departmentanum = $res11['auto_number'];
$res11department = $res11["department"];


	if ($stringbuild1 == '')
	{
		$stringbuild1 = $res11department.'#'.$res11departmentanum.'';
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.$res11department.'#'.$res11departmentanum.'';
		
	}

}
if($stringbuild1 != '')
{
echo $stringbuild1;
}
else
{

}
?>