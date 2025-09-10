<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $location = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');
	
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
	$transactiondateto = date('Y-m-d');
}

if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
//$itemcode = $_REQUEST['itemcode'];
if (isset($_REQUEST["servicename"])) { $servicename = $_REQUEST["servicename"]; } else { $servicename = ""; }
//$servicename = $_REQUEST['servicename'];

if ($servicename == '') $servicename = 'ALL';

if (isset($_REQUEST["itemname"])) { $searchitemname = $_REQUEST["itemname"]; } else { $searchitemname = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["fifocode"])) { $fifocode = $_REQUEST["fifocode"]; } else { $fifocode = ""; }


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if($cbfrmflag1 == 'cbfrmflag1')
{
	$batchqty1 = $_REQUEST['batchqty'];
	//print_r($_REQUEST['batchqty']);
	foreach($batchqty1 as $key=>$value)
	{
		 $anum = $_REQUEST['anum'][$key];
		 $batchqty = $_REQUEST['batchqty'][$key];
		 $currbatchqty=$_REQUEST['currbatchqty'][$key];
		 $transaction_quantity = $_REQUEST['transaction_quantity'][$key];
                 if($batchqty!=$currbatchqty){
		 $q1="update `transaction_stock` SET `batch_quantity` = '$batchqty', transaction_quantity = '$transaction_quantity' WHERE `transaction_stock`.`auto_number` = $anum";
		 mysqli_query($GLOBALS["___mysqli_ston"], $q1);
		}
	}
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<script language="javascript">

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<?php include ("js/dropdownlist1scripting1stock1.php"); ?>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
<script type="text/javascript" src="js/autocomplete_item1pharmacy.js"></script>
<script type="text/javascript">


function stockinwardvalidation1()
{
	
	if (document.stockinward.itemcode.value == "")
	{
		alert ("Please Select Item Name.")
		return false;
	}
	else if (document.stockinward.servicename.value == "")
	{
		alert ("Please Select Item Name.")
		document.stockinward.servicename.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (isNaN(document.stockinward.stockquantity.value))
	{
		alert ("Please Enter Only Numbers Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.0")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.00")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.000")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}

}


function itemcodeentry2()
{
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
		//itemcodeentry1();
		return false;
	}
	else
	{
		return true;
	}
}

function Locationcheck()
{
if(document.getElementById("store").value == '')
{
//alert("Please Select Location");
//document.getElementById("store").focus();
//return false;
}
return true;
}


</script>
<body onLoad="return funcCustomerDropDownSearch1();">
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
    <td width="1%" rowspan="3">&nbsp;</td>
    <td width="2%" rowspan="3" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
		
			<form name="stockinward" action="" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="5" bgcolor="#ecf0f5" class="bodytext31"><strong>Report By Item</strong></td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="center"  
                 bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#cbdbfa'; } ?>" class="bodytext31"><?php echo $errmsg; ?>&nbsp;</td>
          </tr>
        <script language="javascript">

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
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
	

}


function process1rateperunit()
{
	servicenameonchange1();
}


function deleterecord1(varEntryNumber,varAutoNumber)
{
	var varEntryNumber = varEntryNumber;
	var varAutoNumber = varAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete the stock entry no. '+varEntryNumber+' ?');
	//alert(fRet);
	if (fRet == false)
	{
		alert ("Stock Entry Delete Not Completed.");
		return false;
	}
	else
	{
		window.location="stockreport2.php?task=del&&delanum="+varAutoNumber;		
	}
}


</script>
        
        
      </tbody>
    </table>
   </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="27%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                  <td width="11%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="11%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			  <td width="11%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			  <td width="11%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			  <td width="11%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                    <td width="11%" bgcolor="#ecf0f5" class="bodytext31"><a 
                  href="#"></a></td>
                     
            </tr>

            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Code </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
				      
                  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Batch Qty</strong></div></td>
				<td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>New Batch Qty</strong></div></td>
                             <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Trans Qty </strong></div></td>
				  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Trans Func </strong></div></td>
				 <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Batch Status </strong></div></td>
            </tr>
            <?php
			if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
			if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
			//$categoryname = $_REQUEST['categoryname'];
			if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = "frmflag1"; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	if($fifocode != '')
	{		
			
			$colorloopcount = '';
			$sno = '';
			$totalquantity = '';
			$stockdate = '';
			$transactionparticular = '';
			$stockremarks = '';

			$salesquantity = '';
			$salesreturnquantity = '';
			$purchasequantity = '';
			$purchasereturnquantity = '';
			$adjustmentaddquantity = '';
			$adjustmentminusquantity = '';
			$totalsalesquantity = '';
			$totalsalesreturnquantity = '';
			$totalpurchasequantity = '';
			$totalpurchasereturnquantity = '';
			$totaladjustmentaddquantity = '';
			$totaladjustmentminusquantity = '';
			$transferquantity1 = '';
			$transferquantity = '';
			$totalpurchaseprice1 = '';
			$totalitemrate1 = '';
			$totalcurrentstock1  = '';
			$grandtotalcogs = '';
			$grandtotalcogs = '0.00';

			//$query2 = "select * from master_stock where itemcode like '%$itemcode%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
			if($itemcode=='')
			{
				$query2 = "select auto_number,itemcode,itemname,categoryname,rateperunit,packageanum,packagename from master_medicine where categoryname like '%$categoryname%' and status <> 'DELETED'";// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
			}
			else
			{
				$query2 = "select auto_number,itemcode,itemname,categoryname,rateperunit,packageanum,packagename from master_medicine where itemcode = '$itemcode' and categoryname like '%$categoryname%' and status <> 'DELETED'";
			}
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while ($res2 = mysqli_fetch_array($exec2))
			{
			//	$counter++;
			$res2anum = $res2['auto_number'];
			$itemcode = $res2['itemcode'];
			$itemname = $res2['itemname'];
			$res2categoryname = $res2['categoryname'];
			
			
			$itemrate = $res2['rateperunit']; //Unit price is calculated below.
			//$stockdate = $res2['transactiondate'];
			//$stockremarks = $res2['remarks'];
			//$transactionparticular = $res2['transactionparticular'];
			$itempackageanum = $res2['packageanum'];
			$res2packagename = $res2['packagename'];
			if($res2packagename == '')
			{
			$res2packagename='1S';
			}
			$res2packagename = stripslashes($res2packagename);
			
			$itempackageanum = '14';
			//To calculate price for packaged items to divide by number of items count.
			$query31 = "select quantityperpackage from master_packagepharmacy where auto_number = '$itempackageanum'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$quantityperpackage = $res31['quantityperpackage']; //Value called for purchase calc.
			
			@$itemrate = $itemrate / $quantityperpackage;
			$itemrate = number_format($itemrate, 2, '.', '');
			@$itempurchaserate = $purchaseprice / $quantityperpackage;
			$itempurchaserate = number_format($itempurchaserate, 2, '.', '');
			
			$query15 = "select fifo_code from transaction_stock where itemcode='$itemcode' and fifo_code = '$fifocode' and locationcode='$location' and storecode ='$store' group by fifo_code";
			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res15 = mysqli_fetch_array($exec15))
			{
			$sno=1;
			$fifo_code = $res15['fifo_code'];
			?>
			<tr bgcolor="#ecf0f5">
			<td class="bodytext31" colspan="9"><strong>Fifo code : <?= $fifo_code; ?></strong></td>
			</tr>
			<?php
			$old_batch_qty=0;
			
			$original=0;
			$query12 = "select auto_number, batch_quantity, transaction_quantity,transactionfunction, batch_stockstatus, entrydocno from transaction_stock where  itemcode='$itemcode' and fifo_code = '$fifo_code' and locationcode='$location' and storecode ='$store' order by auto_number";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res12 = mysqli_fetch_array($exec12))
			{
                        

			$transactionfunction = $res12['transactionfunction'];
			$transaction_quantity1 = $res12['transaction_quantity'];
			$batch_quantity1 = $res12['batch_quantity'];
			$batch_status = $res12['batch_stockstatus'];
			$anum = $res12['auto_number'];
			$entrydocno = $res12['entrydocno'];

			if($transactionfunction == '1')
			{
			
			$original+=$transaction_quantity1;
			if(($old_batch_qty+$transaction_quantity1)!=$batch_quantity1 || $batch_quantity1<0)
				$colorcode = 'bgcolor="red"';
			else
				$colorcode = 'bgcolor="#00FF99"';
			}
			else
			{

			$original-=$transaction_quantity1;			
			if(($old_batch_qty-$transaction_quantity1)!=$batch_quantity1 || $batch_quantity1<0)
				$colorcode = 'bgcolor="red"';
			else
				$colorcode = 'bgcolor="#FFF"';
			}
	
				$newbatch = $original;

			?>
			<tr <?= $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno++; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemcode.' ('.$entrydocno.')'; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="left"><?php echo $res2categoryname; ?>&nbsp;</div>
              </div></td>
			 <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31">
			    <div align="right"><?php echo $batch_quantity1; ?></div>
			  </div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31">
			    <div align="right">
				<input type="hidden" name="anum[]" value="<?php echo $anum; ?>" size="3">
				<input type="text" name="batchqty[]" value="<?php echo $newbatch; ?>" size="3"></div>
				<input type="hidden" name="currbatchqty[]" value="<?php echo $batch_quantity1; ?>" size="3"></div>
			  </div></td>
             <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31">
			    <div align="right"><input type="text" name="transaction_quantity[]" value="<?php echo $transaction_quantity1; ?>" size="3"></div>
			  </div></td>
         	<td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31">
			    <div align="right"><?php echo $transactionfunction; ?>&nbsp;</div>
			  </div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31">
			    <div align="right"><a target="_blank" href="stockmovementdetail_updateflag.php?anum=<?php echo $anum; ?>&&st=<?php echo $batch_status; ?>"><?php echo $batch_status; ?></a></div>
			  </div></td>
            </tr>
			<?php
				$old_batch_qty=$batch_quantity1;
			}
			}
			}
		
			?>
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
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp; </strong></div></td>
                        <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $totalcurrentstock1; ?>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
               <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>   
            </tr>
			<?php
			}
			}
			?>
          </tbody>
        </table></td>
      </tr>
	  
      <tr>
        <td><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
            <input  style="border: 1px solid #001E6A" type="submit" value="Submit" name="Submit" />
            <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
      </tr>
    </table>    
  <tr>
    <td valign="top">    
  <tr>
    <td width="97%" valign="top">    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>