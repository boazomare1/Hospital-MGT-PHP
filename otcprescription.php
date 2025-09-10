<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';

$docno = $_SESSION['docno'];
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						 $locationnameget = $res1["locationname"];
						 $locationcodeget = $res1["locationcode"];
						
$query23 = "select * from master_employeelocation where username='$username' and locationcode = '$locationcodeget' and defaultstore = 'default'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['locationanum'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['storecode'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	
	//get location name and code get
	$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
	$locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
	//get location ends here
	$paynowbillprefix = 'EP-';
	$paynowbillprefix1=strlen($paynowbillprefix);
 	
	
		$query91="select * from prescription_externalpharmacy";
		$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num91 = mysqli_num_rows($exec91);
		if($num91 ==0)
		{
		$billnumber = $paynowbillprefix.'1';
		}
		else
		{
		$query92 = "select * from prescription_externalpharmacy order by auto_number desc limit 0, 1";
		$exec92 = mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die ("Error in Query92".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res92 = mysqli_fetch_array($exec92);
		$billnumberval1= $res92["billnumber"];
		$billdigit=strlen($billnumberval1);
		$billnumber = substr($billnumberval1,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
		$billnumber = intval($billnumber);
		$billnumber = $billnumber + 1;
	
		$maxanum = $billnumber;
		
		
		$billnumber = 'EP-' .$maxanum;
		}
		$billdate=$_REQUEST['billdate'];
		
		$patientfirstname = $_REQUEST["customername"];
		$patientfirstname = strtoupper($patientfirstname);
		$patientmiddlename = $_REQUEST['customermiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $_REQUEST["customerlastname"];
		$patientlastname = strtoupper($patientlastname);
		$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender'];
		$dispensingfee = $_REQUEST['dispensingfee'];
		
		$query24 = "select * from master_consultationpharm order by auto_number desc limit 0, 1";
	    $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res24 = mysqli_fetch_array($exec24);
		$pharefnonumber = $res24["refno"];
	
         for ($p=1;$p<=20;$p++)
		  {	
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_REQUEST['medicinename'.$p];
			$medicinename = addslashes($medicinename);
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$dose = $_REQUEST['dose'.$p];
		    $frequency = $_REQUEST['frequency'.$p];
			$sele=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencycode='$frequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress=mysqli_fetch_array($sele);
			$frequencyautonumber=$ress['auto_number'];
			$frequencycode=$ress['frequencycode'];
			$frequencynumber=$ress['frequencynumber'];
			$days = $_REQUEST['days'.$p];
			$quantity = $_REQUEST['quantity'.$p];
			$instructions = $_REQUEST['instructions'.$p];
			$rate = $_REQUEST['rates'.$p];
			$amount = $_REQUEST['amount'.$p];
			$presdiscamount = $_REQUEST['presdiscountamount'.$p];
				//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
				if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
				{
					//echo '<br>'. 
					$query2 = "insert into master_consultationpharm(patientcode,patientname,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,billnumber,locationname,locationcode) 
					values('walkin','$patientfullname','walkinvis','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','pending','$medicinecode','$pharefnonumber','pending','pending','$billnumber','".$locationnameget."','".$locationcodeget."')";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$query29 = "insert into master_consultationpharmissue(patientcode,patientname,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,paymentstatus,medicinecode,billnumber,refno,prescribed_quantity,locationname,locationcode) 
					values('walkin','$patientfullname','walkinvis','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','pending','$medicinecode','$billnumber','$pharefnonumber','$quantity','".$locationnameget."','".$locationcodeget."')";
					$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
				
					$query2 = "insert into prescription_externalpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,paymentstatus,medicinecode,billnumber,username,age,gender,locationname,locationcode) 
					values('walkin','$patientfullname','walkinvis','$medicinename','$quantity','$rate','$amount','$currentdate','$ipaddress','pending','$medicinecode','$billnumber','$username','$age','$gender','".$locationnameget."','".$locationcodeget."')";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
					if($dispensingfee != '')
					{
						$query2bill1 = "select * from dispensingfee order by auto_number desc limit 0, 1";
						$exec2bill1 = mysqli_query($GLOBALS["___mysqli_ston"], $query2bill1) or die ("Error in Query2bill".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2bill1 = mysqli_fetch_array($exec2bill1);
						$billnumber1 = $res2bill1["docno"];
						if ($billnumber1 == '')
						{
							$billnumbercode1 ='DSF-'.'1';
							$openingbalance = '0.00';
						}
						else
						{
							$billnumber1 = $res2bill1["docno"];
							$billnumbercode1 = substr($billnumber1, 4, 8);
							$billnumbercode1 = intval($billnumbercode1);
							$billnumbercode1 = $billnumbercode1 + 1;		
							$maxanum1 = $billnumbercode1;						
							$billnumbercode1 = 'DSF-' .$maxanum1;
							$openingbalance = '0.00';
							//echo $companycode;
						}
					   $queryinsert1 = "insert into dispensingfee (recorddate,recordtime,patientname,visitcode,patientcode,age,gender,billtype,accountname,ipaddress,username,dispensingfee,docno,locationname,locationcode) values
						('$dateonly','$timeonly','$patientfullname','walkinvis','walkin','$age','$gender','PAY NOW','CASH','$ipaddress','$username','$dispensingfee','$billnumbercode1','".$locationnameget."','".$locationcodeget."')";
						mysqli_query($GLOBALS["___mysqli_ston"], $queryinsert1) or die ("Error in Queryinsert1".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
				
				

						
				}
		
		 }
		 
		 header("location:menupage1.php?mainmenuid=MM015");
		 
}

include("autocompletebuild_medicine1.php");
$paynowbillprefix = 'EP-';
	$paynowbillprefix1=strlen($paynowbillprefix);

		$query91="select * from prescription_externalpharmacy";
		$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num91 = mysqli_num_rows($exec91);
		if($num91 ==0)
		{
		$billnumber = $paynowbillprefix.'1';
		}
		else
		{
		$query92 = "select * from prescription_externalpharmacy order by auto_number desc limit 0, 1";
		$exec92 = mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die ("Error in Query92".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res92 = mysqli_fetch_array($exec92);
		$billnumberval1= $res92["billnumber"];
		$billdigit=strlen($billnumberval1);
		$billnumber = substr($billnumberval1,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
		$billnumber = intval($billnumber);
		$billnumber = $billnumber + 1;
	
		$maxanum = $billnumber;
		
		
		$billnumber = 'EP-' .$maxanum;
		}
?>
<script type="text/javascript">
function funcOnLoadBodyFunctionCall()
{
	
	funcCustomerDropDownSearch4(); 
}	
	
</script>

<?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch2.js"></script>

<script type="text/javascript" src="js/insertnewitem21.js"></script>

<script type="text/javascript">
function frequencyitem()
{
if(document.form1.frequency.value=="select")
{
alert("please select a frequency");
document.form1.frequency.focus();
return false;
}
return true;
}

function Functionfrequency()
{
var formula = document.getElementById("formula").value;
formula = formula.replace(/\s/g, '');
//alert(formula);
if(formula == 'INCREMENT')
{
var ResultFrequency;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum * VarDays;
 }
 else
 {
 ResultFrequency =0;
 }
 document.getElementById("quantity").value = ResultFrequency;
var VarRate = document.getElementById("rates").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
  document.getElementById("presamount").value = ResultAmount.toFixed(2);
}

else if(formula == 'CONSTANT')
{
var ResultFrequency;
var strength = document.getElementById("strength").value;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum*VarDays/strength;
 }
 else
 {
 ResultFrequency =0;
 }
 //ResultFrequency = parseInt(ResultFrequency);

 ResultFrequency = Math.ceil(ResultFrequency);
 //alert(ResultFrequency);
 document.getElementById("quantity").value = ResultFrequency;
 
 
var VarRate = document.getElementById("rates").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
  document.getElementById("presamount").value = ResultAmount.toFixed(2);
}
}

function btnDeleteClick(delID,pharmamount)
{
var pharmamount=pharmamount;
	//alert ("Inside btnDeleteClick.");
	var newtotal4;
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	var currenttotal4=document.getElementById('total').value;
	//alert(currenttotal);
	newtotal4= currenttotal4-pharmamount;
	
	newtotal4 = newtotal4.toFixed(2);
	
	document.getElementById('total').value=newtotal4;
	document.getElementById("totamount").value = newtotal4;
	
	
}

function validcheck()
{
var patientname = document.getElementById("customername").value;

if(patientname == '')
{
alert("Please Enter Patient First Name");
document.getElementById("customername").focus();
return false;
}
var patientlastname = document.getElementById("customerlastname").value;
if(patientlastname == '')
{
alert("Please Enter Patient Last Name");
document.getElementById("customerlastname").focus();
return false;
}
if(confirm("Are You Want To Save The Record?")==false){return false;}
//document.getElementById("subbutton").disabled = true;
	document.form1.submit();
}
function calculate()
{
var dispensingfee = document.getElementById("dispensingfee").value;
var grandtotal = document.getElementById("totamount").value;
if(isNaN(dispensingfee))
{
	alert("Enter Numbers Only");
	document.getElementById("dispensingfee").focus();
}
	else
	{
		if(dispensingfee == "")
		{
			var dispensingfee = 0;
		}
		else
		{
			var dispensingfee = dispensingfee;
		}
		if(grandtotal == "")
		{
			var grandtotal = 0;
		}
		else
		{
			var grandtotal = grandtotal;
		}
		//grandtotal=grandtotal.replace(/,/g,'');
		var newgrandtotal = parseFloat(dispensingfee) + parseFloat(grandtotal);
		if(dispensingfee != '')
		{
			document.getElementById("total").value = newgrandtotal.toFixed(2);
		}
		else
		{
			document.getElementById("total").value = grandtotal;
		}
	}
}
</script>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {
	font-size: 30px;
	font-weight: bold;

}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bal
{
border-style:none;
background:none;
text-align:right;
font-size: 30px;
	font-weight: bold;
	FONT-FAMILY: Tahoma
}
</style>

<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript">
function PresMaxValid()
{
	var Presdiscount = document.getElementById("presdiscount").value;
	var Maxdiscount = document.getElementById("maxdiscount").value;
	var Itemrate5 = document.getElementById("presamount").value;
	if(isNaN(Presdiscount))
	{
		alert("Enter Numbers only");
		document.getElementById("presdiscount").value = "";
		document.getElementById("amount").value = document.getElementById("presamount").value;
		document.getElementById("presdiscount").focus();
		return false;
	}
	else
	{		
		if(Presdiscount == "")
		{
			var Presdiscount = 0;
		}
		else
		{
		    var Presdiscount = Presdiscount;
		}
		if(parseFloat(Presdiscount) > parseFloat(Maxdiscount))
		{
			alert("Maximum allowed discount is "+Maxdiscount);
			document.getElementById("presdiscount").value = 0;
			document.getElementById("amount").value = document.getElementById("presamount").value;
			return false;
		}
		else
		{
			var DiscountAmt = (parseFloat(Presdiscount) / 100) * (parseFloat(Itemrate5));
			//alert(DiscountAmt);
			var ItemNewrate = parseFloat(Itemrate5) - parseFloat(DiscountAmt);
			document.getElementById("amount").value = ItemNewrate.toFixed(2);
			document.getElementById("presdiscountamount").value = DiscountAmt;
			
		}
	}	
}
</script>
</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="otcprescription.php" onKeyDown="return disableEnterKey(event)" >
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="0%">&nbsp;</td>
    <td colspan="2" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                 <td colspan="3" bgcolor="#ecf0f5" class="bodytext32"><strong>Patient Details</strong></td>
                <td colspan="1" bgcolor="#ecf0f5" class="bodytext32"><strong>Location </strong><?php echo $locationnameget;?></td>
                <input type="hidden" name="locationnameget" value="<?php echo $locationnameget;?>">
                <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget;?>">
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td width="22%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"> &nbsp;First Name   </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> &nbsp;Middle Name   </span></td>
				  <td width="39%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"> &nbsp;Last Name   </span></td>
				  </tr>
				<tr>
                <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="customername" id="customername" value="" style="text-transform:uppercase;" size="18">
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" style="border: 1px solid #001E6A;" size="45"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input name="customermiddlename" id="customermiddlename" value="" style="text-transform:uppercase;" size="18"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="customerlastname" id="customerlastname" value="" style="text-transform:uppercase;" size="18"></td>
			 <input type="hidden" name="subtype" id="subtype"  value="" >  
				</tr>       
               
			   <tr>
			    <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Age </strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="text" name="age" id="age" value="" size="18" />	</td>			
			   	  <td width="21%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Gender</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<select name="gender" id="gender">
				<option value="">Select </option>
				<option value="Male">Male </option>
				<option value="Female">Female </option>
				</select>		</td>	
 </tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong>Doc Date</strong></td>
				<td><input type="text" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" size="18" rsize="20" readonly/>				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
				<td><input type="text" name="billno" id="billno" value="<?php echo $billnumber; ?>" size="18" rsize="20" readonly/>								</td>
				  </tr>
                  				
				 		
				 
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table></td>
      </tr>
     
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
          
			 <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Prescription</strong> </td>
			      </tr>
          <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="200" class="bodytext3">Medicine Name</td>
                       <td width="48" class="bodytext3">Dose</td>
                       <td width="41" class="bodytext3">Freq</td>
                       <td width="48" class="bodytext3">Days</td>
                       <td width="48" class="bodytext3">Quantity</td>
                       <td width="120" class="bodytext3">Instructions</td>
                       <td class="bodytext3">Disc %</td>
					   <td class="bodytext3">Rate</td>
                       <td width="48" class="bodytext3">Amount</td>
                       <td width="42" class="bodytext3">&nbsp;</td>
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <?php
					  $query56 = "select * from master_employee where username = '$username'";
					  $exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die ("Error in Query56".mysqli_error($GLOBALS["___mysqli_ston"]));
					  $res56 = mysqli_fetch_array($exec56);
					  $res56discount = 'yes';
					  $res56maxdiscount = $res56['maxdiscount'];
					  ?>
					  <input type="hidden" name="maxdiscount" id="maxdiscount" value="<?php echo $res56maxdiscount; ?>">
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
					  <input type="hidden" name="presdiscountamount" id="presdiscountamount" value="">
					   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			           <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
			
                       <td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off">					   </td>
                       <td><input name="dose" type="text" id="dose" size="8" onKeyUp="return Functionfrequency()"></td>
                       <td>
					   <select name="frequency" id="frequency" onChange="return Functionfrequency()">
					     <?php
				if ($frequncy == '')
				{
					echo '<option value="select" selected="selected">Select frequency</option>';
				}
				else
				{
					$query51 = "select * from master_frequency where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51code = $res51["frequencycode"];
					$res51num = $res51['frequencynumber'];
					echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';
				}
				$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5num = $res5["auto_number"];
				$res5code = $res5["frequencycode"];
				$res5frequencynum = $res5['frequencynumber'];
				?>
                <option value="<?php echo $res5frequencynum; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
               </select>				</td>	
                       <td><input name="days" type="text" id="days" size="8" onKeyUp="return Functionfrequency()" onFocus="return frequencyitem()"></td>
                       <td><input name="quantity" type="text" id="quantity" size="8" readonly="readonly"></td>
                       <td><input name="instructions" type="text" id="instructions" size="20"></td>
					   <td><input name="presdiscount" type="text" id="presdiscount" onKeyUp="return PresMaxValid()"  <?php if($res56discount == 'yes') { echo ''; }else { echo 'readonly=\"readonly\"'; } ?> size="5"></td>
                       <td width="48"><input name="rates" type="text" id="rates" readonly size="8"></td>
                       <td>
					    <input name="presamount" type="hidden" id="presamount" readonly size="8">
                         <input name="amount" type="text" id="amount" readonly size="8"></td>
						  <td>
						  <input type="hidden" name="hiddenmedicinename" id="hiddenmedicinename">
						  <input name="exclude" type="hidden" id="exclude" readonly size="8">
                         <input name="formula" type="hidden" id="formula" readonly size="8"></td>
						 <td>
                         <input name="strength" type="hidden" id="strength" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem65()" class="button">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
				   <tr>
                   <?php 
				   $query3 = "select dispensing from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$dispensingamount = $res3['dispensing'];
				   ?>
				   <td colspan="7" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Dispensing Fee</strong><input type="text" name="dispensingfee" id="dispensingfee" size="7" onKeyUp="return calculate();" value="<?php echo $dispensingamount;?>" readonly></td>
				   </tr>
				   <tr>
			       <td width="11%" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong>
			         <input name="text" type="text" id="total" size="7" readonly><input type="hidden" name="hidtotal" id="hidtotal">
					 <input type="hidden" name="totamount" id="totamount"></td>
			      </tr>
			</tbody>
			</table>			</td>
			</tr>
			
			</table>			</td>
			</tr>
			<tr>
			<td>
			<td width="73%">            
			<td width="3%">            
			<td width="24%">
			<table>
			<tbody>
			<tr>
			<td align="center" valign="center" class="bodytext31" colspan="3">
			  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                <input name="Submit2223" type="button" onClick="return validcheck()" value="Save" accesskey="b" class="button" />			</td>
			</tr>
			</tbody>
			</table>			</td>
			</tr>
			</table>
</form>
			<?php include ("includes/footer1.php"); ?>
			</body>
			</html>