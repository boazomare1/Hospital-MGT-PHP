<?php
session_start();
//echo session_id();
include ("db/db_connect.php");

$sql ="SELECT * FROM `billing_ipprivatedoctor` WHERE coa!='' and visittype='IP' group by docno";
$exec_acc = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res_acc = mysqli_fetch_array($exec_acc))
{
	$docno = $res_acc['docno'];
    $sql1 ="SELECT * FROM `billing_ipprivatedoctor` WHERE coa!='' and visittype='IP' and docno='$docno' order by auto_number";
	$exec_acc1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
	$i=0;
	$j=1;
	while ($res_acc1 = mysqli_fetch_array($exec_acc1))
	{
		$id=$res_acc1['auto_number'];
		$sql2 ="SELECT * FROM billing_ipservices WHERE billnumber='$docno' order by auto_number limit $i,$j";
	    $exec_acc2 = mysqli_query($GLOBALS["___mysqli_ston"], $sql2) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res_acc2 = mysqli_fetch_array($exec_acc2);
		$servicesitemrate=$res_acc2['servicesitemrate'];

		echo '<br>'.$update="update `billing_ipprivatedoctor` set original_amt='$servicesitemrate' where auto_number='$id'";
		mysqli_query($GLOBALS["___mysqli_ston"], $update);

		$i=$j;
		$j++;
	}
}
?>