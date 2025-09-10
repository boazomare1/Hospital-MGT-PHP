<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$colorloopcount = '';
$sno = '';
$snocount = '';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["billtype"])) { $billtype = $_REQUEST["billtype"]; } else { $billtype = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
}

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<script>
function funcBill()
{
if((document.getElementById("billtype").value == "")||(document.getElementById("billtype").value == " "))
{
alert('Please Select Bill');
return false;
}
}
</script>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<script>
function myFunction()
{
	if(document.getElementById("billtype").value == '')
	{
	alert("Please Select Deposit Type");
	document.getElementById("billtype").focus();
	return false;
	}
}
</script>
<script>
function viewReport()
 {
window.open("<?php echo basename($_SERVER['PHP_SELF']); ?>","OriginalWindowA4",'width=922,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
  }
</script>
<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
   <tr>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
              <form name="cbform1" method="post" action="billreprintsuser.php">
                <table width="815" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Bill Reprints </strong>&nbsp;&nbsp;&nbsp;<a href="#" onClick="viewReport();"><strong>W</strong></a></td></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">Select</td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong>
                        <select name="billtype" id="billtype" onChange="this.form.submit()">
                          <option value="">Select Bill</option>
                          <option value="1" >Consultation</option>
						  <option value="2" >Bill Paynow</option>
						  <option value="3" >Paynow Refund</option>
						  <option value="4" >Consultation Refund</option>
						  <option value="5" >External Bill</option>
						  <option value="6" >Advance Deposit</option>
						  <option value="7" >IP Deposit</option>
						  <option value="8" >IP Final</option> 
						  <option value="9" >Bill Paylater</option> 
						  <option value="10" >IP Credit Approved</option>
						  <option value="11" >IP Receipts</option>
                        </select>
                      </strong></td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" onClick= "return funcBill();" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1052" 
            align="left" border="0">
          <tbody>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 1)
				{
			$query1 = "select * from billing_consultation where billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));	
			$num1 = mysqli_num_rows($exec1);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">Consultation Bills <?php echo '('.$num1.')'; ?> </td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
             
            <?php
			$query1 = "select * from billing_consultation where billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			 {
			$res1patientcode= $res1['patientcode'];
			$res1patientvisitcode= $res1['patientvisitcode'];
			$res1billdate= $res1['billdate'];
			$res1patientname= $res1['patientname'];
			$res1billnumber= $res1['billnumber'];
			$res1username= $res1['username'];
			
		    $snocount = $snocount + 1;
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
			?>
            
			 
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res1username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_consultationbill_dmp4inch1.php?billautonumber=<?php echo $res1billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } } ?>
		    
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 2)
				{
			$query2 = "select * from billing_paynow where billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"])); 	
		    $num2 = mysqli_num_rows($exec2);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">Bill Paynow <?php echo '('.$num2.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query2 = "select * from billing_paynow where billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res2 = mysqli_fetch_array($exec2))
			 {
			$res2patientcode= $res2['patientcode'];
			$res2patientvisitcode= $res2['visitcode'];
			$res2billdate= $res2['billdate'];
			$res2patientname= $res2['patientname'];
			$res2billnumber= $res2['billno'];
			$res2username= $res2['username'];
			
		    $snocount = $snocount + 1;
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
			?>
            
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res2billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res2username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_billpaynowbill_dmp4inch1.php?billautonumber=<?php echo $res2billnumber; ?>&&patientcode=<?php echo $res2patientcode; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } } ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 3)
				{
			$query3 = "select * from refund_paynow where transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $num3 = mysqli_num_rows($exec3);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">Paynow  Refund <?php echo '('.$num3.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query3 = "select * from refund_paynow where transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res3 = mysqli_fetch_array($exec3))
			 {
			$res3patientcode= $res3['patientcode'];
			$res3patientvisitcode= $res3['visitcode'];
			$res3billdate= $res3['transactiondate'];
			$res3patientname= $res3['patientname'];
			$res3billnumber= $res3['billnumber'];
			$res3username= $res3['username'];
			
		    $snocount = $snocount + 1;
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
			?>
            
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res3billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res3billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res3patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res3patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res3patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res3username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paynow_refund.php?billnumber=<?php echo $res3billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } } ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 4)
				{
			$query4 = "select * from refund_consultation where billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $num4 = mysqli_num_rows($exec4);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">Consultation Refund <?php echo '('.$num4.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query4 = "select * from refund_consultation where billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res4 = mysqli_fetch_array($exec4))
			 {
			$res4patientcode= $res4['patientcode'];
			$res4patientvisitcode= $res4['patientvisitcode'];
			$res4billdate= $res4['billdate'];
			$res4patientname= $res4['patientname'];
			$res4billnumber= $res4['billnumber'];
			$res4username= $res4['username'];
			
		    $snocount = $snocount + 1;
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
			?>
             
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res4billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res4billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res4patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res4patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res4patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res4username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_consultationrefund_dmp4inch1.php?patientcode=<?php echo $res4patientcode; ?>&&billautonumber=<?php echo $res4billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 5)
				{
			$query5 = "select * from billing_external where billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num5 = mysqli_num_rows($exec5);
	        ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">External Bill <?php echo '('.$num5.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query5 = "select * from billing_external where billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res5 = mysqli_fetch_array($exec5))
			 {
			$res5patientcode= $res5['patientcode'];
			$res5patientvisitcode= $res5['visitcode'];
			$res5billdate= $res5['billdate'];
			$res5patientname= $res5['patientname'];
			$res5billnumber= $res5['billno'];
			$res5username= $res5['username'];
			
		    $snocount = $snocount + 1;
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
			?>
             
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res5billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res5username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_external_bill.php?billnumber=<?php echo $res5billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 6)
				{
				$query6 = "select * from master_transactionadvancedeposit where transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num6 = mysqli_num_rows($exec6);
			 ?> 	
			<tr>
				<td colspan="8" bgcolor="#ecf0f5" class="style3">Advance Deposit <?php echo '('.$num6.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query6 = "select * from master_transactionadvancedeposit where transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res6 = mysqli_fetch_array($exec6))
			 {
			$res6patientcode= $res6['patientcode'];
			//$res6patientvisitcode= $res6['visitcode'];
			$res6billdate= $res6['transactiondate'];
			$res6patientname= $res6['patientname'];
			$res6billnumber= $res6['docno'];
			$res6username= $res6['username'];
			
		    $snocount = $snocount + 1;
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
				$colorcode = 'bgcolor="#D3EEB6"';
			}
			?>
             
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res6billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res6billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res6patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res6patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res6username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_advancedeposit_dmp4inch1.php?patientcode=<?php echo $res6patientcode; ?>&&billnumbercode=<?php echo $res6billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 7)
				{
				$query7 = "select * from master_transactionipdeposit where transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">IP Deposit <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query7 = "select * from master_transactionipdeposit where transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['docno'];
			$res7username= $res7['username'];
			
		    $snocount = $snocount + 1;
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
			?>
             
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_depositcollection_dmp4inch1.php?billnumbercode=<?php echo $res7billnumber; ?>&&patientcode=<?php echo $res7patientcode; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		    <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 8)
				{
				$query7 = "select * from master_transactionip where transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">IP Final <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from master_transactionip where transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billnumber'];
			$res7username= $res7['username'];
			
		    $snocount = $snocount + 1;
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
			?>
             
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_ipfinalinvoice.php?patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php                   echo $res7patientvisitcode; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 9)
				{
				$query7 = "select * from billing_paylater where billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">Bill Paylater <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from billing_paylater where billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num7 = mysqli_num_rows($exec7);
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['billdate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billno'];
			
			$query27 = "select * from master_transactionpaylater where transactiontype='finalize' and billnumber='$res7billnumber'";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res27 = mysqli_fetch_array($exec27);
			
			$res7username= $res27['username'];
			
		    $snocount = $snocount + 1;
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
			?>
             
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paylater_detailed.php?billautonumber=<?php echo $res7billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 10)
				{
				$query7 = "select * from master_transactionipcreditapproved where transactiontype='finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by billnumber order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">IP Credit Approved <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from master_transactionipcreditapproved where transactiontype='finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by billnumber order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billnumber'];
			$res7username= $res7['username'];
			
		    $snocount = $snocount + 1;
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
			?>
             
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_creditapproval.php?patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 11)
				{
				$query7 = "select * from master_transactionip where transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num7 = mysqli_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#ecf0f5" class="style3">IP Final <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from master_transactionip where transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res7 = mysqli_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billnumber'];
			$res7username= $res7['username'];
			
		    $snocount = $snocount + 1;
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
			?>
             
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_ipfinal_dmp4inch1.php?patientcode=<?php echo $res7patientcode; ?>&&billnumbercode=<?php echo $res7billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   
            <tr>
              <td colspan="2"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td width="1%" rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			   </tr>          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

