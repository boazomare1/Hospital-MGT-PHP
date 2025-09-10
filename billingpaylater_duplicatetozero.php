<html>
<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$registrationdate = date('Y-m-d');
$registrationtime = date('H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$companycode = $_SESSION['companycode'];
$searchpaymenttype= '';
?>
</head>
<body><?php

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }


if ($frmflag1 == 'frmflag1')
{
	if (isset($_REQUEST["billno"])) { 
		
	$billnos = explode(",",$_REQUEST["billno"]); 
    
	if(count($billnos)>0){

    foreach($billnos as $billno){

	$billno=trim($billno);

	$billnoamended = $billno.'/1';
		
	$query0 = "SELECT * FROM billing_paylater WHERE billno = '$billno' ORDER BY auto_number DESC LIMIT 0,1";
	$exec0 = mysqli_query($GLOBALS["___mysqli_ston"], $query0) or die ("Error in Query0".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res0 = mysqli_fetch_array($exec0);
	$billno = $res0['billno'];
	$visitcode = $res0['visitcode'];
	$patientcode = $res0['patientcode'];
	$billnoamended = $visitcode.'/1';
	
		// billing_paylater

		$query33 = "UPDATE billing_opambulancepaylater SET visitcode = '$billnoamended',rate=0,amount=0,fxrate=0,fxamount=0 WHERE visitcode = '$visitcode'  AND patientcode = '$patientcode' AND billnumber = '$billno' ";
		$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query34 = "UPDATE billing_homecarepaylater SET visitcode = '$billnoamended',rate=0,amount=0,fxrate=0,fxamount=0 WHERE visitcode = '$visitcode'  AND patientcode = '$patientcode' AND billnumber = '$billno'";
		$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query35 = "UPDATE billing_paylaterpharmacy SET patientvisitcode = '$billnoamended',rate=0,amount=0,fxrate=0,fxamount=0 WHERE patientvisitcode = '$visitcode'  AND patientcode = '$patientcode' AND billnumber = '$billno'";
		$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die ("Error in Query35".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query36 = "UPDATE billing_paylaterlab SET patientvisitcode = '$billnoamended',labitemrate=0,fxrate=0,fxamount=0 WHERE patientvisitcode = '$visitcode'  AND patientcode = '$patientcode' AND billnumber = '$billno'";
		$exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die ("Error in Query36".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query37 = "UPDATE billing_paylaterradiology SET patientvisitcode = '$billnoamended',radiologyitemrate=0,fxrate=0,fxamount=0 WHERE patientvisitcode = '$visitcode'  AND patientcode = '$patientcode' AND billnumber = '$billno'";
		$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die ("Error in Query37".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query38 = "UPDATE billing_paylaterservices SET patientvisitcode = '$billnoamended',servicesitemrate=0,fxrate=0,fxamount=0 WHERE patientvisitcode = '$visitcode'  AND patientcode = '$patientcode' AND billnumber = '$billno'";
		$exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die ("Error in Query38".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query39 = "UPDATE billing_paylaterreferal SET patientvisitcode = '$billnoamended',referalrate=0,referalamount=0,fxrate=0,fxamount=0 WHERE patientvisitcode = '$visitcode'  AND patientcode = '$patientcode' AND billnumber = '$billno'";
		$exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die ("Error in Query39".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query40 = "UPDATE billing_paylater SET visitcode = '$billnoamended',totalamount=0,fxamount=0 WHERE visitcode = '$visitcode'  AND patientcode = '$patientcode' AND billno = '$billno'";
		$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query41 = "UPDATE billing_paylaterconsultation SET visitcode = '$billnoamended',totalamount=0,fxrate=0,fxamount=0 WHERE visitcode = '$visitcode'  AND patientcode = '$patientcode' AND billno = '$billno'";
		$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query42 = "UPDATE master_transactionpaylater SET visitcode = '$billnoamended',transactionamount=0,billamount=0,fxrate=0,fxamount=0 WHERE visitcode = '$visitcode'  AND patientcode = '$patientcode' AND billnumber = '$billno'";

		$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));

		$query42 = "UPDATE billing_ipprivatedoctor SET visitcode = '$billnoamended',rate=0,amount=0,transactionamount=0,amountuhx=0,fxrate=0,original_amt=0,sharingamount=0,percentage=0,pvtdr_percentage=0 WHERE visitcode = '$visitcode'  AND patientcode = '$patientcode' AND docno = '$billno'";

		$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query20 = "UPDATE billing_patientweivers SET visitcode = '$billnoamended',consultationamount=0,consultationfxamount=0,pharmacyamount=0,pharmacyfxamount=0,labamount=0,labfxamount=0,radiologyamount=0,radiologyfxamount=0,servicesamount=0,servicesfxamount=0 WHERE visitcode = '$visitcode'  AND patientcode = '$patientcode' AND billno = '$billno'";
		$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));

		$query42 = "UPDATE tb SET transaction_amount=0 WHERE  doc_number = '$billno'";

		$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));



header("location:billingpaylater_duplicatetozero.php");
}
	}
	}
}
?>

      <form name="form1" id="form1" method="post"  action="billingpaylater_duplicatetozero.php">
			<input type="text" name="billno" id="billno"  autocomplete="off" tabindex="1">
			<input type="hidden" name="frmflag1" id="frmflag1"  value = 'frmflag1'>
			<input name="visitsubmit" type="submit"  id="visitsubmit" value="Update"  class="button" />
	  </form>
</body>
</html>

 
