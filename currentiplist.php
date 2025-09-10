<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Current IP List</title>
<!-- Modern CSS -->
<link href="css/currentiplist-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="css/three.css" rel="stylesheet" type="text/css">
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/currentiplist-modern.js?v=<?php echo time(); ?>"></script>
</head>

<body>

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<?php
<!-- Inline styles moved to external CSS file -->
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<!-- Inline JavaScript moved to external JS file -->
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}
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
function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}
}
function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}
function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style1 {font-weight: bold}
</style>
</head>
<script src="js/datetimepicker_css.js"></script>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" ><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" ><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" ><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	<tr>
    <td width="">
	<form name="form1" id="form1" method="post" action="currentiplist.php">
		<table width="30%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2"  class="bodytext3"><strong> IP List</strong></td>
				<tr>
					<td width="" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
					<td width="" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
					<select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
					<option value="All">All</option>
					<?php
					$query1 = "select * from master_location where status=''  order by locationname";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$loccode=array();
					while ($res1 = mysqli_fetch_array($exec1))
					{
					$locationname = $res1["locationname"];
					$locationcode = $res1["locationcode"];
					?>
					<option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
					<?php
					} 
					?>
					</select>
					</span></td>
				</tr>
				<tr>
					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
					<td colspan="" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
					<input  type="submit" value="Search" name="Submit" />
					<input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
				</tr>
			  </td>
			 </tr>
		   </tbody>
		</table>
	</form>
	</td>
   </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
		<tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="102%" align="left" border="0">
          <tbody>
             
	<?php
	if ($cbfrmflag1 == 'cbfrmflag1')
	{
	$colorloopcount=0;
	$sno=0;
	
	if($location=='All')
	{
	$pass_location = "locationcode !=''";
	}
	else
	{
	$pass_location = "locationcode ='$location'";
	}	

	$querynw1 = "select * from ip_bedallocation where paymentstatus = '' and creditapprovalstatus = '' and $pass_location";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
	$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resnw1=mysqli_num_rows($execnw1);

	?>
			<tr>
				<td colspan="9"  valign="middle" class="bodytext31"><strong>Current IP List </strong><label class="number"><<<?php echo $resnw1;?>>></label></td>
			</tr>
            <tr>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong> Location</strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong> Patient Name</strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong> Age </strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong> Gender </strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong> Reg. No. </strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong> Visit Code </strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong>IP Date </strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong>Kin Name </strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong>Kin Contact </strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong>Ward</strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong>Bed</strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong>SubType </strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong>Account </strong></div></td>
				<td width=""  align="left" valign="center"  class="bodytext31"><div align="left"><strong>Interm Amt </strong></div></td>
            </tr>
	
	
	<?php
			$colorloopcount1=0;
			$sno1=0;
		
	       $query11 = "select * from ip_bedallocation where paymentstatus = '' and creditapprovalstatus = '' and recordstatus <> 'discharged' and $pass_location order by locationcode ";
		   $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res1 = mysqli_fetch_array($exec11))
		   {
		   $patientname = $res1['patientname'];
		   $patientcode = $res1['patientcode'];
		   $locationcode = $res1['locationcode'];
		   $visitcode = $res1['visitcode'];
		   $ward = $res1['ward'];
		   $bed = $res1['bed'];
		   $recordstatus = $res1['recordstatus'];
		   if($recordstatus=='transfered'){
		   $query1 = "select * from ip_bedtransfer where visitcode='$visitcode' and $pass_location  order by auto_number desc ";
		   $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res1 = mysqli_fetch_array($exec1);
		   $ward = $res1['ward'];
		   $recordstatus = $res1['recordstatus'];
		    $locationcode = $res1['locationcode'];
		    $bed = $res1['bed'];
		   }
		   
			$query211 = "select * from master_location where locationcode='$locationcode' ";
			$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res211 = mysqli_fetch_array($exec211);
			$locationname = $res211['locationname'];

			$query21 = "select * from master_ward where auto_number='$ward' ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21);
			$wardname = $res21['ward'];
			
			$query210 = "select kinname,kincontactnumber from master_customer where customercode='$patientcode' ";
			$exec210 = mysqli_query($GLOBALS["___mysqli_ston"], $query210) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res210 = mysqli_fetch_array($exec210);
			$kincontactnumber = $res210['kincontactnumber'];
			$kinname = $res210['kinname'];
			
			$query221 = "select * from master_bed where auto_number='$bed' ";
			$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res221 = mysqli_fetch_array($exec221);
			$bedname = $res221['bed'];
		   
		  
		   $query2 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res2 = mysqli_fetch_array($exec2);
		   $registrationdate = $res2['registrationdate'];
		   $accountname = $res2['accountfullname'];
		   $subtype = $res2['subtype'];
		   $age = $res2['age'];
		   $gender = $res2['gender'];
			
			
			$query21 = "select * from master_subtype where auto_number='$subtype' ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21);
			$sybtype = $res21['subtype'];

			$query2 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$registrationdate = $res2['registrationdate'];
			
			
		
		    include ('ipcreditaccountreport3_ipcredit.php');
			if($recordstatus != 'discharged'){
			$colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = '';
			}
			
			?>
			<tr <?php echo $colorcode1; ?>>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno1 = $sno1 + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31" align="center"><div align="left"><?php echo $locationname; ?></div></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31" align="center"><div align="left"><?php echo $patientname; ?></div></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $age; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $registrationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $kinname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $kincontactnumber; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $wardname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $bedname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sybtype; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $accountname; ?></div></td>
				<td class="bodytext31" valign="right"  align="right"><div align="right"><?php echo number_format($overalltotal,2,'.',','); ?></div></td>
			</tr>
		   <?php 
			}
		   } 
		   ?>
            <tr>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" >&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" ><div align="right"></div></td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" ><div align="right"></div></td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" >&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" >&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" >&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" >&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" >&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" >&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" >&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" >&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" >&nbsp;</td>
			</tr>
          
<?php
	}
?>	
		</tbody>
        </table>
		</td>
		</tr>
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>
</main>
</body>
</html>