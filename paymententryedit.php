<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";

$docno = $_SESSION['docno'];
$location="select locationcode,locationname from login_locationdetails where username='$username' and docno='$docno'";
$exeloc=mysqli_query($GLOBALS["___mysqli_ston"], $location);
$resloc=mysqli_fetch_array($exeloc);
$locationcode=$resloc['locationcode'];
$locationname=$resloc['locationname'];

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
//$frmflag2 = $_POST['frmflag2'];
if($frmflag2 == 'frmflag2')
{

$paynowbillprefix = 'SPCA-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from purchasereturn_details where billnumber like 'SPC%' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
 $billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == "")
{
	$billnumbercode ='SPCA-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	 $billnumbercode;
	 $billnumbercode = intval($billnumbercode);
	 $billnumbercode = $billnumbercode + 1;

	 $maxanum = $billnumbercode;
	
	
	 $billnumbercode = 'SPCA-' .$maxanum;
	//$openingbalance = '0.00';
	//echo $companycode;
}
	$billnumber = $billnumbercode;
	$amount = $_REQUEST['amount'];
	$amount = str_replace(',','',$amount);
	$editdocno = $_REQUEST['editdocno'];
	$remarks = $_REQUEST['remarks'];
	$suppliercode = $_REQUEST['suppliercode'];
	$suppliername = $_REQUEST['suppliername'];
	$bankcode = $_REQUEST['bankcode'];
	$bankname = $_REQUEST['bankname'];
	$entrydate = date('Y-m-d');
	
	$query72 = "insert into purchasereturn_details (billnumber, itemname, rate, quantity, subtotal, totalamount, username, ipaddress, entrydate, suppliername, suppliercode, grnbillnumber, location, locationcode, locationname, bankcode, bankname, companyanum, remarks)
	values('$billnumber', '$suppliername', '$amount', '1', '$amount', '$amount', '$username', '$ipaddress', '$entrydate', '$suppliername', '$suppliercode', '$editdocno', '$locationname', '$locationcode', '$locationname', '$bankcode', '$bankname', '$companyanum', '$remarks')";
	$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query72".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query34 = "update master_transactionpharmacy set recordstatus = 'deallocated', remarks = '$remarks' where docno = '$editdocno'";
	$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query44 = "select billnumber from master_transactionpharmacy where docno = '$editdocno' group by billnumber";
	$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res44 = mysqli_fetch_array($exec44))
	{
		$billno = $res44['billnumber'];
		
		$query45 = "update master_transactionpharmacy set approved_amount = '0' where billnumber = '$billno' and approved_payment = '1'";
		$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
	}	
	
	header("location:paymententrylist.php");
	exit;
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script>
function funcAccount()
{
	if(document.getElementById("remarks").value == "")
	{
		alert('Enter Remarks');
		document.getElementById("remarks").focus();
		return false;
	}	
}

function number()
{
	if(isNaN(document.getElementById("amount").value))
	{
		alert("Enter only Numbers");
		document.getElementById("amount").value = document.getElementById("amt").value;
		return false;
	}
	if(parseFloat(document.getElementById("amount").value) < 0)
	{
		alert("Enter positive Numbers");
		document.getElementById("amount").value = document.getElementById("amt").value;
		return false;
	}
}
</script>

<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>
<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	//var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
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
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
 <form name="cbform1" method="post" action="paymententryedit.php" onSubmit="return funcAccount()">
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
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="929" 
            align="left" border="0">
          <tbody>
            <tr>
             <td colspan="9" bgcolor="#ecf0f5" class="bodytext31">
             <strong>Payment Entry Edit</strong>
            </td>  
            </tr>
            <tr>
              <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
				<td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Doc No </strong></td>
              <td width="27%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Suppliername </strong></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cheque No</strong></td>
             <td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bank Name</strong></td>
              <td width="7%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>
				 <td width="18%" align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Remarks</strong></td>
            </tr>
			
			<?php
			$colorloopcount = 0;
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = "cbfrmflag1"; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
		   	 
		    $query3 = "select docno, sum(transactionamount) as transactionamount, suppliercode, suppliername, transactiondate, chequenumber, remarks, appvdbank, bankcode, bankname from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' AND docno = '$docno' AND recordstatus = 'allocated' AND docno LIKE '%SP%' group by docno";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num=mysqli_num_rows($exec3);
			while ($res3 = mysqli_fetch_array($exec3))
			{
				//echo $res3['auto_number'];
				$docno = $res3['docno'];
				$transactionamount = $res3['transactionamount'];
				$suppliercode = $res3['suppliercode'];
				$suppliername = $res3['suppliername'];
				$transactiondate = $res3['transactiondate'];
				$chequenumber = $res3['chequenumber'];
				$remarks = $res3['remarks'];
				$bankname = $res3['bankname'];
				$bankcode = $res3['bankcode'];
				
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
			
           <tr <?php  echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $docno; ?> </div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $suppliername; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $chequenumber; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $bankname; ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right">
				<input type="hidden" name="bankcode" id="bankcode" value="<?php echo $bankcode; ?>">
				<input type="hidden" name="bankname" id="bankname" value="<?php echo $bankname; ?>">
				<input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>">
				<input type="hidden" name="suppliername" id="suppliername" value="<?php echo $suppliername; ?>">
				<input type="text" name="amount" id="amount" size="10" onKeyUp="return number()" value="<?php echo $transactionamount; ?>">
				<input type="hidden" name="amt" id="amt" size="10" value="<?php echo $transactionamount; ?>"></div></td>
				<td class="bodytext31" valign="center"  align="center"><?php echo $remarks; ?></td>
			</tr>
		   <?php
		   }  
		   ?>
		   <tr>
              <td class="bodytext31" valign="center"  align="left"><strong>Remarks</strong></td>
			  <td colspan="8" class="bodytext31" valign="center"  align="left">
			  <textarea name="remarks" id="remarks" cols="40" rows="3"></textarea>
			  </td>
			</tr>
			
            <tr>
              <td colspan="9" class="bodytext31" valign="center"  align="right">
			  <input type="hidden" name="editdocno" id="editdocno" value="<?php echo $docno; ?>">
			  <input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">
			  <input type="submit" name="submit12" value="Submit">
			  </td>
			</tr>
			
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
                bgcolor="#ecf0f5">&nbsp;</td>
			</tr>	
		  </tbody>
        </table></td>
      </tr>
			<?php
			}
			?>
</table>
</form>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
