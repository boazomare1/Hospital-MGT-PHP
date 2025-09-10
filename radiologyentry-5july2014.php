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

$errmsg = "";

if (isset($_REQUEST["errmsg"])) { $errmsg = $_REQUEST["errmsg"]; } else { $errmsg = ""; }

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Saved Successfully.";
}
if ($st == 'failed')
{
		$errmsg = "Failed to save";
}

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$patientname=$_REQUEST['customername'];
$docnumber=$_REQUEST['docnumber'];
$billtype = $_REQUEST['billtype'];
$account = $_REQUEST['account'];

$dateonly = date("Y-m-d");
foreach($_POST['radiology'] as $key => $value)
		{
		$radiologyname=$_POST['radiology'][$key];
		$itemcode=$_POST['code'][$key];
		if(isset($_POST['ack']))
		{
		$status='completed';
		}
		else
		{
		$status='pending';
		}
	foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow == $itemcode)
		{
		$status='completed';
		$status2='norefund';
		break;
		}
		else
		{
		$status='pending';
		}
	}
	
	foreach($_POST['ref'] as $check1)
	{
	$refund=$check1;
	if($refund == $itemcode)
	{
	$status1='refund';
	$status2='refund';
	$status='completed';
	break;
	}
	else
	{
	$status1='norefund';
	}
	}
	
if($radiologyname != "")
   {
       $query26="update resultentry_radiology set refund='$status1' ";
   $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   
mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set resultentry='$status',radiologyrefund='$status1',docnumber='$docnumber' where patientvisitcode='$visitcode' and radiologyitemname='$radiologyname'");
   
   $query42="select * from master_visitentry where visitcode='$visitcode' and itemrefund='refund'";
   $exec42=mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   $num42=mysqli_num_rows($exec42);
   if($num42 > 0)
   {
   $query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   }
   else
   {
    $query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set itemrefund='$status2' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   }
 
  }

}
    header("location:radiologyentrylist.php");
    exit();
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
function disableafterclick (varserialnumber3)
 {
var varserialnumber3 = varserialnumber3;
document.getElementById("Class"+varserialnumber3+"").disabled = true;
}

function updateTextField(varserialnumber)
 {
	//var e = document.getElementById('Class');
	//var strText = e.options[e.selectedIndex].text;
	//var strText = e.options[e.selectedIndex].value;
	 //document.getElementById("editor1").disabled="disabled"
    var z = document.getElementById("editor1"+varserialnumber+"").id;	 
	
	//z.value+="blah test 123";
	
	var varserialnumber = varserialnumber;
	var x = document.getElementById("Class"+varserialnumber+"").selectedIndex;
	var y = document.getElementById("Class"+varserialnumber+"").options;
	//alert("Index: " + y[x].index + " is " + y[x].text);
	//document.getElementById('editor1').value= strText; 
	// alert(strText); 
    //document.getElementById('editor1').value= strText; 
   //alert(z);
	//self.location='radiologyentry.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&cat=' + y[x].index+'&&sno='+varserialnumber +'&&tid='+z ;
 }	
 
 function toggleTextArea() 
 {
 		CKEDITOR.appendTo( 'tdata',
				null,
				'<p></p>'
			);
}	

 

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
return true;
}

function makeDisable1(varserialnumber3)
 {
 var varserialnumber3 = varserialnumber3;
 
 if(document.getElementById("Class"+varserialnumber3+"").checked == true)
{
var x = document.getElementById("Class"+varserialnumber3+"");
x.disabled=true
}


}
	
function checkboxcheck(varserialnumber)
{

var varserialnumber = varserialnumber;

if(document.getElementById("ack"+varserialnumber+"").checked == true)
{
document.getElementById("Class"+varserialnumber+"").style.visibility = 'visible';

document.getElementById("ref"+varserialnumber+"").disabled = true;
}
else
{
document.getElementById("Class"+varserialnumber+"").style.visibility = 'hidden';
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
var varbilltype = document.getElementById("billtype").value;
if(varbilltype == 'PAY LATER')
{
for(i=1;i<=100;i++)
{
document.getElementById("ref"+i+"").disabled = true;
}
}
}
</script>
<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>


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

 select { visibility:hidden; }

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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

.ckeditor {display:none;}
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
$billtype = $res78['billtype'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'RRE-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from resultentry_radiology where patientcode <> 'walkin' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='RRE-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'RRE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall(); ">
<form name="frmsales" id="frmsales" method="post" action="radiologyentry.php" onKeyDown="return disableEnterKey(event)" enctype="multipart/form-data">
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
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="1324" border="0" cellspacing="0" cellpadding="0">
    <tr>
 <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td></tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  * </strong></td>
	  <td width="26%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
				<input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>
                  </td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="28%" bgcolor="#ecf0f5" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
               <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>
                <td width="20%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $billnumbercode; ?>
                  </td>
               
              </tr>
			 
		
			  <tr>

			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="26%" align="left" valign="middle" class="bodytext3">
			<input name="visitcode" type="hidden" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
                  </td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3" >
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
			        </td>
                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>
				<input type="hidden" name="billtype" id="billtype" value="<?php echo $billtype; ?>">
				  </tr>
			  
			   
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
              
				  </tr>
            </tbody>
        </table>
		
		</td>
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="95%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
              <td width="15%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acknowledge</strong></div></td>
				<td width="48%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Upload</strong></div></td>
					<td width="24%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>
			      </tr>
				  
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;			
$query61 = "select * from consultation_radiology where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and resultentry='pending' and paymentstatus='completed' group by radiologyitemname";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec61);
while($res61 = mysqli_fetch_array($exec61))
{
$radiologyname =$res61["radiologyitemname"];
$billtype = $res61['billtype'];
$query68="select * from master_radiology where itemname='$radiologyname'";
$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);
$res68=mysqli_fetch_array($exec68);
$itemcode=$res68['itemcode'];
$sno = $sno + 1;
?>


  <tr>
		<td height="40"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $radiologyname;?></div></td>
		<input type="hidden" name="radiology[]" value="<?php echo $radiologyname; ?>">
		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">
		
		   <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" id="ack<?php echo $sno; ?>" name="ack[]" value="<?php echo $itemcode; ?>" onClick="return checkboxcheck('<?php echo $sno; ?>'); return makeDisable('<?php echo $sno; ?>');"/></div></td>
	
	<td class="bodytext31" valign="center"  align="left"><div align="center">
			<select name="Class[]" id="Class<?php echo $sno; ?>" onChange="if (this.value) window.open(this.value, '_blank'); disableafterclick(<?php echo $sno; ?>);" >
				<option value = '0'>-Select Template-</option>  
				  <?php
				$query5 = "select * from master_radiologytemplate";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5templatename = $res5["templatename"];
				?>
                   <option value="appendto.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&tid=<?php echo $res5anum; ?>&&itemcode=<?php echo $itemcode; ?>&&docnum=<?php echo $billnumbercode; ?>"><?php echo $res5templatename; ?></option>
                    <?php
				}
				?>
			
				
<!--			    <option value = '0'>-Select Template-</option> 
				<option value = '1'>Template1</option> 
				<option value = '2'>Template2</option> 
				<option value = '3'>Template3</option> 
				<option value = '4'>Template4</option>
				<option value = '4'>Template5</option> 
-->			</select>
		</div>		
		  <div id="tdata">
			  
			   </div>
			   	      </td>
		<td class="bodytext31" valign="center"  align="left"><div align="center">
			<input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>"value="<?php echo $itemcode; ?>" onClick="return checkboxcheck1('<?php echo $sno; ?>')"/></div></td>
				</tr>
				<tr>
				<?php 
			    $editorid = $_REQUEST['tid'];
				$templatecode = $_REQUEST['cat'];
                $templatesno = $_REQUEST['sno'];
 				$query19 = "select * from master_radiologytemplate where auto_number='$templatecode' ";
				$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numb=mysqli_num_rows($exec19);
                $res19 = mysqli_fetch_array($exec19);
				$templatedata= $res19['templatedata']; 
			  ?>
			   
               <td colspan="3">
			 
			  </td>
			 
               </tr>
			<?php 
		
			}
		?>
			  
          </tbody>
        </table>
		
			</td>
      </tr>
      
      
      
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
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



