<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$titlestr = 'SALES BILL';

if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }


$query231 = "select * from master_employee where username='$username'";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res231 = mysqli_fetch_array($exec231);
$res7locationanum1 = $res231['location'];

$query551 = "select * from master_location where auto_number='$res7locationanum1'";
$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res551 = mysqli_fetch_array($exec551);
$location1 = $res551['locationname'];

$res7storeanum1 = $res231['store'];

$query751 = "select * from master_store where auto_number='$res7storeanum1'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$store1 = $res751['store'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$patientname=$_REQUEST['customername'];
$locationcode = $_REQUEST['locationcode'];
$locationname = $_REQUEST['locationname'];


$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];

$query77 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res77 = mysqli_fetch_array($exec77);
		$doctor = $res77['consultingdoctor'];
		
		$query78 = "select * from master_doctor where auto_number='$doctor'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res78 = mysqli_fetch_array($exec78);
		$doctorname = $res78['doctorname'];
	
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'IPPRF-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ippharmacy_refund order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPPRF-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'IPPRF-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
$dateonly = date("Y-m-d");
$accountname = $_REQUEST['account'];
$totalrefundamount = $_REQUEST['totalamt'];

foreach($_POST['med'] as $key => $value)
{
$medicinename=$_POST['med'][$key];
$itemcode=$_POST['code'][$key];
$rate=$_POST['rate'][$key];
		$quantity=$_POST['quantity'][$key];
		$returnquantity=$_POST['returnquantity'][$key];
		$batchnumber=$_POST['batch'][$key];
		$amount=$_POST['amount'][$key];
		//get docno hrere
$docnumber=$_REQUEST['docnumber'][$key];
//ends here
//get docno hrere
$salseautonumber=$_REQUEST['salseautonumber'][$key];
$getstorecode = $_REQUEST['getstorecode'][$key];
//ends here
		
			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$categoryname = $res31['categoryname'];
			foreach($_POST['ref'] as $check1)
			{
			$refund=$check1;
		
	if($refund == $itemcode)
	{
	if($returnquantity !='')
	{
	$query76 = "select * from master_ipvisitentry where billtype='PAY LATER' and visitcode='$visitcode'";
	$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$num76 = mysqli_num_rows($exec76);
	if($num76 == 0)
	{
	$query43="insert into ippharmacy_refund(patientcode,visitcode,itemcode,itemname,rate,quantity,totalamount,username,ipaddress,entrydate,batchnumber,location,store,billnumber,locationname,locationcode)values('$patientcode','$visitcode','$itemcode','$medicinename','$rate','$returnquantity','$amount','$username','$ipaddress','$dateonly','$batchnumber','$location1','$getstorecode','$billnumbercode','$locationname','$locationcode')";
	$exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query431="insert into pharmacysalesreturn_details(patientcode,visitcode,companyanum,itemcode,itemname,rate,quantity,totalamount,username,ipaddress,entrydate,batchnumber,billstatus,location,store,issuedfrom,ipdocno,categoryname,locationname,locationcode,docnumber,salseautonumber)values('$patientcode','$visitcode','$companyanum','$itemcode','$medicinename','$rate','$returnquantity','$amount','$username','$ipaddress','$dateonly','$batchnumber','pending','$location1','$getstorecode','ip','$billnumbercode','$categoryname','$locationname','$locationcode','".$docnumber."','".$salseautonumber."')";
	$exec431=mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$query44=mysqli_query($GLOBALS["___mysqli_ston"], "update master_ipvisitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
	$query43="insert into ippharmacy_refund(patientcode,visitcode,itemcode,itemname,rate,quantity,totalamount,username,ipaddress,entrydate,batchnumber,location,store,billnumber,locationname,locationcode)values('$patientcode','$visitcode','$itemcode','$medicinename','$rate','$returnquantity','$amount','$username','$ipaddress','$dateonly','$batchnumber','$location1','$getstorecode','$billnumbercode','$locationname','$locationcode')";
	$exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$query431="insert into pharmacysalesreturn_details(patientcode,visitcode,companyanum,itemcode,itemname,rate,quantity,totalamount,username,ipaddress,entrydate,batchnumber,billstatus,location,store,issuedfrom,ipdocno,categoryname,locationname,locationcode,docnumber,salseautonumber)values('$patientcode','$visitcode','$companyanum','$itemcode','$medicinename','$rate','$returnquantity','$amount','$username','$ipaddress','$dateonly','$batchnumber','pending','$location1','$getstorecode','ip','$billnumbercode','$categoryname','$locationname','$locationcode','".$docnumber."','".$salseautonumber."')";
	$exec431=mysqli_query($GLOBALS["___mysqli_ston"], $query431) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query44=mysqli_query($GLOBALS["___mysqli_ston"], "update master_ipvisitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	}
	}
	}
			}
	
}
$query83="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,docno,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,receivableamount,doctorname,locationname,locationcode)values('$patientname',
	          '$patientcode','$visitcode','$dateonly','$accountname','$billnumber','$ipaddress','$companyanum','$companyname','$financialyear','pharmacycredit','$patienttype1','$patientsubtype1','$totalrefundamount','$totalrefundamount','$doctorname','$locationname','$locationcode')";
	$exec83=mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die("error in query83".mysqli_error($GLOBALS["___mysqli_ston"]));		  

  header("location:ipmedicineissuelist.php");
}

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>
<script>
function acknowledgevalid(varSerialNumber2)
{
var varSerialNumber2=varSerialNumber2;

var hasChecked = false;
if (document.getElementById("ref"+varSerialNumber2+"").checked)
{
hasChecked = true;
}

if (hasChecked == false)
{
alert("Please either refund a drug  or click back button on the browser to exit IP Medicine Return");
document.getElementById("returnquantity"+varSerialNumber2+"").value = 0;
return false;
}
return true;

}
function balancecalc(varSerialNumber1,qnty1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;
var qnty1 = qnty1;
var totalcount=totalcount;
//alert(totalcount);
var grandtotal=0;

var abc=acknowledgevalid(varSerialNumber1);
if(abc == true)
{

var returnquantity=document.getElementById("returnquantity"+varSerialNumber1+"").value;
returnquantity = parseInt(returnquantity);
qnty1 = parseInt(qnty1);
if(returnquantity>qnty1)
{
alert("Please Enter a Lesser Quantity");
document.getElementById("balamount"+varSerialNumber1+"").value=0.00;
document.getElementById("totalamt").value=0.00;
document.getElementById("amount"+varSerialNumber1+"").value=0.00;
document.getElementById("returnquantity"+varSerialNumber1+"").value = 0;
document.getElementById("returnquantity"+varSerialNumber1+"").focus();
return false;
}
if(returnquantity <= qnty1)
{
var balancequantity=parseFloat(qnty1)-parseFloat(returnquantity);

document.getElementById("balamount"+varSerialNumber1+"").value=balancequantity;

var rate=document.getElementById("rate"+varSerialNumber1+"").value;

var newamount=rate * returnquantity;
document.getElementById("amount"+varSerialNumber1+"").value=newamount.toFixed(2);
for(i=1;i<=totalcount;i++)
{
var totalamount=document.getElementById("amount"+i+"").value;

if(totalamount == "")
{
totalamount=0;
}
//alert(totalamount);
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);

}
//alert(grandtotal);
document.getElementById("totalamt").value=grandtotal.toFixed(2);
}
return true;
}

}
function updatebox(varSerialNumber3,qnty1,totalcount1)
{
var varSerialNumber3 = varSerialNumber3;
var qnty1 = qnty1;
var totalcount1=totalcount1;
var grandtotal=0;
if(document.getElementById("ref"+varSerialNumber3+"").checked == true)
{
var returnquantity=document.getElementById("returnquantity"+varSerialNumber3+"").value;

if(returnquantity !='')
{
returnquantity = parseInt(returnquantity);
qnty1 = parseInt(qnty1);
if(returnquantity>qnty1)
{
alert("Please Enter a Lesser Quantity");
document.getElementById("balamount"+varSerialNumber3+"").value=0.00;
document.getElementById("totalamt").value=0.00;
document.getElementById("amount"+varSerialNumber3+"").value=0.00;
document.getElementById("returnquantity"+varSerialNumber3+"").value = 0;
document.getElementById("returnquantity"+varSerialNumber3+"").focus();
return false;
}
if(returnquantity <= qnty1)
{
var balancequantity=parseFloat(qnty1)-parseFloat(returnquantity);

document.getElementById("balamount"+varSerialNumber3+"").value=balancequantity;

var rate=document.getElementById("rate"+varSerialNumber3+"").value;

var newamount=rate * returnquantity;
document.getElementById("amount"+varSerialNumber3+"").value=newamount.toFixed(2);
for(i=1;i<=totalcount1;i++)
{
var totalamount=document.getElementById("amount"+i+"").value;

if(totalamount == "")
{
totalamount=0;
}
//alert(totalamount);
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);

}
//alert(grandtotal);
document.getElementById("totalamt").value=grandtotal.toFixed(2);
return true;
}
}
}
else
{
var dum=0;
document.getElementById("balamount"+varSerialNumber3+"").value=0;
document.getElementById("amount"+varSerialNumber3+"").value=dum.toFixed(2);
for(i=1;i<=totalcount1;i++)
{
var totalamount=document.getElementById("amount"+i+"").value;

if(totalamount == "")
{
totalamount=0;
}
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);
}
document.getElementById("totalamt").value=grandtotal.toFixed(2);
}
}

</script>

<script>
function check()
{

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
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.bal
{
border-style:none;
background:none;
text-align:right;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber=$_REQUEST['docnumber'];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_ipvisitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientage=$res69['age'];
$patientgender=$res69['gender'];
$patientaccount=$res69['accountname'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];


$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'IPPRF-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ippharmacy_refund order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPPRF-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'IPPRF-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
 $queryget = "select locationname,locationcode,store FROM pharmacysales_details WHERE patientcode = '".$patientcode."' AND visitcode = '".$visitcode."'";

$execget = mysqli_query($GLOBALS["___mysqli_ston"], $queryget) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$resget = mysqli_fetch_array($execget);

 $getlocationname = $resget['locationname'];
 $getlocationcode = $resget['locationcode'];
//echo $getstorename = $resget['store'];

?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="ippharmacyrefund.php" onKeyDown="return disableEnterKey(event)">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  * </strong></td>
	  <td width="30%" align="left" valign="top" bgcolor="#ecf0f5">
				<input name="customername" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>
                  </td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="42%" bgcolor="#ecf0f5" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
               
               
              </tr>
			 
		
			  <tr>

			    <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="30%" align="left" valign="top" >
			<input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                  </td>
                 <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="top" >
				<input name="customercode" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" >
				<input type="text" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>
				&
				<input type="text" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>
				     </td>
                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="top" >
				<input name="account" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				
				  </tr>
				  <tr>
				      <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Return No </strong></td>
                <td colspan="1" align="left" valign="top" >
				<input name="billnumber" id="billnumber" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
			</td>
			<td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
                <td colspan="1" align="left" valign="top" >
				<?php 
				$query123 ="select * from login_locationdetails where username = '$username'";
				$exec123 = mysqli_query($GLOBALS["___mysqli_ston"], $query123) or die ("Error in Query123".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res123 = mysqli_fetch_array($exec123);
				$locationname = $res123['locationname'];
				$locationcode = $res123['locationcode'];
				?>
				<input type="hidden" name="locationname" id="locationname" value="<?php echo $getlocationname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $getlocationname; ?></td>
				  <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $getlocationcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>		  </tr>
				  <tr>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
              
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
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>
              <td width="18%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Medicine</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Batch No</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Iss. Qty</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ret. Qty</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref. Qty</strong></div></td>
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bal. Qty</strong></div></td>
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
			
			      </tr>
				  		<?php
						
						 $ippharmauotnum=$_REQUEST['ippharmauotnum'];
						 $salseautonumber=$_REQUEST['salseautonumber'];
						 $locationcode=$_REQUEST['location'];
			$colorloopcount = '';
			$sno = '';
			$ssno=0;
			$nno=0;
			$totalamount=0;		
			$totalavaquantity=0;
				$totalavaquantity1=0; 
			$query71 = "select * from pharmacysales_details where locationcode='".$locationcode."' and patientcode = '$patientcode' and visitcode = '$visitcode' and ipdocno='$docnumber'";
$exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec71);
//echo $numb;
while($res71 = mysqli_fetch_array($exec71))
	{
	$totalavaquantity1=0;
	$itemcode=$res71["itemcode"];
$batchnumber=$res71["batchnumber"];
$quantity=$res71["quantity"];
  $getstorecode=$res61["store"];
$query72 = "select * from pharmacysalesreturn_details where locationcode='".$locationcode."' and patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='$itemcode' and batchnumber='$batchnumber' and docnumber='".$docnumber."' and salseautonumber='".$salseautonumber."'";
$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numbr=mysqli_num_rows($exec72);
//echo $numbr;
while($res72 = mysqli_fetch_array($exec72))
{
$avaquantity1=$res72['quantity'];
$totalavaquantity1=$totalavaquantity1+$avaquantity1;
}
$resquantity=$quantity - $totalavaquantity1;
//echo $resquantity;


$nno=$nno+1;
	
	}	
	//echo $nno;
			$query61 = "select * from pharmacysales_details where locationcode='".$locationcode."' and patientcode = '$patientcode' and visitcode = '$visitcode' and ipdocno='$docnumber'";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num=mysqli_num_rows($exec61);
//echo $num;
while($res61 = mysqli_fetch_array($exec61))
{
$totalavaquantity=0;
$itemname =$res61["itemname"];
$itemcode=$res61["itemcode"];
$batchnumber=$res61["batchnumber"];
$quantity=$res61["quantity"];
$rate=$res61["rate"];
 $salseautonumber=$res61["auto_number"];
  $getstorecode=$res61["store"];
$query62 = "select * from pharmacysalesreturn_details where locationcode='".$locationcode."' and patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='$itemcode' and batchnumber='$batchnumber' and docnumber='".$docnumber."' and salseautonumber='".$salseautonumber."'";
$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numbr=mysqli_num_rows($exec62);
//echo $numbr;
while($res62 = mysqli_fetch_array($exec62))
{
$avaquantity=$res62['quantity'];
$totalavaquantity=$totalavaquantity+$avaquantity;
}
$resquantity=$quantity - $totalavaquantity;
$refundedquantity=$totalavaquantity;
$balanceqty=$quantity-$refundedquantity;
$sno=$sno+1;
$quantity=intval($quantity);
?>
  <tr>
  <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $itemcode; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $resquantity;?>','<?php echo $nno; ?>')"/></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname;?></div></td>
		<input type="hidden" name="med[]" value="<?php echo $itemname;?>">
		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $batchnumber;?></div></td>
			<input type="hidden" name="batch[]" value="<?php echo $batchnumber;?>">
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity;?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="returnquantity[]" id="returnquantity<?php echo $sno; ?>" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $resquantity;?>','<?php echo $nno; ?>')"size="7"></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refundedquantity;?></div></td>
			<input type="hidden" name="quantity[]" value="<?php echo $resquantity;?>">
		   <td class="bodytext31" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly value="<?php echo $balanceqty; ?>"></td>
         <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $rate;?><input type="hidden" name="rate[]" id="rate<?php echo $sno; ?>" value="<?php echo $rate;?>"></div></td>
		 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" class="bal" name="amount[]" id="amount<?php echo $sno; ?>" size="7" readonly></div></td>
		 <input type="hidden" name="docnumber[]" value="<?php echo $docnumber;?>">
           <input type="hidden" name="salseautonumber[]" value="<?php echo $salseautonumber;?>">
           <input type="hidden" name="getstorecode[]" value="<?php echo $getstorecode; ?>"  readonly/>
		
						</tr>
			<?php 
		}
		
			
		?>
			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Total Refund</strong></td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"><input type="text" name="totalamt" id="totalamt" size="7" class="bal"></td>
         
             </tr>
           
          </tbody>
        </table>		</td>
      </tr>
       
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save" onClick="return check();" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
               </td>
              
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>