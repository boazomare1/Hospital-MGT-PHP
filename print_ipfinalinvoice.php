<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

ob_start();

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbers = ""; }

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["patientcode"];
	$patientname = $_REQUEST["patientname"];
	
	$accountname= $_REQUEST['accountname'];
	$subtype = $_REQUEST['subtype'];
	$paymenttype = $_REQUEST['paymenttype'];
	$totalamount=$_REQUEST['netpayable'];
	if($accountname == 'CASH')
	{
	$cash = $_REQUEST['cash'];
	if($cash == '')
	{
	$cash = 0;
	}
	$cheque = $_REQUEST['cheque'];
	if($cheque == '')
	{
	$cheque = 0;
	}
	$chequenumber = $_REQUEST['chequenumber1'];
	if($chequenumber == '')
	{
	$chequenumber = 0;
	}
	$online = $_REQUEST['online'];
	if($online == '')
	{
	$online = 0;
	}
	$onlinenumber = $_REQUEST['onlinenumber1'];
	if($onlinenumber == '')
	{
	$onlinenumber = 0;
	}
	$creditcard = $_REQUEST['creditcard'];
	if($creditcard == '')
	{
	$creditcard = 0;
	}
	$creditcardnumber = $_REQUEST['creditcardnumber1'];
	if($creditcardnumber == '')
	{
	$creditcardnumber = 0;
	}
	$mpesa = $_REQUEST['mpesa'];
	if($mpesa == '')
	{
	$mpesa = 0;
	}
	$mpesanumber = $_REQUEST['mpesanumber1'];
	if($mpesanumber == '')
	{
	$mpesanumber = 0;
	}
	}
	else
	{
	$cash = 0;
	$cheque = 0;
	$chequenumber = 0;
	$online = 0;
	$onlinenumber = 0;
	$creditcard = 0;
	$creditcardnumber = 0;
	$mpesa = 0;
	$mpesanumber = 0;

	}
	
	$paylaterbillprefix = 'IPF-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ip order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$billno= $billnumbercode;
if(isset($_POST['description']))
{
foreach($_POST['description'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptionname=$_POST['description'][$key];
		$descriptionrate=$_POST['descriptionrate'][$key];
		$descriptionamount=$_POST['descriptionamount'][$key];
		$descriptionquantity=$_POST['descriptionquantity'][$key];
		$descriptiondocno=$_POST['descriptiondocno'][$key];
		
		
		if($descriptionname!="")
		{
		$query71 = "insert into billing_ipbedcharges(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username)values('$descriptionname','$descriptionrate','$descriptionquantity','$descriptionamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username')";
		$exec71=mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		}
		if(isset($_POST['descriptioncharge']))
		{
		foreach($_POST['descriptioncharge'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptioncharge=$_POST['descriptioncharge'][$key];
		$descriptionchargerate=$_POST['descriptionchargerate'][$key];
		$descriptionchargeamount=$_POST['descriptionchargeamount'][$key];
		$descriptionchargequantity=$_POST['descriptionchargequantity'][$key];
		$descriptionchargedocno=$_POST['descriptionchargedocno'][$key];
		$descriptionchargeward=$_POST['descriptionchargeward'][$key];
		$descriptionchargebed=$_POST['descriptionchargebed'][$key];
		
		if($descriptioncharge!="")
		{
		$query71 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username)values('$descriptioncharge','$descriptionrate','$descriptionquantity','$descriptionamount','$descriptionchargeward','$descriptionchargebed','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username')";
		$exec71=mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		}
		if(isset($_POST['descriptioncharge1']))
		{
			foreach($_POST['descriptioncharge1'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptioncharge1=$_POST['descriptioncharge1'][$key];
		$descriptionchargerate1=$_POST['descriptionchargerate1'][$key];
		$descriptionchargeamount1=$_POST['descriptionchargeamount1'][$key];
		$descriptionchargequantity1=$_POST['descriptionchargequantity1'][$key];
		$descriptionchargedocno1=$_POST['descriptionchargedocno1'][$key];
		$descriptionchargeward1=$_POST['descriptionchargeward1'][$key];
		$descriptionchargebed1=$_POST['descriptionchargebed1'][$key];
		
		if($descriptioncharge1!="")
		{
		$query711 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username)values('$descriptioncharge1','$descriptionrate1','$descriptionquantity1','$descriptionamount1','$descriptionchargeward1','$descriptionchargebed1','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username')";
		$exec711=mysqli_query($GLOBALS["___mysqli_ston"], $query711) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		}
		
		if(isset($_POST['descriptioncharge12']))
		{
			foreach($_POST['descriptioncharge12'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptioncharge12=$_POST['descriptioncharge12'][$key];
		$descriptionchargerate12=$_POST['descriptionchargerate12'][$key];
		$descriptionchargeamount12=$_POST['descriptionchargeamount12'][$key];
		$descriptionchargequantity12=$_POST['descriptionchargequantity12'][$key];
		$descriptionchargedocno12=$_POST['descriptionchargedocno12'][$key];
		$descriptionchargeward12=$_POST['descriptionchargeward12'][$key];
		$descriptionchargebed12=$_POST['descriptionchargebed12'][$key];
		
		if($descriptioncharge12!="")
		{
		$query712 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username)values('$descriptioncharge12','$descriptionrate12','$descriptionquantity12','$descriptionamount12','$descriptionchargeward12','$descriptionchargebed12','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username')";
		$exec712=mysqli_query($GLOBALS["___mysqli_ston"], $query712) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		}
		if(isset($_POST['medicinename']))
		{
	foreach($_POST['medicinename'] as $key=>$value)
		{	
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_POST['medicinename'][$key];
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$rate=$res77['rateperunit'];
			$quantity = $_POST['quantity'][$key];
				$amount = $_POST['amount'][$key];
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		        //echo '<br>'. 
		        $query2 = "insert into billing_ippharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,medicinecode,billnumber) 
				values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$currentdate','$ipaddress','$accountname','$medicinecode','$billno')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
							
			}
		
		}
		}
		if(isset($_POST['lab']))
		{
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname'");
		$execlab=mysqli_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		
		if($labname!="")
		{
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_iplab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,billnumber)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$currentdate','$billno')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		}
		if(isset($_POST['radiology']))
		{
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		
		$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$pairvar'");
		$execradiology=mysqli_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		
		
		if($pairvar!="")
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,billnumber)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$currentdate','$billno')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		if(isset($_POST['services']))
		{
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$servicesname'");
		$execservice=mysqli_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		
		if($servicesname!="")
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ipservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$currentdate','$billno')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into billing_ip(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype)values('$billno','$patientname','$patientcode','$visitcode','$totalamount','$currentdate','$accountname','$subtype')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$query43="insert into master_transactionip(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$totalamount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber')";
	    $exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("error in query43".mysqli_error($GLOBALS["___mysqli_ston"]));	
		
		$query431="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$totalamount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber')";
	    $exec431=mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die("error in query431".mysqli_error($GLOBALS["___mysqli_ston"]));		  
			  
		
		$query64 = "update ip_bedallocation set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query691 = "update master_ipvisitentry set paymentstatus='completed',finalbillno='$billno' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec691 = mysqli_query($GLOBALS["___mysqli_ston"], $query691) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query6412 = "update ip_discharge set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec6412 = mysqli_query($GLOBALS["___mysqli_ston"], $query6412) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
		
		header("location:ipbilling.php");


}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}


?>

<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where locationcode='$locationcode' and customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];

$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where locationcode='$locationcode' and auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where locationcode='$locationcode' and auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];

$query32 = "select * from ip_discharge where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num32 = mysqli_num_rows($exec32);

?>
<?php
$query3 = "select * from master_company where locationcode='$locationcode' and companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paylaterbillprefix = 'IPF-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ip where locationcode='$locationcode' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>

<?php
function roundTo($number, $to){ 
    return round($number/$to, 0)* $to; 
} 

?>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #000000; 
}

.bodytexthead {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3b3b3c; 
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
</style>
<table width="748" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">&nbsp;</td>
    <td  align="left" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td width="439" align="left">
	<?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="50" />
			<?php
			}
			
			$query11 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11companyname = $res11['companyname'];
			$res11address11 = $res11['address1'];
			$res11area = $res11['area'];
			$res11city = $res11['city'];
			$res11state = $res11['state'];
			$res11country = $res11['country'];
			$res11pincode = $res11['pincode'];
			$emailid1 = $res11["emailid1"];
			$res11phonenumber11 = $res11['phonenumber1'];
			?>    </td>
	<td width="309"  align="left" class="bodytext32">
	<?php
	echo '<strong class="bodytext33">'.$res11companyname.'</strong>';
	//echo '<br>'.$res11address11.' '.$res11area.' '.$res11city.' '.$res11pincode;
	echo '<br><strong class="bodytext34">PHONE : '.$res11phonenumber11.'</strong>';
	echo '<br><strong class="bodytext35">E-Mail : '.$emailid1.'</strong>';
	?>	</td>
 </tr>
 <tr>
  <td colspan="2">
    <table width="747" border="0" cellspacing="0" cellpadding="2">
        <?php
            
		$query1 = "select * from master_ipvisitentry where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		$res1 = mysqli_fetch_array($exec1);

		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$billtype = $res1['billtype'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		$subtypeanum = $res1['subtype'];
		
		$query813 = "select * from ip_discharge where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		}
			
		
		$query67 = "select * from master_accountname where locationcode='$locationcode' and auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		$query671 = "select * from master_subtype where locationcode='$locationcode' and auto_number='$subtypeanum'";
		$exec671 = mysqli_query($GLOBALS["___mysqli_ston"], $query671); 
		$res671 = mysqli_fetch_array($exec671);
		$subtypename = $res671['subtype'];
		
		$query2 = "select * from ip_bedallocation where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$admissiondate = $res2['recorddate'];
			?>
		<tr>
		  <td  align="left" valign="center" 
			bgcolor="#ffffff">&nbsp;</td>
		  <td align="left" valign="center" class="bodytext31">&nbsp;</td>
		  <td align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
		  <td  align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
	    </tr>

		<tr>
		 <td width="93"  align="left" valign="center" 
			bgcolor="#ffffff"><strong>Patient Name</strong></td>
			<td width="296" align="left" valign="center"><strong><?php echo $patientname; ?></strong></td>
		  <td width="109" align="left" valign="center" 
			bgcolor="#ffffff"><strong>Bill Date </strong></td>
		  <td width="233"  align="left" valign="center" 
			bgcolor="#ffffff"><strong><?php echo  date("d/m/Y", strtotime($updatedate)); ?></strong></td>
		</tr>
		
		<tr>
			<td align="left" valign="center"><strong>Reg. No. </strong></td>
			<td  align="left" valign="center"><strong><?php echo $patientcode; ?></strong></td>
			<td  align="left" valign="center"><strong>Admission Date</strong></td>
			<td  align="left" valign="center"><strong><?php echo  date("d/m/y", strtotime($admissiondate)); ?></strong></td>
		</tr>
		<tr>
			<td align="left" valign="center"><strong>IP Visit No. </strong></td>
			<td  align="left" valign="center"><strong><?php echo $visitcode; ?></strong></td>
			<td  align="left" valign="center"><strong>Subtype</strong></td>
			<td  align="left" valign="center" width="200"><strong><?php echo $subtypename; ?></strong></td>
			<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
			
			<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
			<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
			<input type="hidden" name="accountname" id="accountname" value="<?php echo $accname; ?>">
			<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
			<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>">	
			<input type="hidden" name="discharge" id="discharge" value="<?php echo $num32; ?>">		
		</tr>
		<tr>
		  <td align="left" valign="center"><strong>Bill Number</strong> </td>
		  <td align="left" valign="center"><strong><?php echo $billnumbers; ?></strong></td>
		  <td ><strong>Account</strong></td>
		  <td><strong><?php echo $accname; ?></strong></td>
  </tr>
		<tr>
		  <td align="left" valign="center">&nbsp;</td>
		  <td align="left" valign="center">&nbsp;</td>
		  <td >&nbsp;</td>
		  <td>&nbsp;</td>
	    </tr>
</table>  </td>
 </tr>
</table>
		
<table width="741" align="left" border="0" cellspacing="4" cellpadding="2">
  <tr>
    <td width="30"  align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
    <td width="46" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
    <td width="46" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Ref.No</strong></td>
    <td width="300" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
    <td width="45" align="right" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Qty</strong></td>
    <td width="93" align="right" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Rate</strong></td>
    <td width="100" align="right" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>
  </tr>
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Admission</strong></td>
  </tr>
  <?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$query17 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			$packageanum1 = $res17['package'];
			
			
			$query53 = "select * from ip_bedallocation where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$refno = $res53['docno'];
			
			if($packageanum1 != 0)
			{
			if($packchargeapply == 1)
		{
			
			$totalop=$consultationfee;
			?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($consultationdate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo 'Admission Charge'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $consultationfee; ?></td>
  </tr>
  <?php
			}
			}
			else
			{
		
			$totalop=$consultationfee;
			?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($consultationdate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo 'Admission Charge'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $consultationfee; ?></td>
  </tr>
  <?php
			}
			
			?>
  <?php
					  $packageamount = 0;
			 $query731 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$packageanum1 = $res731['package'];
			$packagedate1 = $res731['consultationdate'];
			$packageamount = $res731['packagecharge'];
			
			$query741 = "select * from master_ippackage where locationcode='$locationcode' and auto_number='$packageanum1'";
			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res741 = mysqli_fetch_array($exec741);
			$packdays1 = $res741['days'];
			$packagename = $res741['packagename'];
			
			
			if($packageanum1 != 0)
	{
	
	 $reqquantity = $packdays1;
	 
	 $reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
	 
			  ?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($packagedate1)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $visitcode; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $packagename; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
    <input type="hidden" name="description[]" id="description" value="<?php echo $packagename; ?>" />
    <input type="hidden" name="descriptionrate[]" id="descriptionrate" value="<?php echo $packageamount; ?>" />
    <input type="hidden" name="descriptionamount[]" id="descriptionamount" value="<?php echo $packageamount; ?>" />
    <input type="hidden" name="descriptionquantity[]" id="descriptionquantity" value="<?php echo '1'; ?>" />
    <input type="hidden" name="descriptiondocno[]" id="descriptiondocno" value="<?php echo $visitcode; ?>" />
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
  </tr>
  <?php
			  }
			  ?>
  <?php 
			$totalbedallocationamount = 0;
			
			
			 $requireddate = '';
			 $quantity = '';
			 $allocatenewquantity = '';
			$query18 = "select * from ip_bedallocation where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18 = mysqli_fetch_array($exec18);
			$ward = $res18['ward'];
			$allocateward = $res18['ward'];
			
			$bed = $res18['bed'];
			$refno = $res18['docno'];
			$date = $res18['recorddate'];
			$bedallocateddate = $res18['recorddate'];
			$packagedate = $res18['recorddate'];
			$newdate = $res18['recorddate'];
			
			
			$query73 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res73 = mysqli_fetch_array($exec73);
			$packageanum = $res73['package'];
			
			
			$query74 = "select * from master_ippackage where locationcode='$locationcode' and auto_number='$packageanum'";
			$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res74 = mysqli_fetch_array($exec74);
			$packdays = $res74['days'];
			
		   $query51 = "select * from master_bed where locationcode='$locationcode' and auto_number='$bed'";
		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51 = mysqli_fetch_array($exec51);
		   $bedname = $res51['bed'];
		   $threshold = $res51['threshold'];
		   $thresholdvalue = $threshold/100;
		   $k = 0;
		   $billinganum = 0;
		   
			$query91 = "select * from master_bedcharge where locationcode='$locationcode' and bedanum='$bed' and recordstatus =''";
			$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num91 = mysqli_num_rows($exec91);
			while($res91 = mysqli_fetch_array($exec91))
		   {
		  
		   $charge = $res91['charge'];
		   
		  
		   
		  
		    $query181 = "select * from ip_bedtransfer where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' order by auto_number asc limit 0,1";
			$exec181 = mysqli_query($GLOBALS["___mysqli_ston"], $query181) or die ("Error in Query181".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num181 = mysqli_num_rows($exec181);
			if($num181 > 0)
			{
			$query79 = "select * from ip_bedtransfer where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' order by auto_number asc limit 0,1";
			$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res79 = mysqli_fetch_array($exec79);
			$date1 = $res79['recorddate'];
			$diff = abs(strtotime($date1) - strtotime($date));
			}
			else
			{		
		    $diff = abs(strtotime($date) - strtotime($updatedate));
			}
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			$allocatedate = $date;
			$allocate1date = $date;
			
			
		
			if($days < $packdays)
			{
			
			$quantity = $days + 1;
			 
			}
			
					if($days > $packdays)
			{
			
			 $k = $k+1;
		   $billinganum = $billinganum+1;
			 if($k == 1)
		   {
		   $query49 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and ward <> '0'";
		   $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res49 = mysqli_fetch_array($exec49);
		   $rate = $res49['rate'];
		   $billinganum = $res49['auto_number'];
		   }
		   else
		   {
		   $query491 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and auto_number='$billinganum'";
		   $exec491 = mysqli_query($GLOBALS["___mysqli_ston"], $query491) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res491 = mysqli_fetch_array($exec491);
		   $rate = $res491['rate'];
		   }
		
			$days1 = $days - $packdays;
			
		
			if($packdays == 0)
			{
			   $query1281 = "select * from ip_bedtransfer where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec1281 = mysqli_query($GLOBALS["___mysqli_ston"], $query1281) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1281 = mysqli_num_rows($exec1281);
			if($num1281 > 0)
			{
			 $quantity = $days1;
			}
			else
			{
		   $quantity = $days1 + 1;
		   }
		   }
		   else
		   {
		   $query1281 = "select * from ip_bedtransfer where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec1281 = mysqli_query($GLOBALS["___mysqli_ston"], $query1281) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1281 = mysqli_num_rows($exec1281);
			if($num1281 > 0)
			{
			 $quantity = $days1;
			}
			else
			{
			$quantity = $days1 + 1;
			}
		  
		   }
		  
		   if($packageanum != 0)
		   {
		    	$reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
			}
			else
			{
			$reqdate = $date;
			}
			
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		   $allocatenewquantity = $quantity;
		   
		 
		
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($reqdate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $quantity; ?></td>
    <input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>" />
    <input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>" />
    <input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>" />
    <input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>" />
    <input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>" />
    <input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>" />
    <input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bedname; ?>" />
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($amount,2,'.',','); ?></td>
  </tr>
  <?php 
			 
			 }
			 
		
			 if($days == $packdays)
			 {
			 
			 if($packdays != 0)
			{
			 $days = $days - $packdays;
			
			if($days != 0)
			{
			 $k = $k+1;
		   $billinganum = $billinganum+1;
			 if($k == 1)
		   {
		   $query49 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and ward <> '0'";
		   $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res49 = mysqli_fetch_array($exec49);
		   $rate = $res49['rate'];
		   $billinganum = $res49['auto_number'];
		   }
		   else
		   {
		   $query491 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and auto_number='$billinganum'";
		   $exec491 = mysqli_query($GLOBALS["___mysqli_ston"], $query491) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res491 = mysqli_fetch_array($exec491);
		   $rate = $res491['rate'];
		   }
		   $quantity = $days + 1;
		  
		   
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		   $allocatenewquantiy = $quantity;
		   
		
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($date)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $quantity; ?></td>
    <input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>" />
    <input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>" />
    <input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>" />
    <input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>" />
    <input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>" />
    <input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>" />
    <input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bedname; ?>" />
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($amount,2,'.',','); ?></td>
  </tr>
  <?php 
			 }
			 }
			 }
			 if($packdays == 0)
			 {
			 if($days == 0)
			 {
			
			 $k = $k+1;
		   $billinganum = $billinganum+1;
			 if($k == 1)
		   {
		   $query49 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and ward <> '0'";
		   $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res49 = mysqli_fetch_array($exec49);
		   $rate = $res49['rate'];
		   $billinganum = $res49['auto_number'];
		   }
		   else
		   {
		   $query491 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and auto_number='$billinganum'";
		   $exec491 = mysqli_query($GLOBALS["___mysqli_ston"], $query491) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res491 = mysqli_fetch_array($exec491);
		   $rate = $res491['rate'];
		   }
		   $quantity = $days + 1;
		   
		   $reqdate = $date;
		   
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		    $allocatenewquantiy = $quantity;
		
		
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($date)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $quantity; ?></td>
    <input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>" />
    <input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>" />
    <input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>" />
    <input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>" />
    <input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>" />
    <input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>" />
    <input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bedname; ?>" />
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($amount,2,'.',','); ?></td>
  </tr>
  <?php
			 }
			 }
			 }
			  ?>
  <?php 
			  $snno =0;
			  $i = 0;
			  $j=0;
			 
			  $totalbedtransferamount = 0;
			  $diff5 = 0;
			  $newdate = '';
				
			 
			$query128 = "select * from ip_bedtransfer where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec128 = mysqli_query($GLOBALS["___mysqli_ston"], $query128) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num128 = mysqli_num_rows($exec128);
			while($res128 = mysqli_fetch_array($exec128))
			{
			$snno = $snno + 1;
			$j = $j + 1;
			
			$ward = $res128['ward'];
			$transfer1ward = $res128['ward'];
			$bed = $res128['bed'];
			$refno = $res128['docno'];
			$date = $res128['recorddate'];
			
			$newdate = $res128['recorddate'];
			$transferanum = $res128['auto_number'];
			
		    $datediff = abs(strtotime($bedallocateddate) - strtotime($date));
			$years5 = floor($datediff / (365*60*60*24));
			$months5 = floor(($datediff - $years5 * 365*60*60*24) / (30*60*60*24));
			$days5 = floor(($datediff - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
			
			$newpackdays = $packdays - $days5;
			if($newpackdays > 0)
			{
		    $date = date('Y-m-d',strtotime($date) + (24*3600*$newpackdays));
			}
		
			
			   $query512 = "select * from master_bed where locationcode='$locationcode' and auto_number='$bed'";
			   $exec512 = mysqli_query($GLOBALS["___mysqli_ston"], $query512) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   $res512 = mysqli_fetch_array($exec512);
			   $bedname = $res512['bed'];
			   $threshold = $res512['threshold'];
			   $thresholdvalue = $threshold/100;
			   
			$query912 = "select * from master_bedcharge where locationcode='$locationcode' and bedanum='$bed' and recordstatus =''";
			$exec912 = mysqli_query($GLOBALS["___mysqli_ston"], $query912) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num912 = mysqli_num_rows($exec912);
			while($res912 = mysqli_fetch_array($exec912))
		    {
			$i = $i + 1;
			
		    $charge = $res912['charge'];
		   
		   
		   
		   
		   
		  	
			$query66 = "select * from ip_bedtransfer where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' and auto_number > '$transferanum' order by auto_number asc limit 0,1";
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res66 = mysqli_fetch_array($exec66);
			$date1 = $res66['recorddate'];
			$transferdate = $res66['recorddate'];
		   $diff = abs(strtotime($date1) - strtotime($date));
			
			if($num128 == $snno)
			{
			$query81 = "select * from ip_discharge where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num81 = mysqli_num_rows($exec81);
			if($num81 > 0)
			{
			$res81 = mysqli_fetch_array($exec81);
			$date1 = $res81['recorddate'];
			
			$diff = abs(strtotime($date1) - strtotime($date));
		
			}else
			{
		 	$diff = abs(strtotime($updatedate) - strtotime($date));
			
			}
			}
			
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			$query811 = "select * from ip_discharge where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec811 = mysqli_query($GLOBALS["___mysqli_ston"], $query811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num811 = mysqli_num_rows($exec811);
		
			if($num811 > 0)
			{
			$res811 = mysqli_fetch_array($exec811);
			$date12 = $res811['recorddate'];
				if($packageanum1 != 0)
			{
			$diff5 = abs(strtotime($date12) - strtotime($packagedate));
			}
			}
			else
			{
					if($packageanum1 != 0)
			{
		    $diff5 = abs(strtotime($updatedate) - strtotime($packagedate));
			}
			}
			$years5 = floor($diff5 / (365*60*60*24));
			$months5 = floor(($diff5 - $years5 * 365*60*60*24) / (30*60*60*24));
		    $days5 = floor(($diff5 - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
			if($packageanum1 != 0)
			{
			if($days5 >= $packdays)
			{
			
			if($allocateward == $ward)
			{
			if($allocatedate != '')
			{
				if($allocatedate == $allocate1date)
			{
			
			if($quantity != '')
			{
			 $quantity = $quantity - 1;
			
			 }
			
			 if($packageanum1 != 0)
			 {
			 $quantity = $quantity + $packdays;
			 }
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 else
			 {
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 }
			
		
			
			$query812 = "select * from ip_discharge where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec812 = mysqli_query($GLOBALS["___mysqli_ston"], $query812) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num812 = mysqli_num_rows($exec812);
			if($num812 > 0)
			{
			$res812 = mysqli_fetch_array($exec812);
			$date12 = $res812['recorddate'];
			
			if($date12 == $transferdate)
			{
			$days = $days - 1;
			}
		
			}else
			{
		 	if($updatedate == $transferdate)
			{
			$days = $days - 1;
			}
			
			}
				
			}
			if($j > 1)
			{
			
			if($allocateward != $ward)
			{
			$quantity = $days + 1;
			}
			else
			{
			$quantity = $days;
			}
			}
			else
			{
		 $quantity = $days + 1;
		 }
		  
		   if($quantity != 0)
		   {
		  $k = $k+1;
		   $billinganum = $billinganum+1;
			 if($k == 1)
		   {
		   $query49 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and ward <> '0'";
		   $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res49 = mysqli_fetch_array($exec49);
		   $rate = $res49['rate'];
		   $billinganum = $res49['auto_number'];
		   }
		   else
		   {
		   $query491 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and auto_number='$billinganum'";
		   $exec491 = mysqli_query($GLOBALS["___mysqli_ston"], $query491) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res491 = mysqli_fetch_array($exec491);
		   $rate = $res491['rate'];
		   }
		   if($i == 1)
		   {
		   
		     $reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$allocatenewquantity));
		    }
			if($allocateward != $ward)
				{
				$reqdate = $newdate;
				}
		   $amount = $quantity * $rate;
		   $totalbedtransferamount = $totalbedtransferamount + $amount;
		   
		   $totalquantity = $totalquantity + $quantity;
		
		
			
			 ?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($reqdate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $quantity; ?></td>
    <input type="hidden" name="descriptioncharge1[]" id="descriptioncharge1" value="<?php echo $charge; ?>" />
    <input type="hidden" name="descriptionchargerate1[]" id="descriptionchargerate1" value="<?php echo $rate; ?>" />
    <input type="hidden" name="descriptionchargeamount1[]" id="descriptionchargeamount1" value="<?php echo $amount; ?>" />
    <input type="hidden" name="descriptionchargequantity1[]" id="descriptionchargequantity1" value="<?php echo $quantity; ?>" />
    <input type="hidden" name="descriptionchargedocno1[]" id="descriptionchargedocno1" value="<?php echo $refno; ?>" />
    <input type="hidden" name="descriptionchargeward1[]" id="descriptionchargeward1" value="<?php echo $ward; ?>" />
    <input type="hidden" name="descriptionchargebed1[]" id="descriptionchargebed1" value="<?php echo $bedname; ?>" />
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($amount,2,'.',','); ?></td>
  </tr>
  <?php 
			
			  }
			  $allocatedate = '';
			 }
			 }
			 
			
			if($packageanum1 == 0)
			{
			
			if($i == 1)
		   {
		   if($reqdate == $date )
		   {
		   $reqdate2 = $date;
		   }
		   else
		   {
	    $reqdate2 = date('Y-m-d',strtotime($reqdate) + (24*3600*$allocatenewquantity) - 1);
		}
		  
		if( $reqdate2 == $date)
		{
		$reqdate = $date;
		}
		else
		{
			$reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$quantity));
			}
			}
			
			 if($days5 == 0)
			 {
			 if($allocateward == $ward)
			{
			
			if($allocatedate != '')
			{
			if($allocatedate == $allocate1date)
			{
			 $quantity = $quantity - 1;
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 else
			 {
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 if($transdate > $updatedate)
			 {
			 $transdate = $updatedate;
			 }
			 }
			 }
			
		if($transdate == $newdate)
		{
		 $days = $days - 1;
		}
		}
		
		
		  $quantity = $days + 1;
		  
		   
		   if($quantity != 0)
		   {
		   $k = $k+1;
		   $billinganum = $billinganum+1;
			 if($k == 1)
		   {
		   $query49 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and ward <> '0'";
		   $exec49 = mysqli_query($GLOBALS["___mysqli_ston"], $query49) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res49 = mysqli_fetch_array($exec49);
		   $rate = $res49['rate'];
		   $billinganum = $res49['auto_number'];
		   }
		   else
		   {
		   $query491 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and auto_number='$billinganum'";
		   $exec491 = mysqli_query($GLOBALS["___mysqli_ston"], $query491) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res491 = mysqli_fetch_array($exec491);
		   $rate = $res491['rate'];
		   }
		
		   $amount = $quantity * $rate;
		   $totalbedtransferamount = $totalbedtransferamount + $amount;
		   
		   $totalquantity = $totalquantity + $quantity;
		
			
			 ?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($date)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $quantity; ?></td>
    <input type="hidden" name="descriptioncharge12[]" id="descriptioncharge12" value="<?php echo $charge; ?>" />
    <input type="hidden" name="descriptionchargerate12[]" id="descriptionchargerate12" value="<?php echo $rate; ?>" />
    <input type="hidden" name="descriptionchargeamount12[]" id="descriptionchargeamount12" value="<?php echo $amount; ?>" />
    <input type="hidden" name="descriptionchargequantity12[]" id="descriptionchargequantity12" value="<?php echo $quantity; ?>" />
    <input type="hidden" name="descriptionchargedocno12[]" id="descriptionchargedocno12" value="<?php echo $refno; ?>" />
    <input type="hidden" name="descriptionchargeward12[]" id="descriptionchargeward12" value="<?php echo $ward; ?>" />
    <input type="hidden" name="descriptionchargebed12[]" id="descriptionchargebed12" value="<?php echo $bedname; ?>" />
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($amount,2,'.',','); ?></td>
  </tr>
  <?php 
			
			  }
			  $allocatedate = '';
			 }
			}
			 }
		 $reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$quantity));
		 
		 if($reqdate > $updatedate)
		 {
		 $reqdate = $updatedate;
		
		 }
		
			$allocatedate = $newdate;
			$allocateward = $ward;
			 }
			  ?>
  <?php 
			$totalpharm=0;
			$pharmno = 0;
			$query23 = "select * from pharmacysales_details where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res23 = mysqli_fetch_array($exec23))
			{
			$phaquantity=0;
			$quantity1=0;
			$phaamount=0;
			$phaquantity1=0;
			$totalrefquantity=0;
			$phaamount1=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$refno = $res23['ipdocno'];
			$pharmfree = $res23['freestatus'];
			$query33 = "select * from pharmacysales_details where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query331 = "select * from pharmacysalesreturn_details where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($res331 = mysqli_fetch_array($exec331))
			{
			$quantity1=$res331['quantity'];
			$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			$phaamount1=$phaamount1+$amount1;
			}
			
			$resquantity = $phaquantity - $phaquantity1;
			$resamount = $phaamount - $phaamount1;
						
			$resamount=number_format($resamount,2,'.','');
			if($resquantity != 0)
			{
			if($pharmfree =='No')
			{
			$pharmno = $pharmno + 1;
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$totalpharm=$totalpharm+$resamount;
			?>
  <?php
			if($pharmno == '1')
			{
			?>
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy</strong></td>
  </tr>
  <?php
}
?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($phadate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $phaname; ?></td>
    <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>" />
    <input name="quantity[]" type="hidden" id="quantity" size="8" readonly="readonly" value="<?php echo $resquantity; ?>" />
    <input name="rate[]" type="hidden" id="rate" readonly="readonly" size="8" value="<?php echo $pharate; ?>" />
    <input name="amount[]" type="hidden" id="amount" readonly="readonly" size="8" value="<?php echo $resamount; ?>" />
    <td class="bodytext31" valign="center"  align="right"><?php echo $resquantity; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($pharate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $resamount; ?></td>
  </tr>
  <?php }
			  }
			  }
			  ?>
  <?php 
			  $totallab=0;
			  $labno = 0;
			  $query19 = "select * from ipconsultation_lab where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['iptestdocno'];
			$labfree = $res19['freestatus'];
			
			
			if($labfree == 'No')
			{
			
		$labno = $labno + 1;
			$totallab=$totallab+$labrate;
			?>
  <?php
			if($labno == '1')
			{
			?>
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Lab</strong></td>
  </tr>
  <?php
}
?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($labdate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $labrefno; ?></td>
    <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>" />
    <input name="rate5[]" id="rate5" readonly="readonly" size="8" type="hidden" value="<?php echo $labrate; ?>" />
    <input name="labcode[]" id="labcode" readonly="readonly" size="8" type="hidden" value="<?php echo $labcode; ?>" />
    <td class="bodytext31" valign="center"  align="left"><?php echo $labname; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($labrate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($labrate,2,'.',','); ?></td>
  </tr>
  <?php }
			  }
			  ?>
	  
			  
  <?php 
				$totalrad=0;
				$radno = 0;
			  $query20 = "select * from ipconsultation_radiology where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
			$radiologyfree = $res20['freestatus'];
			
			
			if($radiologyfree == 'No')
			{
			$radno = $radno + 1;
		
			$totalrad=$totalrad+$radrate;
			?>
  <?php
			if($radno == '1')
			{
			?>
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
		 <?php if($sno > 40) { //echo $sno; ?>
	   <tr>
	    <td colspan="7">
	     <br/><br/><br/>	    </td>
	   </tr>	
	 <?php } ?>	
	 
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Radiology</strong></td>
  </tr>
  <?php
}
?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($raddate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $radref; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $radname; ?></td>
    <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>" />
    <input name="rate8[]" type="hidden" id="rate8" readonly="readonly" size="8" value="<?php echo $radrate; ?>" />
    <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($radrate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($radrate,2,'.',','); ?></td>
  </tr>
  <?php }
			  }
			  ?>
  <?php 
					
					$totalser=0;
					$serno = 0;
		    $query21 = "select * from ipconsultation_services where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' group by servicesitemname";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$query2111 = "select * from ipconsultation_services where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			if($servicesfree == 'No')
			{
			$totserrate=$serrate*$numrow2111;
		
		
			$totalser=$totalser+$totserrate;
			
			$serno = $serno + 1;
				
			?>
  <?php
			if($serno == '1')
			{
			?>
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Services</strong></td>
  </tr>
  <?php
}
?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($serdate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $serref; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sername; ?></td>
    <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>" />
    <input name="rate3[]" type="hidden" id="rate3" readonly="readonly" size="8" value="<?php echo $serrate; ?>" />
    <td class="bodytext31" valign="center"  align="right"><?php echo $numrow2111; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($serrate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totserrate,2,'.',','); ?></td>
  </tr>
  <?php }
			  }
			  ?>
  <?php
			$totalprivatedoctoramount = 0;
			$privateno = 0;
			$query62 = "select * from ipprivate_doctor where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res62 = mysqli_fetch_array($exec62))
		   {
			$privatedoctordate = $res62['consultationdate'];
			$privatedoctorrefno = $res62['docno'];
			$privatedoctor = $res62['doctorname'];
			$privatedoctorrate = $res62['rate'];
			$privatedoctoramount = $res62['amount'];
			$privatedoctorunit = $res62['units'];
			$privateno = $privateno + 1;
		
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
			?>
  <?php
			if($privateno == '1')
			{
			?>
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Doctor</strong></td>
  </tr>
  <?php
}
?>
  <tr>
    <td height="10"  align="left" valign="center" class="bodytext31"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($privatedoctordate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $privatedoctorrefno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $privatedoctor; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $privatedoctorunit; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($privatedoctorrate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></td>
  </tr>
  <?php
				}
				?>
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
   <?php if($sno > 42 && $sno > 80) { //echo $sno; ?>
	   <tr>
	    <td>
	     <br/><br/><br/>	    </td>
	   </tr>	
	 <?php } ?>	
  <tr>
    <td colspan="7" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31"><strong>Others</strong></td>
  </tr>
  <?php
			$totalotbillingamount = 0;
			$query61 = "select * from ip_otbilling where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res61 = mysqli_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
			if($otbillingrate >0)
			{
			$colorloopcount = $colorloopcount + 1;
			
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
			?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($otbillingdate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $otbillingrefno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $otbillingname; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></td>
  </tr>
  <?php
				}
				}
				?>
  <?php
			$totalambulanceamount = 0;
			$query63 = "select * from ip_ambulance where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res63 = mysqli_fetch_array($exec63))
		   {
			$ambulancedate = $res63['consultationdate'];
			$ambulancerefno = $res63['docno'];
			$ambulance = $res63['description'];
			$ambulancerate = $res63['rate'];
			$ambulanceamount = $res63['amount'];
			$ambulanceunit = $res63['units'];
			
		
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($ambulancedate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $ambulancerefno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $ambulance; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $ambulanceunit; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($ambulancerate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></td>
  </tr>
  <?php
				}
				?>
  <?php
			$totalmiscbillingamount = 0;
			$query69 = "select * from ipmisc_billing where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res69 = mysqli_fetch_array($exec69))
		   {
			$miscbillingdate = $res69['consultationdate'];
			$miscbillingrefno = $res69['docno'];
			$miscbilling = $res69['description'];
			$miscbillingrate = $res69['rate'];
			$miscbillingamount = $res69['amount'];
			$miscbillingunit = $res69['units'];
			
			
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
			?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($miscbillingdate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $miscbillingrefno; ?></td>
    <td class="bodytext31" valign="center"  align="left" width="300"><?php echo $miscbilling; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $miscbillingunit; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($miscbillingrate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($miscbillingamount,2,'.',','); ?></td>
  </tr>
  <?php
				}
				?>
  <?php
			$totaldiscountamount = 0;
			$query64 = "select * from ip_discount where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res64 = mysqli_fetch_array($exec64))
		   {
			$discountdate = $res64['consultationdate']; 
			$discountrefno = $res64['docno'];
			$discount= $res64['description'];
			$discountrate = $res64['rate'];
			$discountrate1 = $discountrate;
			$discountrate = -$discountrate;
			$authorizedby = $res64['authorizedby'];
			
		
			$totaldiscountamount = $totaldiscountamount + $discountrate;
			?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($discountdate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $discountrefno; ?></td>
    <td class="bodytext31" valign="center"  align="left" width="300">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($discountrate1,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($discountrate,2,'.',','); ?></td>
  </tr>
  <?php
				}
				?>
  <?php
			$totalnhifamount = 0;
			$query641 = "select * from ip_nhifprocessing where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res641= mysqli_fetch_array($exec641))
		   {
			$nhifdate = $res641['consultationdate'];
			$nhifrefno = $res641['docno'];
			$nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			$nhifclaim = -$nhifclaim;
			
		
			$totalnhifamount = $totalnhifamount + $nhifclaim;
			?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($nhifdate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $nhifrefno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo 'NHIF'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo $nhifqty; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($nhifrate,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($nhifclaim,2,'.',','); ?></td>
  </tr>
  <?php
				}
				?>
  <?php
			$totaldepositamount = 0;
			$query112 = "select * from master_transactionipdeposit where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			$query731 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
		
			
			
			
			$totaldepositamount = $totaldepositamount + $depositamount1;
			?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($transactiondate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $docno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>
        <?php
				if($transactionmode == 'CHEQUE')
				{
				echo $chequenumber;
				}
				?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($depositamount,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right">-<?php echo number_format($depositamount,2,'.',','); ?></td>
  </tr>
  <?php }
			  
			  ?>
  <?php 
			$totaldepositrefundamount = 0;
			$query112 = "select * from deposit_refund where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositrefundamount = $res112['amount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['recorddate'];
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			 ?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo date("m/d/y", strtotime($transactiondate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $docno; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo 'Deposit Refund'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>
  </tr>
  <?php  
			  }
			   ?>
			   
  <?php 
			  $depositamount = 0;
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount+$totaldepositrefundamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
				?>
  <tr>
    <?php  $overalltotal = round($overalltotal); ?>
    <td colspan="3" class="bodytext31" align="right">&nbsp;</td>
    <input type="hidden" name="netpayable" id="netpayable" value="<?php echo $overalltotal; ?>" />
    <td class="bodytext31" align="center">&nbsp;</td>
    <td class="bodytext31" align="center">&nbsp;</td>
    <td class="bodytext31" align="center"><strong> Net Payable</strong></td>
    <td class="bodytext31" align="right"><strong><?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
  </tr>
  <tr>
    <td colspan="6" class="bodytext31" align="right"><strong> Receivable Account</strong></td>
    <td align="right" class="bodytext31" width="100"><strong><?php echo $accname; ?></strong></td>
  </tr>
  <tr>
    <td colspan="7" class="bodytext31" align="right"><table width="320" border="0" align="left">
      <?php
			if($accname == 'CASH')
			{
			?>
      <?php
			$query222 = "select * from master_transactionip where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'; ";
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res222 = mysqli_fetch_array($exec222);
			$res222totalamount = $res222["transactionamount"];
			$res222balanceamount = $res222["balanceamount"];
			$res222chequemount = $res222["chequeamount"];
		    $res222chequenumber = $res222["chequenumber"];
			$res222onlineamount = $res222["onlineamount"];
		    $res222onlinenumber = $res222["onlinenumber"];
			$res222creditamount= $res222["creditamount"];
		    $res222creditcardnumber = $res222["creditcardnumber"];
			$res222mpesamount= $res222["mpesaamount"];
		    $res222mpesanumber = $res222["mpesanumber"];
			?>
      <?php if($res222totalamount!= 0.00) { ?>
      <tr>
        <td width="67" align="left" class="bodytext31"><strong>Cash</strong></td>
        <td width="37"  align="right" class="bodytext31"><?php echo $res222totalamount; ?></td>
        <td width="40"  align="left" class="bodytext31">&nbsp;</td>
        <td width="125"  align="left" class="bodytext31"><strong>Balance</strong></td>
        <td width="29"  align="right" class="bodytext31"><?php echo $res222balanceamount; ?></td>
      </tr>
      <?php } ?>
      <?php if($res222chequemount!= 0.00) { ?>
      <tr>
        <td align="left" class="bodytext31"><strong>Cheque</strong></td>
        <td class="bodytext31" align="right"><?php echo $res222chequemount; ?></td>
        <td class="bodytext31" align="left">&nbsp;</td>
        <td class="bodytext31" align="left"><strong>Cheque Number</strong></td>
        <td class="bodytext31" align="right"><?php echo $res222chequenumber; ?></td>
      </tr>
      <?php } ?>
      <?php if($res222onlineamount!= 0.00) { ?>
      <tr>
        <td class="bodytext31" align="left"><strong>Online</strong></td>
        <td class="bodytext31" align="right"><?php echo $res222onlineamount; ?></td>
        <td class="bodytext31" align="left">&nbsp;</td>
        <td class="bodytext31" align="left"><strong>Online Number</strong></td>
        <td class="bodytext31" align="right"><?php echo $res222onlinenumber; ?></td>
      </tr>
      <?php } ?>
      <?php if($res222creditamount!= 0.00) { ?>
      <tr>
        <td class="bodytext31" align="left"><strong>Credit Card</strong></td>
        <td class="bodytext31" align="right"><?php echo $res222creditamount; ?></td>
        <td class="bodytext31" align="left" >&nbsp;</td>
        <td class="bodytext31" align="left" ><strong>Credit Card Number</strong></td>
        <td class="bodytext31" align="right"><?php echo $res222creditcardnumber; ?></td>
      </tr>
      <?php } ?>
      <?php if($res222mpesamount!= 0.00) { ?>
      <tr>
        <td class="bodytext31" align="left"><strong>MPESA</strong></td>
        <td class="bodytext31" align="right"><?php echo $res222mpesamount; ?></td>
        <td class="bodytext31" align="left" >&nbsp;</td>
        <td class="bodytext31" align="left" ><strong>MPESA Number</strong></td>
        <td class="bodytext31" align="right"><?php echo $res222mpesanumber; ?></td>
      </tr>
	  <?php } ?>
	  <?php } ?>	
    </table></td>
  </tr>
</table>
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printipfinalinvoice.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>

		