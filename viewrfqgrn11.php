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

$titlestr = 'SALES BILL';

if (isset($_REQUEST["mrnno"])) { $billnum1 = $_REQUEST["mrnno"]; } else { $billnum1 = ""; }

if (isset($_REQUEST["grnno"])) { $billnum2 = $_REQUEST["grnno"]; } else { $billnum2 = ""; }

if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }

if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }

if (isset($_REQUEST["supplierbillno"])) { $supplierbillno1 = $_REQUEST["supplierbillno"]; } else { $supplierbillno1 = ""; }

	$query1 = "select * from purchase_details where billnumber='$billnum2' and itemstatus=''";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$number = mysqli_num_rows($exec1);
	$res1 = mysqli_fetch_array($exec1);
	$res1itemname = $res1['itemname'];
    $res1ponumber = $res1['ponumber'];
	$res1entrydate = $res1['entrydate'];
	$res1suppliername = $res1['suppliername'];
	$res1suppliercode= $res1['suppliercode'];
    $res1supplierbillnumber= $res1['supplierbillnumber'];
	$res1location= $res1['location'];
	$res1store= $res1['store'];
?>

<script src="js/datetimepicker_css.js"></script>
<?php include ("js/dropdownlist1scriptingmrn.php"); ?>
<script type="text/javascript" src="js/autocomplete_mrn.js"></script>
<script type="text/javascript" src="js/autosuggestmrn.js"></script>
</head>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<body onLoad="return funcOnLoadBodyFunctionCall();">

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
 <!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		 <form name="cbform1" method="post" action="rfqgoodsreceivednote.php"> 
		<table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              
			 <tr>
	  <td>&nbsp;	  </td>
	  </tr>
			<tr>
              <td bgcolor="#ecf0f5" class="bodytext3" colspan="8"><strong>Goods Received Note</strong></td>
		</tr>
		
			  <tr>
			 
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>DOC No</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $billnum2; ?></td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>MRN</strong></td>
                 <td colspan="3" align="left" class="bodytext3" valign="top" ><?php echo $res1ponumber; ?>
                   <input type="hidden" name="po" id="po" value="<?php echo $billnum; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" autocomplete="off"/>				</td>
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>MRN Date </strong></td>
                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $billdate; ?>
				<input name="lpodate" id="lpodate" value="<?php echo $billdate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly" type="hidden"/>				</td>
			    </tr>
				<tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $res1suppliername; ?> & <?php echo $res1suppliercode; ?></td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Invoice No</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3" ><?php echo $res1supplierbillnumber; ?></td>
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>GRN Date </strong></td>
                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $res1entrydate; ?></td>
			    </tr>
				<tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Address</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $address; ?></td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Telephone</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $tele; ?></td>
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3">&nbsp;</td>
			    </tr>
				<tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $res1location; ?></td>
				   <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Store</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $res1store; ?></td>
		</tr>
            </tbody>
        </table>
		</td>
      </tr>
      <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="1297" 
            align="left" border="0">
          <tbody id="foo">
		 <input type="hidden" name="billnum" value="<?php echo $billnumbercode; ?>">
		 <input type="hidden" name="billdate" value="<?php echo $dateonly; ?>">
		 <input type="hidden" name="suppliername" value="<?php echo $suppliername; ?>">
		 <input type="hidden" name="pono" value="<?php echo $billnum; ?>">
		 <input type="hidden" name="location" value="<?php echo $location; ?>">
		 <input type="hidden" name="store1" id="store1">
		 <input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>"> 
		 <input type="hidden" name="accountssubid" value="<?php echo $accountssubid; ?>">
		 <input type="hidden" name="supplierbillno1" id="supplierbillno1" value="<?php echo $supplierbillnumber; ?>">
		 
		 
             <tr>
		               <td width="2%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>S.No</strong></td>
                       <td bgcolor="#ffffff" class="bodytext3" valign="center"  align="left" width="19%"><strong>Item</strong></td>
                       <td width="5%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Ord.Qty</strong></td>
                       <td width="6%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Recd.Qty</strong></td>
					   <td width="5%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Bal.Qty</strong></td>
                       <td width="4%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Batch</strong></td>
                       <td width="4%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Exp.Dt</strong></td>
                      <td width="5%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Pkg.Size</strong></td>
                       <td width="4%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Free</strong></td>
                       <td width="5%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Tot.Qty</strong></td>
					    <td width="4%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>QP/PK</strong></td>
					   <td width="6%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Price/Pk</strong></td>
					   <td width="4%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Disc %</strong></td>
					   <td width="4%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Tax</strong></td>
					  <td width="7%"  align="right" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Total Value</strong></td>
						<td width="7%"  align="right" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Cost Price</strong></td>
						<td width="6%"  align="right" valign="center" bgcolor="#ffffff" class="bodytext3"><strong>Sale Price</strong></td>
						<td width="0%" rowspan="2"  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
						<td width="3%" rowspan="2"  align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><a href="print_rfqgrn.php?cbfrmflag1=cbfrmflag1&&grnno=<?php echo $billnum2; ?>&&mrnno=<?php echo $billnum1; ?>&&ADate1=<?php echo $fromdate; ?>&&ADate2=<?php echo $todate; ?>" target="_blank" download="download"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>
			  </tr>
				  		<?php
			$query2 = "select * from purchase_details where billnumber='$billnum2' and itemstatus=''";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$number = mysqli_num_rows($exec2);
			$res2 = mysqli_fetch_array($exec2);
			$res2itemname = $res2['itemname'];
			$res2ponumber = $res2['ponumber'];
			$res2entrydate = $res2['entrydate'];
			$res2suppliername = $res2['suppliername'];
			$res2suppliercode= $res2['suppliercode'];
			$res2supplierbillnumber= $res2['supplierbillnumber'];
			$res2location= $res2['location'];
			$res2store= $res2['store'];
			$quantity = $res76['quantity'];
			$batchnumber = $res76['batchnumber'];
			$expirydate = $res76['expirydate'];
			$free = $res76['itemfreequantity'];
			$priceperpack = $res76['priceperpack'];
			$totalqty = $res76['allpackagetotalquantity'];
			$discountpercent = $res76['discountpercentage'];
			$itemtaxpercentage = $res76['itemtaxpercentage'];
			
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
		<td class="bodytext3" valign="center"  align="left"><div align="center"></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="left"></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"></td>
		<td class="bodytext3" valign="center"  align="right"></td>
		<td class="bodytext3" valign="center"  align="right"></td>
		<td class="bodytext3" valign="center"  align="left"></td>
		<td class="bodytext3" valign="center"  align="left"></td>
		<td class="bodytext3" valign="center"  align="left"></td>
				<td class="bodytext3" valign="center"  align="left">
		<td  align="left" valign="center" class="bodytext3">
         </td>
		</tr>
			<?php 
		
			}
		?>
			  <tr>
              <td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext3" valign="center"  align="center" 
                bgcolor="#ecf0f5"></td>
				 <td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td  align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext3"><strong>Total:</strong></td>
				<td class="bodytext3" valign="center"  align="right" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext3" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
           
          </tbody>
        </table>	
				    
				  <tr>
	  <td>&nbsp;	  </td>
	  </tr>
      <tr>
	  <td>
	  <table width="716">
     
		</table>		</td>
		</tr>				
		        
	  </table>      </td>
      </tr>
    
  </table>

<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>