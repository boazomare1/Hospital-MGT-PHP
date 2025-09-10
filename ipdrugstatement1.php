<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$totalamount="0.00";

//This include updatation takes too long to load for hunge items database.


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



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
    $itemname=$_REQUEST['itemname'];
	$itemcode=$_REQUEST['itemcode'];
$adjustmentdate=date('Y-m-d');
	foreach($_POST['batch'] as $key => $value)
		{
		$batchnumber=$_POST['batch'][$key];
		$addstock=$_POST['addstock'][$key];
		$minusstock=$_POST['minusstock'][$key];
		$query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
	$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res40 = mysqli_fetch_array($exec40);
	$itemmrp = $res40['rateperunit'];
	
	$itemsubtotal = $itemmrp * $addstock;
	
		if($addstock != '')
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
		}
	header("location:stockadjustment.php");
	exit;
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}

include ("autocompletebuild_customeripbilling.php");
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
<?php include ("js/dropdownlistipbilling.php"); ?>
<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
}



</script>
<script type="text/javascript">

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
.bali
{
text-align:right;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
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
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      

     
	  <form name="form11" id="form11" method="post" action="ipdrugstatement.php">	
	  <tr>
        <td width="860">
	
		
<?php
	$colorloopcount=0;
	$sno=0;
	
	$patientcode = $_REQUEST['patientcode'];
	$visitcode = $_REQUEST['visitcode'];
	if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
	
	$query39 = "select * from ipmedicine_issue where patientcode = '$patientcode' and visitcode = '$visitcode' ";
		   $exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res39 = mysqli_fetch_array($exec39);
           $res39visitcode = $res39['visitcode'];
		   $res39patientname = $res39['patientname'];
	
		
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1175" 
            align="left" border="0">
          <tbody>
               <tr>
			     <td colspan="9" align="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res39patientname;  ?>-<?php echo $patientcode; ?>-<?php echo $res39visitcode; ?></strong></td>
			 </tr>
            <tr>
              <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>S.No.</strong></div></td>
				    <td width="9%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ref No</strong></div></td>
				  <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Medicine</strong></div></td>
				 <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Issues</strong></div></td>
				 <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Returns</strong></div></td>
				    <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
		            <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Free</strong></div></td>
	                <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
	                 <td width="1%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                    <td width="16%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>
           <?php
		  
		 
           $query34 = "select * from ipmedicine_issue where patientcode = '$patientcode' and visitcode = '$visitcode' ";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $itemname = $res34['itemname'];
		   $docno = $res34['docno'];
		   $quantity = $res34['quantity'];
		   $res34date = $res34['date'];
		   $rateperunit = $res34['rateperunit'];
		   $totalrate = $res34['totalrate'];
		   $freestatus = $res34['freestatus'];
		   $totalamount = $totalamount + $totalrate;
		   

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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo  date("d/m/Y", strtotime($res34date)); ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $docno; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo intval($quantity); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center">&nbsp;</div></td>
					  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $rateperunit; ?></div></td>
			          <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $freestatus; ?></div></td>
		              <td  align="left" valign="center" class="bodytext31"><div align="center"><?php echo number_format($totalrate,2,'.',','); ?></div></td>
	                  <td class="bodytext31" bgcolor="#ecf0f5" valign="center" align="left">&nbsp;</td>
                    <td class="bodytext31" bgcolor="#ecf0f5" valign="center" align="left">&nbsp;</td>
			<?php } ?>			
			 <?php
		  
		 
           $query341 = "select * from ippharmacy_refund where patientcode = '$patientcode' and visitcode = '$visitcode' ";
		   $exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res341 = mysqli_fetch_array($exec341))
		   {
		  
		   $patientcode = $res341['patientcode'];
		   $visitcode = $res341['visitcode'];
		   $itemname = $res341['itemname'];
		   $docno = $res341['billnumber'];
		   $quantity = $res341['quantity'];
		   $res34date = $res341['entrydate'];
		   $rateperunit = $res341['rate'];
		   $totalrate = $res341['totalamount'];
		   
		   $totalamount = $totalamount - $totalrate;
		   

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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo  date("d/m/Y", strtotime($res34date)); ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $docno; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
								  <td class="bodytext31" valign="center"  align="left">
			    <div align="center">&nbsp;</div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo intval($quantity); ?></div></td>

					  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $rateperunit; ?></div></td>
			          <td class="bodytext31" valign="center"  align="left"><div align="center">&nbsp;</div></td>
		              <td  align="left" valign="center" class="bodytext31"><div align="center">-<?php echo number_format($totalrate,2,'.',','); ?></div></td>
	                  <td class="bodytext31" bgcolor="#ecf0f5" valign="center" align="left">&nbsp;</td>
                    <td class="bodytext31" bgcolor="#ecf0f5" valign="center" align="left">&nbsp;</td>
					</tr>
			<?php } ?>			

			
			
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong>Total</strong></div></td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></div></td>
				   <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				   <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><a target="_blank" href="print_ipdrugstatement1.php?cbfrmflag1=cbfrmflag1&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $docnumber; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></div></td>
              <?php  ?>
			</tr>
			<tr>
			<td valign="center" class="style1"><a target="_blank" href="print_ipdrugstatement.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Print</a></td>
          </tbody>
        </table>		</td>
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
<?php include ("includes/footer1.php"); ?>
</body>
</html>

