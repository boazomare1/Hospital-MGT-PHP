<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$timeonly = date("H:i:s");
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$titlestr = 'SALES BILL';

$docno = $_SESSION["docno"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	$locationname = $res["locationname"];
	$res12locationanum = $res["auto_number"];

$query3 = "select * from master_location where status = '' and locationname='$res12location'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
 $locationcode = $res3['locationcode'];
  
$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$patientname=$_REQUEST['customername'];
$dateonly = date("Y-m-d");
foreach($_POST['referalname'] as $key => $value)
{		
	$referalname=$_POST['referalname'][$key];
	$auto_number=$_POST['auto_number'][$key];
	foreach($_POST['ref'] as $check1)
	{
	
	$refund=$check1;
	if($refund == $auto_number)
	{
		$query61 = "select * from master_visitentry where visitcode = '$visitcode' and paymentstatus='completed' and auto_number='$auto_number'";
		$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numb=mysqli_num_rows($exec61);
		$res61 = mysqli_fetch_array($exec61);
		{
		$referalcode = $res61['consultingdoctorcode'];
		$patientcode=$res61['patientcode'];
		$patientname=$res61['patientfullname'];
		//$referalrate=$res61['doctorfees'];
		$referalrate=$_POST['refund'][$key];
		$status1='refund';		

		$query29="update master_visitentry set doctorfeesrefund='$referalrate', doctorfeesstatus ='torefund' where auto_number='$auto_number' and consultingdoctor='$referalname' and visitcode='$visitcode'";
		$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29);
		
		}
		break;
	}	
	}

}
  header("location:refundreferrallist.php?patientcode=$patientcode&&visitcode=$visitcode");  
  exit;
}

?>

<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>

<script>
  
function acknowledgevalid()
{
var chks = document.getElementsByName('ack[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
}
}

var chks1 = document.getElementsByName('ref[]');
hasChecked1 = false;
for(var j = 0; j < chks1.length; j++)
{
if(chks1[j].checked)
{
hasChecked1 = true;
}
}

if (hasChecked == false && hasChecked1 == false)
{
alert("Please either acknowledge/refund a sample  or click back button on the browser to exit sample collection");
return false;
}
for(n=1;n<10;n++)
	{
if(document.getElementById("status"+n+"").value == 'notcompleted')
{
if(document.getElementById("remarks"+n+"").value == '')
{
alert("Please Enter Remarks");
document.getElementById("remarks"+n+"").focus();
return false;
}
}
}

return true;
}

function checkboxcheck(varserialnumber)
{

var varserialnumber = varserialnumber;

if(document.getElementById("ack"+varserialnumber+"").checked == true)
{

document.getElementById("ref"+varserialnumber+"").disabled = true;
}
else
{
document.getElementById("ref"+varserialnumber+"").disabled = false;
}
}

function checkboxcheck1(varserialnumber1)
{

var varserialnumber1 = varserialnumber1;

if(document.getElementById("ref"+varserialnumber1+"").checked == true)
{

document.getElementById("ack"+varserialnumber1+"").disabled = true;
}
else
{
document.getElementById("ack"+varserialnumber1+"").disabled = false;
}
}

function funcOnLoadBodyFunctionCall()
{
funcremarkshide();

var varbilltype = document.getElementById("billtype").value
if(varbilltype =='PAY LATER')
{
for(i=1;i<=100;i++)
{
//alert('hi');
document.getElementById("ref"+i+"").disabled = true;
}
}
}

</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];

$query20 = "select * from master_triage where patientcode = '$patientcode' and visitcode='$visitcode'";
$exec20=mysqli_query($GLOBALS["___mysqli_ston"], $query20);
$res20=mysqli_fetch_array($exec20);
$res20consultingdoctor=$res20['consultingdoctor'];


?>
</head>
<script>
function funcPrintBill()
 {
var patientcode;
patientcode = document.getElementById("customercode").value; 
var visitcode;
visitcode = document.getElementById("visitcode").value; 
var docnumber;
docnumber = document.getElementById("docnumber").value; 
var popWin; 
popWin = window.open("print_labtest_label.php?patientcode="+patientcode+"&&visitcode="+visitcode+"&&billnumber="+docnumber,"OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
 }
 

function funcremarksshow(k)
{
var k = k;
//alert(k);
  if (document.getElementById("remarks1"+k+"") != null) 
     {
	 document.getElementById("remarks1"+k+"").style.display = 'none';
	}
	if (document.getElementById("remarks1"+k+"") != null) 
	  {
	  document.getElementById("remarks1"+k+"").style.display = '';
	 }
	 
  if (document.getElementById("remarks2") != null) 
     {
	 document.getElementById("remarks2").style.display = 'none';
	}
	if (document.getElementById("remarks2") != null) 
	  {
	  document.getElementById("remarks2").style.display = '';
	 }
	 
	
	
}

function funcremarkshide()
{		

 if (document.getElementById("remarks2") != null) 
	{
	document.getElementById("remarks2").style.display = 'none';
	}	
	for(i=1;i<10;i++)
	{
	if (document.getElementById("remarks1"+i+"") != null) 
	{
	document.getElementById("remarks1"+i+"").style.display = 'none';
	}
	}	
		
}

function funcstatus(j)
{
var j = j;
if(document.getElementById("status"+j+"").value == 'notcompleted')
{
funcremarksshow(j);
}
if(document.getElementById("status"+j+"").value == 'completed')
{
funcremarkshide();
}
}

function BalCalc(id)
{
	var fees = document.getElementById("fees"+id).value;
	var refund = document.getElementById("refund"+id).value;
	if(refund == "") { refund = '0.00'; }
	
	if(parseFloat(refund) > parseFloat(fees))
	{
		alert("Refund greaterthan actual amount");
		document.getElementById("refund"+id).value = "";
		document.getElementById("bal"+id).value = "";
		return false;
	}
	var Bal = parseFloat(fees) - parseFloat(refund);
	var Bal = Bal.toFixed(2);
	document.getElementById("bal"+id).value = Bal;
}
</script>  

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="refundconsultreferral.php" onKeyDown="return disableEnterKey(event)" onSubmit="funcPrintBill1();">
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
	  <td class="bodytext3" width="25%" align="left" valign="middle" bgcolor="#ecf0f5">
				<input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>                  </td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="27%" bgcolor="#ecf0f5" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>				</td>
               
              
              </tr>
			 
		
			  <tr>

			    <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td class="bodytext3" width="25%" align="left" valign="middle" >
			<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>                  </td>
                 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td align="left" class="bodytext3" valign="top" >
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    
			  </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input name="patientage" type ="hidden" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="5" readonly><?php echo $patientage; ?>
				&
				<input name="patientgender" type="hidden" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>			        </td>
                <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>				  </tr>
			    
				  <tr>
				  <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
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
              <td width="28%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Referral Name</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Referral Amount</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Refund</strong></div></td>
				<td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Balance</strong></div></td>
			      </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$ssno=0;
			$totalamount=0;			
			$query61 = "select * from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode' and paymentstatus='completed' and recordstatus=''";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb=mysqli_num_rows($exec61);
			while($res61 = mysqli_fetch_array($exec61))
			{
			$referalname =$res61["consultingdoctor"];
			$billtype = $res61["billtype"];
			$auto_number = $res61['auto_number'];
			$doctorfees = $res61['doctorfees'];
			$itemcode=$ssno;
			$ssno=$ssno + 1;
			
			$sno = $sno + 1;
			?>
  <tr>
  <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $auto_number; ?>"/></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $referalname;?></div></td>
		<input type="hidden" name="referalname[]" value="<?php echo $referalname;?>">
		<input type="hidden" name="auto_number[]" value="<?php echo $auto_number; ?>">	
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="fees[]" id="fees<?php echo $sno; ?>" value="<?php echo $doctorfees;?>" style="text-align:right;" readonly size="10" /></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="refund[]" id="refund<?php echo $sno; ?>" value="" onKeyUp="return BalCalc('<?php echo $sno; ?>');" style="text-align:right; border:solid 1px #0000FF;" size="10" /></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="bal[]" id="bal<?php echo $sno; ?>" value="<?php echo $doctorfees;?>" style="text-align:right;" readonly size="10" /></div></td> 		
		</tr>
			<?php 
		
			}
		?>
           
          </tbody>
        </table>		</td>
      </tr>
      
      
      
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" />
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
