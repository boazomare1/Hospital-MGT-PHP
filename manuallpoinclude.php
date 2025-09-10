<?php
$lastupdate = date('Y-m-d H:i:s');
$billtime = date("H:i:s");
$financialyear = $_SESSION["financialyear"];
$username = $_SESSION['username'];
$balanceamount = '';
$ipaddress = $_SERVER['REMOTE_ADDR'];

//echo $companyanum;
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
$billnumber = $_REQUEST['billnumber'];
//$store = $_REQUEST['store1'];
$billdate = $_REQUEST['ADate'];
$suppliername = $_REQUEST['supplier'];
$suppliercode = $_REQUEST['suppliercode'];
//$ponumber = $_REQUEST['pono'];
//$accountssubid = $_REQUEST['accountssubid'];
$supplierbillno = $_REQUEST['supplierbillnumber'];
$amount = $_REQUEST['totalamount'];
$locationcode = $_REQUEST['location'];
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];
$subtotal = $_REQUEST['subtotal'];
$subtotalaftercombinediscount = $_REQUEST['subtotalaftercombinediscount'];
$totalaftertax = $_REQUEST['totalaftertax'];
$packaging = $_REQUEST['packaging'];
$delivery = $_REQUEST['delivery'];
$roundoff = $_REQUEST['roundoff'];
$billtype = $_REQUEST['billtype'];
$creditamount = $_REQUEST['creditamount'];
$subtotaldiscountpercentapply1 = $_REQUEST['subtotaldiscountpercentapply1'];
$subtotaldiscountamountapply1 = $_REQUEST['subtotaldiscountamountapply1'];
$subtotaldiscountamountonlyapply1 = $_REQUEST['subtotaldiscountamountonlyapply1'];
$subtotaldiscountamountonlyapply2 = $_REQUEST['subtotaldiscountamountonlyapply2'];
$cashamount = $_REQUEST['cashamount'];
$currency1 = explode(',',$_REQUEST['currency']);
$currency=$currency1[1];
$fxrate = $_REQUEST['fxrate'];
$query55 = "select * from master_location where locationcode='$locationcode'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$locationname = $res55['locationname'];



$coa = $_REQUEST['accountcode'];

	$query1 = "select * from master_accountname where id='$suppliercode'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_num_rows());
	$res1 = mysqli_fetch_array($exec1);
	$accountssubanum = $res1['accountssub'];

	$query11 = "select * from master_accountssub where auto_number='$accountssubanum'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res11 = mysqli_fetch_array($exec11);
	$accountssubid = $res11['id'];
	$totalquantity = '0';
$billautonumber=0;
for ($i=1;$i<=1000;$i++)
{
//$itemname = $_POST['itemname1'][$key];
if(isset($_REQUEST['itemname'.$i]))
{
$itemname = $_REQUEST['itemname'.$i]?$_REQUEST['itemname'.$i]:'';
$rate = $_REQUEST['rateperunit'.$i]?$_REQUEST['rateperunit'.$i]:'';
$quantity = $_REQUEST['quantity'.$i]?$_REQUEST['quantity'.$i]:'';
$free = $_REQUEST['freequantity'.$i]?$_REQUEST['freequantity'.$i]:'';
$itemtaxpercent = $_REQUEST['itemtaxpercent'.$i]?$_REQUEST['itemtaxpercent'.$i]:'';
$itemtaxamount = $_REQUEST['itemtaxamount'.$i]?$_REQUEST['itemtaxamount'.$i]:'';
$itemdiscountpercent = $_REQUEST['itemdiscountpercent'.$i]?$_REQUEST['itemdiscountpercent'.$i]:'';
$discountamount = $_REQUEST['discountamount'.$i]?$_REQUEST['discountamount'.$i]:'';
$totalamount = $_REQUEST['totalamount'.$i];
$totalquantity = $totalquantity + $quantity;
$fxpkrate = $rate/$fxrate;
$fxtotamount = $totalamount/$fxrate;
	$remarks=isset($_REQUEST['remarks'])?$_REQUEST['remarks']:'';
			
	if($itemname !='')
	{


			$query4 = "insert into manual_lpo (companyanum, billnumber, itemname, rate, quantity, subtotal, free, discountpercentage, totalamount, 
			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, itemfreequantity, itemtotalquantity,suppliername,suppliercode, locationcode, locationname,remarks,currency,fxrate,fxamount,fxpkrate,fxtotamount) 
			values ('$companyanum', '$billnumber', '$itemname', '$rate', '$quantity', '$totalamount', '$free', '$itemdiscountpercent', '$totalamount', '$discountamount', '$username', '$ipaddress', '$billdate', 
			'$itemtaxpercent', '$itemtaxamount', '$free', '$quantity', '$suppliername','$suppliercode',  '$locationcode', '$locationname','$remarks','$currency','$fxrate','$fxrate','$fxpkrate','$fxtotamount')";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
			
}
}
		

header("location:manuallpo.php?otcbillnumber=$billnumber");
}
$query2 = "select * from settings_purchase where companyanum = '$companyanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$f18=$res2['f18'];
	$f19=$res2['f19'];
	$f21=$res2['f21'];
	$f22=$res2['f22'];
	
	$billnumberprefix = $res2['billnumberprefix'];
	$billnumberprefix = strtoupper($billnumberprefix);
	$billnumberprefix = trim($billnumberprefix);

	$billnumberpostfix = $res2['billnumberpostfix'];
	$billnumberpostfix = strtoupper($billnumberpostfix);
	$billnumberpostfix = trim($billnumberpostfix);
	
	//$reftext = $res2["reftext"];
	//$billstarttext  = $res2["billstarttext"];
	//$billendtext = $res2["billendtext"];
	$f29 = $res2['f29'];
	$f30 = $res2['f30'];
	$footerline1 = $res2['f18'];
	$footerline2 = $res2['f19'];
	$footerline3 = $res2['f21'];
	$footerline4 = $res2['22'];
	$footerline5 = $res2['f25'];
	$footerline6 = $res2['f26'];
?>