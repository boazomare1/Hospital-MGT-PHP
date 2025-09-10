<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>

<script type="text/javascript">
function pharmacy(patientcode,visitcode)
{
	var patientcode = patientcode;
	var visitcode = visitcode;
	var url="pharmacy1.php?RandomKey="+Math.random()+"&&patientcode="+patientcode+"&&visitcode="+visitcode;
	
window.open(url,"Pharmacy",'width=600,height=400');
}
function disableEnterKey(varPassed)
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
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.number
{
padding-left:650px;
text-align:right;
font-weight:bold;

}
-->
</style>
</head>
<body>

<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Financial Integration</strong></div></td>
              </tr>
           
			<tr>
			<td width="15%" align="left" class="bodytext31">Select to Integrate</td>
			<td width="85%" align="left" class="bodytext31"><select name="order" onChange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
			<option>Select</option>
			<option value="billpaynowcoaintegration.php">Billing-Pay Now</option>
			<option value="billpaylatercoaintegration.php">Billing-Pay Later</option>
			<option value="consultationbillcoaintegration.php">Consultation Billing</option>
			<option value="paynowrefundcoaintegration.php">Pay Now Refund</option>
			<option value="externalbillingcoaintegration.php">External Billing</option>
			<option value="accountreceivablecoaintegration.php">Account Receivable</option>
			<option value="consultationrefundcoaintegration.php">Consultation Refund</option>
			<option value="paylaterrefundcoaintegration.php">Pay Later Refund</option>
			<option value="supplierpaymententrycoaintegration.php"> Supplier Payment Entry</option>
			<option value="doctorpaymententrycoaintegration.php"> Doctor Payment Entry</option>
			<option value="expenseentrycoaintegration.php">Expense Entry</option>
			<option value="receiptentrycoaintegration.php">Receipt Entry</option>
			<option value="grncoaintegration.php">Goods Received Note</option>
			<option value="grtcoaintegration.php">Goods Return </option>
			<option value="advancedepositscoaintegration.php">Advance Deposits</option>
			<option value="ipdepositscoaintegration.php">IP Deposits</option>
			<option value="ipfinalbillcoaintegration.php">IP Final Bill</option>
			<option value="ipcreditapprovalbillcoaintegration.php">IP Credit Approval Bill</option>
				<option value="ipredepositscoaintegration.php">IP Redeposits</option>
				<option value="openingbalancecoaintegration.php">Account Opening Balance</option>
				<option value="openingbalancesuppliercoaintegration.php">Supplier Opening Balance</option>
			</select>			 </td>
			</tr>
			<tr>
			<td class="bodytext31" align="left">Select to Edit Integration</td>
			<td class="bodytext31" align="left"><select name="order" onChange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
			<option>Select</option>
			<option value="editbillpaynowcoaintegration.php">Edit Billing-Pay Now</option>
			<option value="editbillpaylatercoaintegration.php">Edit Billing-Pay Later</option>
			<option value="editconsultationbillcoaintegration.php">Edit Consultation Billing</option>
			<option value="editpaynowrefundcoaintegration.php">Edit Pay Now Refund</option>
			<option value="editexternalbillingcoaintegration.php">Edit External Billing</option>
			<option value="editaccountreceivablecoaintegration.php">Edit Account Receivable</option>
			<option value="editconsultationrefundcoaintegration.php">Edit Consultation Refund</option>
			<option value="editpaylaterrefundcoaintegration.php">Edit Pay Later Refund</option>
			<option value="editsupplierpaymententrycoaintegration.php">Edit Supplier Payment Entry</option>
			<option value="editdoctorpaymententrycoaintegration.php">Edit Doctor Payment Entry</option>
			<option value="editexpenseentrycoaintegration.php">Edit Expense Entry</option>
			<option value="editreceiptentrycoaintegration.php">Edit Receipt Entry</option>
			<option value="editgrncoaintegration.php">Edit Goods Received Note</option>
			<option value="editadvancedepositscoaintegration.php">Edit Advance Deposits</option>
			<option value="editipdepositscoaintegration.php">Edit IP Deposits</option>
			<option value="editipfinalbillcoaintegration.php">Edit IP Final Bill</option>
			<option value="editipredepositscoaintegration.php">Edit IP Redeposits</option>
			</select>			 </td>
			</tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

