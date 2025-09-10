<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0';
$pendingamount = '0.00';
$accountname = '';
$amount=0;

if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }
if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }
if (isset($_REQUEST["pharmacy"])) { $pharmacy = $_REQUEST["pharmacy"]; } else { $pharmacy = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select suppliername from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	$visitcode1 = 10;

}

if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
//$task = $_REQUEST['task'];
if ($task == 'deleted')
{
	$errmsg = 'Payment Entry Delete Completed.';
}

if(isset($_REQUEST['searchsupplieranum'])){ $accountname_search = $_REQUEST['searchsupplieranum']; }

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
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      
<script>
$(document).ready(function(e) {
   
		$('#pharmacy').autocomplete({
	
	source:"ajaxpharmacy_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			$("#pharmacycode").val(accountid);
			$("#pharmacy").val(accountname);
			
			},
    
	});
		
});
</script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<script language="javascript">

function funcPrintReceipt1(varRecAnum)
{
	var varRecAnum = varRecAnum
	//alert (varRecAnum);
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php?receiptanum="+varRecAnum+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function funcDeletePayment1(varPaymentSerialNumber)
{
	var varPaymentSerialNumber = varPaymentSerialNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this payment entry serial number '+varPaymentSerialNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Payment Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Payment Entry Delete Not Completed.");
		return false;
	}
	//return false;
}

</script>


<!-- /////////ACCOUNT name JS///////////// -->
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">  
<script>
function funcAccount()
{
if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
{
alert('Please Select Account Name.');
return false;
}
else
{
if((document.getElementById("searchsuppliercode").value == "")||(document.getElementById("searchsuppliercode").value == " "))
{
alert('Please Select Account Name.');
return false;
}
} 
}
</script>
<script>
$(document).ready(function(e) {
   
		$('#searchsuppliername').autocomplete({
		
	
	source:"ajaxaccount_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			$("#searchsuppliercode").val(accountid);
			$("#searchsupplieranum").val(accountanum);
			
			},
    
	});
		
});
</script>


<!-- ///////// ACCOUNT NAME/////// -->



</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1800" border="0" cellspacing="0" cellpadding="2">
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
        <td width="860">
		
		
              <form name="cbform1" method="post" action="pharmacyrevenue.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Revenue Report </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
					 <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Search Pharmacy </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
					  <input type="text" name="pharmacy" id="pharmacy" size="60" value="<?php echo $pharmacy; ?>">
					  <input type="hidden" name="pharmacycode" id="pharmacycode">
					  </td>
                       </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location </td>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                      <select name="slocation" id="slocation">
                       <option value="All">All</option>
                      	<?php
						$query01="select locationcode,locationname from master_location where status ='' order by locationname";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
						while($res01=mysqli_fetch_array($exc01))
						{?>
							<option value="<?= $res01['locationcode'] ?>" <?php if($slocation==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		
						<?php 
						}
						?>
                      </select>
                      </td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Type </td>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                      <select name="type" id="type">
                      	<option value="" selected>ALL</option>
                      	<option value="OP" <?php if($type=='OP'){ echo "selected";} ?>> OP + EXTERNAL </option>
                      	<option value="IP" <?php if($type=='IP'){ echo "selected";} ?>> IP </option>
                      
                      </select>
                      </td>
                      
                    </tr>

                   <!--  <tr>
		              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
		              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
		              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
					  <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" />
					   <input name="searchsupplieranum" type="hidden" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" size="50" autocomplete="off">
		              </span></td>
           		</tr> -->
                    
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1194" 
            align="left" border="0">
          <tbody>
            
          	<tr>
              <td width="26"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="64" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date</strong></div></td>
              <td width="72" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg Code</strong></div></td>
              <td width="73" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Visit Code</td>
              <td width="160" align="left" valign="left"  
                bgcolor="#ffffff" class="style1"><div align="left"><strong>Patient Name</strong></div></td>

                 <td width="160" align="left" valign="left"  
                bgcolor="#ffffff" class="style1"><div align="left"><strong>Subtype</strong></div></td>
                 <td width="160" align="left" valign="left"  
                bgcolor="#ffffff" class="style1"><div align="left"><strong>Account Name</strong></div></td>

              <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Code</strong></div></td>
                <td width="174" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Name</strong></div></td>
                <td width="89" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate</strong></div></td>
                <td width="73" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Type</strong></div></td>
                <td width="225" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>  
            </tr>
            
			<?php
			$num1=0;
			$num2=0;
			$num3=0;
			$num6=0;
			$grandtotal = 0;
			$res2itemname = '';
			$amount = 0;
			
			$ADate1 = $transactiondatefrom;
			$ADate2 = $transactiondateto;
			
			if($cbfrmflag1 == 'cbfrmflag1')
			{
			
			$j = 0;
			$crresult = array();
			
			if($slocation=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$slocation'";
			}



			
			$querycr1in = "SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paynowpharmacy` WHERE medicinename LIKE '%$pharmacy%' AND medicinename <> 'Dispensing Fee' AND medicinename <> 'DISPENSING' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
						   UNION ALL SELECT amount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_externalpharmacy` WHERE medicinename LIKE '%$pharmacy%' AND medicinename <> 'Dispensing Fee' AND medicinename <> 'DISPENSING' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
						   UNION ALL SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paylaterpharmacy` WHERE medicinename LIKE '%$pharmacy%' AND medicinename <> 'Dispensing Fee' AND medicinename <> 'DISPENSING' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
						   UNION ALL SELECT amountuhx as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_ippharmacy` WHERE medicinename LIKE '%$pharmacy%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
						   // $querycr1in.=" AND  "
			
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows = mysqli_num_rows($execcr1);
			
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
				


			$j = $j+1;
			$patientcode = $rescr1['pcode'];
			$patientname = $rescr1['pname'];
			$patientvisitcode = $rescr1['vcode'];
			$itemcode = $rescr1['lcode'];
			$itemname = $rescr1['lname'];
			$billdate = $rescr1['date'];
			$pharmacyrate = $rescr1['income'];
			$total = $total + $pharmacyrate;
			
			//$res4billtype = $rescr1['billtype'];
			$res4accountname = $rescr1['accountname'];
			if($res4accountname != 'CASH COLLECTIONS')
			{
				$res4billtype = 'PAY LATER';
			}
			else
			{
				$res4billtype = 'PAY NOW';
			}
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

			// $query11 = "SELECT * from master_visitentry where visitcode='$patientvisitcode'";
			// 	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
				 
			// 		$res11 = mysql_fetch_array($exec11);
			// 		// {
			// 			$aut_accountname_filter=$res11['accountname'];

			// 			// if(isset($accountname_search)){ }

			// 			if($aut_accountname_filter==$accountname_search){
					// 	$fetch_subtype = "SELECT * from master_subtype where auto_number='$aut_subtype'";
					// $fetch_subtype1 = mysql_query($fetch_subtype) or die ("Error in fetch_subtype".mysql_error());


					// while ($res11 = mysql_fetch_array($fetch_subtype1))
					// {
					// $fetch_subtype11 = mysql_fetch_array($fetch_subtype1);
					 // $fetch_subtype11['subtype'];
			  ?>


               <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $j; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $billdate; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientcode; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientvisitcode; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientname; ?></td>

			  <td class="bodytext31" valign="center"  align="left">
			  <?php //echo $patientname; 
			  // $patientcode
			  $query11 = "SELECT * from master_visitentry where visitcode='$patientvisitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_subtype=$res11['subtype'];
						$fetch_subtype = "SELECT * from master_subtype where auto_number='$aut_subtype'";
					$fetch_subtype1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_subtype11 = mysqli_fetch_array($fetch_subtype1);
					echo $fetch_subtype11['subtype'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$patientvisitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_subtype2=$res12['subtype'];
									$fetch_subtype33 = "SELECT * from master_subtype where auto_number='$aut_subtype2'";
								$fetch_subtype133 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype33) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_subtype1133 = mysqli_fetch_array($fetch_subtype133);
								echo $fetch_subtype1133['subtype'];
								
						}else{
									echo  "----";
								}
					}

			  ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php  
			  $query11 = "SELECT * from master_visitentry where visitcode='$patientvisitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_accountname=$res11['accountname'];
						$fetch_accountnam = "SELECT * from master_accountname where auto_number='$aut_accountname'";
					$fetch_accountnam1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_accountnam) or die ("Error in fetch_accountnam".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_accountnam11 = mysqli_fetch_array($fetch_accountnam1);
					echo $fetch_accountnam11['accountname'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$patientvisitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_accountname2=$res12['accountname'];
									$fetch_aut_accountname2 = "SELECT * from master_accountname where auto_number='$aut_accountname2'";
								$fetch_aut_accountname22 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_aut_accountname2) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_aut_accountname221 = mysqli_fetch_array($fetch_aut_accountname22);
								echo $fetch_aut_accountname221['accountname'];
								
						}else{
									echo  "----";
								}
					}


			  ?></td>



              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemcode; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($pharmacyrate,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4billtype; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4accountname; ?></div></td>
           </tr>
		   <?php
			}
			// }
			 $amount = $amount + $total;	
			
		  $num4 = $num1 + $num2 + $num3 + $num6;
		 
		  $grandtotal = $grandtotal + $amount;
		  
		  $total = number_format($total,'2','.','');
		
			?>
          <tr>
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td colspan="5" class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>

              <td class="bodytext31" valign="center"  align="left">
			  <strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><strong><?php echo number_format($amount,2); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
           </tr>
		  
		   <tr>
			<td bgcolor="#ecf0f5" colspan="12" class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong><?php echo 'Refund'; ?></strong></div></td>
			</tr>	
		    <?php
		   $amount=0;
		   $total=0;
		   $j=0;
		   
		    if($type=="" || $type=="OP")
			{
			$querydr1in = "SELECT (amount) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `refund_paynowpharmacy` WHERE medicinename LIKE '%$pharmacy%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
						   UNION ALL SELECT (amount) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,medicinecode as lcode, medicinename as lname, billdate as date, accountname as accountname, billtype as billtype FROM `refund_paylaterpharmacy` WHERE medicinename LIKE '%$pharmacy%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location
						   UNION ALL SELECT pharmacyfxamount as income, patientcode as pcode, patientname as pname, visitcode as vcode,'' as lcode, '' as lname, entrydate as date, accountname as accountname, billtype as billtype FROM `billing_patientweivers` WHERE pharmacyfxamount > '0' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";
			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resdr1 = mysqli_fetch_array($execdr1))
			{
			$j = $j+1;
			$patientcode = $resdr1['pcode'];
			$patientname = $resdr1['pname'];
			$patientvisitcode = $resdr1['vcode'];
			$itemcode = $resdr1['lcode'];
			$itemname = $resdr1['lname'];
			$billdate = $resdr1['date'];
			$servicesrate = $resdr1['income'];
			$total = $total + $servicesrate;
			
			//$res4billtype = $resdr1['billtype'];
			$res4accountname = $resdr1['accountname'];
			if($res4accountname != 'CASH COLLECTIONS')
			{
				$res4billtype = 'PAY LATER';
			}
			else
			{
				$res4billtype = 'PAY NOW';
			}
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $j; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $billdate; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientcode; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientvisitcode; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientname; ?></td>


			  	<td class="bodytext31" valign="center"  align="left">
			  <?php //echo $patientname; 
			  // $patientcode
			  $query11 = "SELECT * from master_visitentry where visitcode='$patientvisitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_subtype=$res11['subtype'];
						$fetch_subtype = "SELECT * from master_subtype where auto_number='$aut_subtype'";
					$fetch_subtype1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_subtype11 = mysqli_fetch_array($fetch_subtype1);
					echo $fetch_subtype11['subtype'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$patientvisitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_subtype2=$res12['subtype'];
									$fetch_subtype33 = "SELECT * from master_subtype where auto_number='$aut_subtype2'";
								$fetch_subtype133 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype33) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_subtype1133 = mysqli_fetch_array($fetch_subtype133);
								echo $fetch_subtype1133['subtype'];
								
						}else{
									echo  "----";
								}
					}

			  ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php  
			  $query11 = "SELECT * from master_visitentry where visitcode='$patientvisitcode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				if (mysqli_num_rows($exec11) > 0) {
					// while (
						$res11 = mysqli_fetch_array($exec11);
					// )
					// {
						$aut_accountname=$res11['accountname'];
						$fetch_subtype = "SELECT * from master_accountname where auto_number='$aut_accountname'";
					$fetch_subtype1 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					$fetch_subtype11 = mysqli_fetch_array($fetch_subtype1);
					echo $fetch_subtype11['accountname'];
				}else{
						$query12 = "SELECT * from master_ipvisitentry where visitcode='$patientvisitcode'";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
						if (mysqli_num_rows($exec12) > 0) {
								$res12 = mysqli_fetch_array($exec12);

									$aut_accountname2=$res12['accountname'];
									$fetch_subtype33 = "SELECT * from master_accountname where auto_number='$aut_accountname2'";
								$fetch_subtype133 = mysqli_query($GLOBALS["___mysqli_ston"], $fetch_subtype33) or die ("Error in fetch_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
								$fetch_subtype1133 = mysqli_fetch_array($fetch_subtype133);
								echo $fetch_subtype1133['accountname'];
								
						}else{
									echo  "----";
								}
					}


			  ?></td>








              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemcode; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
                <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($servicesrate,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4billtype; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res4accountname; ?></div></td>
           </tr>
		   <?php
			}
			}	
			$amount = $amount + $total;
			
		  $num4 = $num1 + $num2 + $num3 + $num6;
		  //$num4 = number_format($num4, '2', '.' ,''); 
		  
		  $grandtotal = $grandtotal - $amount;
		  
		  $total = number_format($total,'2','.','');
		  
			if(true)
			{
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
          <tr>
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td colspan="5" class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			  <strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><strong><?php echo number_format($amount,2); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"></div>              </td>
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
               <td colspan="5" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><strong>Grand Total:</strong></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotal,2);?></strong></td>
              <td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td width="75"  align="left" valign="center" bgcolor="" class="bodytext31">
             <a href="xl_pharmacyrevenuereport.php?type=<?= $type; ?>&&slocation=<?= $slocation; ?>&&cbfrmflag1=cbfrmflag1&&ADate1=<?= $transactiondatefrom ?>&&ADate2=<?= $transactiondateto ?>&&pharmacy=<?php echo $pharmacy; ?>" target="_blank"> <img src="images/excel-xls-icon.png" width="30" height="30" /> </a>
              </td> 
			  </tr>
			  <?php
			  }
			  ?>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

