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
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	//get location name and code
	$totalamount1=0;
	$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
	$locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
	//get location ends here
	$paynowbillprefix = 'IPCr-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_creditnote order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPCr-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'IPCr-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

	$billdate=$_REQUEST['billdate'];
	
	$paymentmode = $_REQUEST['billtype'];
		$patientfullname = $_REQUEST['customername'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$billtype = $_REQUEST['billtypes'];
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender'];
		$account = $_REQUEST['account'];
		$bedcharges = $_REQUEST['bed'];
		$nursingcharges = $_REQUEST['nursing'];
		$rmocharges = $_REQUEST['rmo'];
		$lab = $_REQUEST['lab'];
		$radiology = $_REQUEST['radiology'];
		$service = $_REQUEST['service'];
		$others = $_REQUEST['others'];
		$remarks = $_REQUEST['remarks'];
		$totalamount = $_REQUEST['total'];
		$fxrate = $_REQUEST['fxrate'];
		$patienttype1 = $_REQUEST['patienttype1'];
		
		$accountnameano= $_REQUEST['accountnameano'];
		$accountnameid= $_REQUEST['accountnameid'];
		$subtypeano = $_REQUEST['subtypeano'];
		$subtype = $_REQUEST['subtype'];
		
	 $oporip=substr($visitcode,-1);
		if($oporip=='P')
		{
			 $oporip="IP";
		}
		else
		{
			 $oporip="OP";
		}
		
	for($i=1;$i<8;$i++)	
			{
			if($i == 1)
			{
			$charge="Bed Charges";
			$rate = $bedcharges;
			
				}
			if($i == 2)
			{
			$charge="Nursing Charges";
			$rate = $nursingcharges;
			}
			if($i == 3)
			{
			$charge="RMO Charges";
			$rate = $rmocharges;
		
			}
			if($i == 4)
			{
			$charge="Lab";
			$rate = $lab;
		
			}
			if($i == 5)
			{
			$charge="Radiology";
			$rate = $radiology;
		
			}
			if($i == 6)
			{
			$charge="Service";
			$rate = $service;
		
			}
			if($i == 7)
			{
			$charge="Others";
			$rate = $others;
		
			}
			if($rate != '')
		{
		$totalamount1 = $totalamount1 + $rate;
		$fxamount1 = $rate*$fxrate;
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ip_creditnotebrief(docno,patientcode,patientname,patientvisitcode,description,rate,billtype,accountname,consultationdate,paymentstatus,consultationtime,username,ipaddress,locationname,locationcode,fxrate,fxamount)values('$billnumbercode','$patientcode','$patientfullname','$visitcode','$charge','$rate','$billtype','$account','$billdate','pending','$timeonly','$username','$ipaddress','".$locationnameget."','".$locationcodeget."','$fxrate','$fxamount1')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		}
		
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into ip_creditnote(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,remarks,locationname,locationcode,accountnameano,accountnameid,subtypeano,patienttype)values('$billnumbercode','$patientfullname','$patientcode','$visitcode','$totalamount','$billdate','$account','$subtype','$remarks','".$locationnameget."','".$locationcodeget."','$accountnameano','$accountnameid','$subtypeano','$oporip')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$fxamount = $totalamount*$fxrate;
		$query83="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,receivableamount,doctorname,locationname,locationcode,accountnameano,accountnameid,subtypeano,username,transactiontime,fxamount,fxrate,exchrate,accountcode)values('$patientfullname',
	          '$patientcode','$visitcode','$billdate','$account','$billnumbercode','$ipaddress','$companyanum','$companyname','$financialyear','paylatercredit','$patienttype1','$subtype','$totalamount','$fxamount','$doctorname','".$locationnameget."','".$locationcodeget."','$accountnameano','$accountnameid','$subtypeano','$username','$timeonly','$fxamount','$fxrate','$fxrate','$accountnameid')";
	    $exec83=mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die("error in query83".mysqli_error($GLOBALS["___mysqli_ston"]));		  
		
		header("location:creditnotelist.php?billno=".$billnumbercode."&&visitcode=".$visitcode."&&patientcode=".$patientcode."");
		exit;

}


if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}


//include ("autocompletebuild_accounts1.php");

?>

<?php
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];
 $patientname = $execlab['customerfullname'];
 $billtype = $execlab['billtype'];

$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$currency=$execsubtype['currency'];
$fxrate=$execsubtype['fxrate'];
$patientplan=$execlab['planname'];
$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
$execplan=mysqli_fetch_array($queryplan);
$patientplan1=$execplan['planname'];

$query52 = "select * from billing_ip where patientcode='$patientcode' and visitcode='$visitcode'";
$exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num52 = mysqli_num_rows($exec52);
if($num52 != 0)
{
$res52 = mysqli_fetch_array($exec52);
$finalbillamount = $res52['totalamount'];
}
else
{
$query53 = "select * from billing_ipcreditapproved where patientcode='$patientcode' and visitcode='$visitcode'";
$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res53 = mysqli_fetch_array($exec53);
$finalbillamount = $res53['totalamount'];
}

?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];
$patientaccountid=$execlab2['id'];
$queryy53 = "select locationname,locationcode from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$execy53 = mysqli_query($GLOBALS["___mysqli_ston"], $queryy53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$row=mysqli_num_rows($execy53);
if($row==0)
{
	 $queryy53 = "select locationname,locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$execy53 = mysqli_query($GLOBALS["___mysqli_ston"], $queryy53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
$resy53 = mysqli_fetch_array($execy53);
 $locationnameget = $resy53['locationname'];
 $locationcodeget = $resy53['locationcode'];


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
	$paynowbillprefix = 'IPCr-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_creditnote order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPCr-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'IPCr-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}?>

<script language="javascript">



<?php
if ($delbillst != 'billedit') // Not in edit mode or other mode.
{
?>
	//Function call from billnumber onBlur and Save button click.
	function billvalidation()
	{
		billnovalidation1();
	}
<?php
}
?>

function funcOnLoadBodyFunctionCall()
{


 //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.


funcCustomerDropDownSearch7();		
		
		}


</script>
<script type="text/javascript" src="js/autocomplete_accounts1.js"></script>
<script type="text/javascript" src="js/autosuggest3accounts.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("accountname"), new StateSuggestions()); 
}
</script>


<script language="javascript">

function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}
function validcheck()
{

var total = document.getElementById("total").value;
var finalbillamount = document.getElementById("finalbillamount").value;
if(parseFloat(total) > parseFloat(finalbillamount))
{
alert("Please Check the amount entered");
return false;
}
if(confirm("Do You Want To Save The Record?")==false){return false;}
}

function totalcalc()
{
var bed = document.getElementById("bed").value;
if(bed == '')
{
bed = 0;
}
var nursing = document.getElementById("nursing").value;
if(nursing == '')
{
nursing = 0;
}
var rmo = document.getElementById("rmo").value;
if(rmo == '')
{
rmo = 0;
}
var lab = document.getElementById("lab").value;
if(lab == '')
{
lab = 0;
}
var radiology = document.getElementById("radiology").value;
if(radiology == '')
{
radiology = 0;
}
var service = document.getElementById("service").value;
if(service == '')
{
service = 0;
}
var others = document.getElementById("others").value;
if(others == '')
{
others = 0;
}

var total = parseInt(bed)+parseInt(nursing)+parseInt(rmo)+parseInt(lab)+parseInt(radiology)+parseInt(service)+parseInt(others);
document.getElementById("total").value = total.toFixed(2);
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

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="creditnote.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
        <td width="792"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext32"><strong>Patient Details</strong></td>
                 <td colspan="2" bgcolor="#ecf0f5" class="bodytext32"><strong>Loation &nbsp;</strong><?php echo $locationnameget?></td>
                <input type="hidden" value="<?php echo $locationnameget?>" name="locationnameget">
                <input type="hidden" value="<?php echo $locationcodeget?>" name="locationcodeget">
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			
				<tr>
                <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientname; ?>
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" style="border: 1px solid #001E6A;" size="45"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<strong>Patientcode</strong></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input type="hidden" name="patienttype1" id="patienttype1" value="<?php echo $patienttype1; ?>">
				<input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?></td>
				</tr>       
               
			   <tr>
			    <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visitcode</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />	<?php echo $visitcode; ?>
                <input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $patientsubtype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                <input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                </td>			
			   	  <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="hidden" name="account" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />		
                <input type="hidden" name="accountnameano" id="accountnameano" value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                <input type="hidden" name="accountnameid" id="accountnameid" value="<?php echo $patientaccountid; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
			<?php echo $patientaccount1; ?>	</td>	
 </tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong> Date</strong></td>
				<td class="bodytext3"><input name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>			<img src="images2/cal.gif" onClick="javascript:NewCssCal('billdate')" style="cursor:pointer"/> 	</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
				<td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<?php echo $billnumbercode; ?>							</td>
				  </tr>
                  				
				 	 <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong> Currency/Fxrate</strong></td>
				<td class="bodytext3">
                <input type="hidden" name="currency" id="currency" value="<?php echo $currency; ?>" readonly/>
				<input type="hidden" name="fxrate" id="fxrate" value="<?php echo $fxrate; ?>" readonly/>
				<?php echo $currency." / ".number_format($fxrate,2); ?>				</td>	
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
				   <td colspan="13" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong> Credit Note </strong> </span></td>
		        </tr>
				<tr>
				 <td width="24%" align="center" valign="middle" class="bodytext3">Bed</td>
				  <td width="24%" align="left" valign="middle" class="bodytext3"><input type="text" name="bed" id="bed" size="8" autocomplete='off' onKeyUp="return totalcalc()"></td>
				  <td width="12%" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="40%" align="left" valign="middle" class="bodytext3"><input name="accountname" type="hidden" id="accountname" value="" size="32" autocomplete="off"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Nursing</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="nursing" id="nursing" autocomplete='off' size="8" onKeyUp="return totalcalc()"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">RMO</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="rmo" id="rmo" size="8" autocomplete='off' onKeyUp="return totalcalc()"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Lab</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="lab" id="lab" size="8" autocomplete='off' onKeyUp="return totalcalc()"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Radiology</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="radiology" id="radiology" autocomplete='off' size="8" onKeyUp="return totalcalc()"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Service</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="service" id="service" autocomplete='off' size="8" onKeyUp="return totalcalc()"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Others</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="others" id="others" size="8" autocomplete='off' onKeyUp="return totalcalc()">
				  <input type="hidden" name="total" id="total">
				   <input type="hidden" name="finalbillamount" id="finalbillamount" value="<?php echo $finalbillamount; ?>"></td>
				</tr>
			<tr>
		<td>&nbsp;		</td>
		</tr>
		<tr>
				 <td align="center" valign="middle" class="bodytext3">Remarks</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><textarea name="remarks" id="remarks"></textarea></td>
				</tr>
		       </tbody>
        </table>		</td></tr>
		
		<tr>
		<td>&nbsp;		</td>
		</tr>
             
               <tr>
	  <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
	   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
	    <input name="Submit2223" type="submit" value="Save" accesskey="b" class="button" style="border: 1px solid #001E6A"/>		</td>
	  </tr>
              
            </tbody>
        </table>
	  </td>
	</tr>
     
  </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
