<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["sno"])) { $sno = $_REQUEST["sno"]; } else { $sno = ""; }
if (isset($_REQUEST["earninganum"])) { $earninganum = $_REQUEST["earninganum"]; } else { $earninganum = ""; }
if (isset($_REQUEST["earningvalue"])) { $earningvalue = $_REQUEST["earningvalue"]; } else { $earningvalue = ""; }
$searchresult = "";

$query2 = "select * from master_payrollcomponent where auto_number = '$earninganum' and recordstatus <> 'deleted'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$anum = $res2['auto_number'];
	$amounttype = $res2['amounttype'];
	if($amounttype == 'Percent')
	{
		$formula = $res2['formula'];
		if($formula == '1')
		{
			$query3 = "";
		}
	}
	else
	{
		$calculatedvalue = number_format($earningvalue,2,'.','');
	}	
	
	
	if ($searchresult == '')
	{
		$searchresult = ''.$sno.'||'.$calculatedvalue.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$sno.'||'.$calculatedvalue.'';
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>