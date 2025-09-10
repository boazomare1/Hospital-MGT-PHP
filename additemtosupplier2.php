<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$rateperunit = "0";
$purchaseprice = "0";
$checkboxnumber = '';
$recordupdate = date('Y-m-d H:i:s');

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	if (isset($_POST["checkboxcount"])) { $checkboxcount = $_POST["checkboxcount"]; } else { $checkboxcount = ""; }
	$suppliercode = $_REQUEST['suppliercode'];
	$locationcode = $_REQUEST['locationcode'];
	$storecode = $_REQUEST['storecode'];
	
	$query5 = "select * from master_location where locationcode = '$locationcode'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res5 = mysqli_fetch_array($exec5);
	$locationname = $res5['locationname'];
	
	for ($i=1;$i<=$checkboxcount;$i++)
	{
		//$itemcode = $_REQUEST['checkbox'.$i];
		if (isset($_POST['checkbox'.$i])) { $itemcode = $_POST['checkbox'.$i]; } else { $itemcode = ""; }
		//echo $itemcode;
		///*
		if ($itemcode != '')
		{	
			$minvalue = $_REQUEST['min'.$i];
			$maxvalue = $_REQUEST['max'.$i];
			$rolvalue = $_REQUEST['rol'.$i];
			
			$query1 = "select * from master_medicine where itemcode = '$itemcode'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$itemname = $res1['itemname'];
			
			$query2 = "select * from master_accountname where id = '$suppliercode'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$suppliername = $res2['accountname'];
			
			//$query3 = "update master_itemtosupplier set recordstatus = 'deleted' where itemcode = '$itemcode'";
			//$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$query3 = "select * from master_itemtosupplier where locationcode = '$locationcode' and itemcode = '$itemcode' and storecode = '$storecode' and recordstatus <> 'deleted'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows3 = mysqli_num_rows($exec3);
			$res3 = mysqli_fetch_array($exec3);
			$res3anum = $res3['auto_number'];
			if($res3anum == '')
			{
			$query4 = "insert into master_itemtosupplier (itemcode, itemname, suppliercode, suppliername, recordupdate, username, ipaddress, locationname, locationcode,minimum,maximum,rol,storecode) 
			values ('$itemcode', '$itemname', '$suppliercode', '$suppliername', '$recordupdate', '$username', '$ipaddress','$locationname', '$locationcode','$minvalue','$maxvalue','$rolvalue','$storecode')";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
			$query5 = "update master_itemtosupplier set suppliercode='$suppliercode', suppliername='$suppliername', recordupdate='$recordupdate', username='$username',minimum='$minvalue',
			maximum='$maxvalue',rol='$rolvalue' where itemcode='$itemcode' and locationcode='$locationcode' and storecode = '$storecode' and auto_number = '$res3anum'"; 
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		//*/
	}
}

header ("location:additemtosupplier1.php?st=success");

?>
