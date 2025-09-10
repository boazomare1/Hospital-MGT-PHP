<?php
include ("db/db_connect.php");
$queryec9 = "SELECT * from billing_paylater";
$execec9 = mysqli_query($GLOBALS["___mysqli_ston"], $queryec9) or die ("Error in queryec9".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res9 = mysqli_fetch_array($execec9))
{
   echo $billno=$res9['billno'];
   $visitcode=$res9['visitcode'];
   $slade_claim_id=$res9['slade_claim_id'];
   $id=$res9['auto_number'];

    $queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where visitcode='$visitcode'");
	$execplan=mysqli_fetch_array($queryplan);
	$admitid=$execplan['admitid'];
	$visitid=$execplan['auto_number'];
	
	if($slade_claim_id!='' && $admitid!='')
		$eclaim_status=3;
	elseif($slade_claim_id!='' && $admitid=='')
		$eclaim_status=2;
	elseif($slade_claim_id=='' && $admitid!='')
		$eclaim_status=1;
	else
		$eclaim_status=0;

	echo "---".$sql="update billing_paylater set eclaim_id='$eclaim_status' where auto_number='$id'";
	mysqli_query($GLOBALS["___mysqli_ston"], $sql);

	echo "---".$sql="update master_visitentry set eclaim_id='$eclaim_status' where auto_number='$visitid'";
	mysqli_query($GLOBALS["___mysqli_ston"], $sql);
   
}

$queryec9 = "SELECT * FROM `master_visitentry` where visitcode not in (select visitcode from billing_paylater) and billtype='PAY LATER'";
$execec9 = mysqli_query($GLOBALS["___mysqli_ston"], $queryec9) or die ("Error in queryec9".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res9 = mysqli_fetch_array($execec9))
{
	$planname=$res9['planname'];
	$visitid=$res9['auto_number'];
	
    $queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select smartap from master_planname where auto_number='$planname'");
	$execplan=mysqli_fetch_array($queryplan);
	$smartap=$execplan['smartap'];

	echo "---".$sql="update master_visitentry set eclaim_id='$smartap' where auto_number='$visitid'";
	mysqli_query($GLOBALS["___mysqli_ston"], $sql);
}


?>