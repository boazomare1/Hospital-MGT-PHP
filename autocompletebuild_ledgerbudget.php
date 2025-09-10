<?php
//session_start();
include ("db/db_connect.php");

if(isset($_REQUEST['group'])){ $group = $_REQUEST['group'];} else { $group = '';}
if(isset($_REQUEST['ledger'])){ $ledger = $_REQUEST['ledger'];} else { $ledger = '';}

if($group == '') { $cond = "'1','3','4'"; }
else if($group == 'Income') { $cond = "'1','3'"; }
else if($group == 'Expense') { $cond = "'4'"; }
$stringbuild1 = "";
$query1 = "select * from master_accountname where accountsmain IN ($cond) and accountname like '%$ledger%' order by accountname limit 0,10";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	//$res1suppliercode = $res1['auto_number'];
	$res1suppliername = $res1['accountname'];
	$res1id = $res1['id'];
	$res1anum = $res1['auto_number'];
	$res1suppliername = strtoupper($res1suppliername);
	$res1suppliername = trim($res1suppliername);
	$res1suppliername = preg_replace('/,/', ' ', $res1suppliername);
	if ($stringbuild1 == '')
	{
		$stringbuild1 = $res1id.'#'.$res1anum.'#'.$res1suppliername.'';
	}
	else
	{
		$stringbuild1 = $stringbuild1.'||^||'.$res1id.'#'.$res1anum.'#'.$res1suppliername.'';
	}
}

if($stringbuild1 != '')
{
echo $stringbuild1;
}

?>