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
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$recorddate = date('Y-m-d');



if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }

if ($frm1submit1 == 'frm1submit1')
{
/*$paynowbillprefix = 'ICF-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipconsentform order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ICF-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'ICF-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
*/
	    $billdate=$_REQUEST['billdate'];
	    $paymentmode = $_REQUEST['billtype'];
		$patientfullname = $_REQUEST['customername'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$locationcode = $_REQUEST['locationcode'];
		$billtype = $_REQUEST['billtypes'];
		$account = $_REQUEST['account'];
		$surgeon = $_REQUEST['surgeon'];
	    $anaesthetist = $_REQUEST['anaesthetist'];
		$doctor = $_REQUEST['doctor'];
		
		$query7 = "select * from ipconsentform where patientcode='$patientcode' and visitcode='$visitcode' ";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums7 = mysqli_num_rows($exec7);
	
	if($nums7 == '0')
	{
		if($patientcode!='' && $visitcode!='')
		{
		$consentform=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ipconsentform(docno,patientcode,patientname,visitcode,billtype,accountname,recorddate,recordtime,username,ipaddress,surgeon,anaesthetist,doctor,locationname,locationcode)values('$billnumbercode','$patientcode','$patientfullname','$visitcode','$billtype','$account','$dateonly','$timeonly','$username','$ipaddress','$surgeon','$anaesthetist','$doctor','$locationname','$locationcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		header("Location:otpatients.php");
		}
	}
	else
	     {
		   if($patientcode!='' && $visitcode!='')
		    {
		   	$query6 = "update ipconsentform set surgeon='$surgeon', anaesthetist='$anaesthetist',doctor='$doctor',username='$username',ipaddress='$ipaddress' where patientcode='$patientcode' and visitcode='$visitcode' ";
			
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			header("Location:otpatients.php");
		    }
		 }	
		
}

if($visitcode!='' && $patientcode!='')
{
	
	$query8 = "select * from ipconsentform where patientcode='$patientcode' and visitcode='$visitcode' ";
	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums8 = mysqli_num_rows($exec8);
	if($nums8 > 0)
	{
	$res8 = mysqli_fetch_array($exec8);
	$res8billdate=$res8['billdate'];
	$res8paymentmode = $res8['billtype'];
	$res8patientfullname = $res8['customername'];
	$res8patientcode = $res8['patientcode'];
	$res8visitcode = $res8['visitcode'];
	$res8locationcode = $res8['locationcode'];
	$res8billtype = $res8['billtypes'];
	$res8account = $res8['accountname'];
	$res8surgeon = $res8['surgeon'];
	$res8anaesthetist = $res8['anaesthetist'];
	$res8doctor = $res8['doctor'];

    }
	else
	{
	$res8billdate= '';
	$res8paymentmode = '';
	$res8patientfullname = '';
	$res8patientcode = '';
	$res8visitcode = '';
	$res8billtype = '';
	$res8account = '';
	$res8surgeon = '';
	$res8anaesthetist = '';
	$res8doctor = '';
	}
}

if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
$locationcode = $_REQUEST["locationcode"];
$docnumber=$_REQUEST["docnumber"];
}

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}

?>

<?php
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patientage=$execlab['age'];
$patientgender=$execlab['gender'];
$patientname = $execlab['customerfullname'];
$billtype = $execlab['billtype'];
$patienttype=$execlab['maintype'];
$patientaccount=$execlab['accountname'];
$dateofbirth=$execlab['dateofbirth'];
$locationcode = $execlab['locationcode'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];

$query19=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' ");
$exec19=mysqli_fetch_array($query19);
$res19ward=$exec19['ward'];
$res19bed=$exec19['bed'];

$query30=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_ward where auto_number='$res19ward' ");
$exec30=mysqli_fetch_array($query30);
$res30ward=$exec30['ward'];

$query31 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_bed where auto_number='$res19bed' ");
$exec31=mysqli_fetch_array($query31);
$res31bed=$exec31['bed'];

$query66 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$ipdate = $res66['consultationdate'];
?>

<?php
/*$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
	$paynowbillprefix = 'ICF-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipconsentform order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ICF-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'ICF-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}*/
?>

<script language="javascript">

var grandtotal=0;
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
if(document.form1.nhifclaim.value == '0.00')
{
alert("NHIF not applicable for this patient");
document.getElementById("nhifclaim").focus();
return false;
}
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        alert("Please enter a whole number");
		return false;
    }
    return true;
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
.bal1
{
border-style:none;
background:none;
text-align:center;
font-weight:bold;
}
.bal
{
border-style:none;
background:none;
text-align:right;
font-size: 30px;
	font-weight: bold;
	FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style2 {COLOR: #3B3B3C; FONT-FAMILY: Tahoma; font-size: 11px;}
</style>

<script src="js/datetimepicker_css.js"></script>
</head>

<body>	
<form name="form1" id="frmsales" method="post" action="ipconsentform.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
    <td width="99%" valign="top"><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1114"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="12" bgcolor="#ecf0f5" class="bodytext32"><strong>Patient Details</strong></td>
			 </tr>
			 <!--<tr>
                <td colspan="14" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>-->
		<tr>
                <td colspan="12" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			
				<tr>
                <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient * </strong>  </span></td>
                <td width="24%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientname; ?></td>
                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patientcode</strong></td>
                <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?></td>
                  
                <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visitcode</strong></td>
                <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" /><?php echo $visitcode; ?></td>
				
				<td width="6%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Date</strong></td>
				<td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> </strong>
				  <input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                  <?php echo $dateonly; ?> </td>
				<!--<td width="6%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No&nbsp;&nbsp;</strong></td>
				<td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> </strong><?php echo $billnumbercode; ?>
                  <input type="hidden" name="billno2" id="billno2" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/></td>-->
				</tr>       
               
			    <tr>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Age &amp; <span class="style1">Gender</span></strong></td>
			      <td align="left" valign="middle" class="bodytext3"><?php echo $patientage; ?>
                    <input type="hidden" name="age" id="age" value="<?php echo $age; ?>" style="border: 1px solid #001E6A;" size="45"> 
                    &amp; <?php echo $patientgender; ?></td>
			      <td align="left" valign="middle" class="bodytext3"><strong>Account</strong></td>
			      <td align="left" valign="middle" class="bodytext3"><input type="hidden" name="account" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />
                    <input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
                    <?php echo $patientaccount1; ?></td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1"><strong>Ward/Bed</strong></td>
			      <td align="left" valign="top" class="bodytext3"><?php echo $res30ward; ?>/<?php echo $res31bed; ?></td>
					
			      <td align="left" valign="top" class="style1">&nbsp;</td>
			      <td align="left" valign="top" class="style1">&nbsp;</td>
			      <td width="0%" align="left" valign="top" class="style1">&nbsp;</td>
			    </tr>
			    
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong>DOB</strong></td>
				             <td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                               <?php echo $dateofbirth; ?> </td>
							 <td align="left" valign="middle" class="bodytext3"><strong>Location</strong></td>
							 <?php
		         $query131 = "select * from master_location where locationcode = '$locationcode'";
         	     $exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
          		 $res131 = mysqli_fetch_array($exec131);
          		 $locationname = $res131['locationname'];
			?>
			      <td align="left" valign="middle" class="bodytext3"><input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" /><?php echo $locationname; ?>
				  <input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />
                  <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>" ></td>        
				  <td class="bodytext3">&nbsp;</td>
                  <td class="bodytext3">&nbsp;</td>
                 <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				<td colspan="4" class="bodytext3">&nbsp;</td>
				  </tr>
			<tr>
				<td colspan="12" class="bodytext32"><strong>&nbsp;</strong></td>
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
				   <td colspan="8" align="left" valign="middle"   class="bodytext3"><span class="bodytext32"><strong>CONSENT FORM </strong></span></td>
	              </tr>
				  
				<tr>
				 <td colspan="8" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">Surgeon</td>
				  <td colspan="6" align="left" valign="middle" class="bodytext3"><strong>
				    <input name="surgeon" id="surgeon" value="<?php echo $res8surgeon; ?>" onKeyDown="return disableEnterKey()" size="20">
				  </strong></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">Anaesthetist</td>
				  <td colspan="6" align="left" valign="middle" class="bodytext3"><strong>
				    <input name="anaesthetist" id="anaesthetist" value="<?php echo $res8anaesthetist; ?>" onKeyDown="return disableEnterKey()" size="20">
				  </strong></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3"><span class="style2">Doctor</span></td>
				  <td colspan="6" align="left" valign="middle" class="bodytext3"><strong>
                  <input name="doctor" id="doctor" value="<?php echo $res8doctor; ?>" onKeyDown="return disableEnterKey()" size="20">
                  </strong></td>
				  </tr>
				
				
				<tr>
				 <td colspan="8" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  </tr>
				
				<tr>
				  <td width="25" align="center" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="144" align="center" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="245" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                    <input name="Submit2223" type="submit" value="Save" accesskey="b" class="button"/></td>
				  <td width="25" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="122" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="228" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				</tr>
		       </tbody>
        </table>		</td></tr>
		
		<tr>
		 <td width="1114" class="bodytext31" align="left">User Name: &nbsp;&nbsp;
		   <input type="hidden" name="username" id="username" value="" class="bal1"><strong><?php echo strtoupper($username); ?></strong></td>		
		</tr>
             
               <tr>
	  <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
	  </tr>
              
            </tbody>
        </table>
	  </td>
		</tr>
     
    </table>

</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>