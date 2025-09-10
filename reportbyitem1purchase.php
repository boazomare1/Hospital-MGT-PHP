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

if (isset($_REQUEST["searchoption1"])) { $searchoption1 = $_REQUEST["searchoption1"]; } else { $searchoption1 = ""; }
//$searchoption1 = $_REQUEST['searchoption1'];


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
<script type="text/javascript">


function process1()
{
	if (document.stockinward.categoryname.value == "")
	{
		alert ("Please Select Category Name.")
		return false;
	}
	if (document.stockinward.searchoption1.value == "")
	{
		alert ("Please Select Search Option.")
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




</script>

<script src="js/datetimepicker_css.js"></script>

<body <?php //echo $loadprintpage; ?>>
<table width="1500" border="0" cellspacing="0" cellpadding="2">
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
    <td width="1%" rowspan="3">&nbsp;</td>
    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
		
			<form name="stockinward" action="reportbyitem1purchase.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return process1()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="5" bgcolor="#ecf0f5" class="bodytext31"><strong>Purchase Report - By Item</strong></td>
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
        <tr>
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category  </strong></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
			<select name="categoryname" id="categoryname">
				<?php
				$categoryname = $_REQUEST['categoryname'];
				if ($categoryname != '')
				{
				?>
				<option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
				<?php
				}
				else
				{
				?>
				<option selected="selected" value="All Category">All Category</option>
				<?php
				}
				?>
				<?php
				$query42 = "select * from master_categorypharmacy where status = '' order by categoryname";
				$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res42 = mysqli_fetch_array($exec42))
				{
				$categoryname = $res42['categoryname'];
				?>
				<option value="<?php echo $categoryname; ?>"><?php echo $categoryname; ?></option>
				<?php
				}
				?>
			</select>		  </td>
          </tr>
        <tr>
          <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="136" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="65" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="125" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          <td width="338" align="left" valign="center"  bgcolor="#ffffff">

		  <select name="searchoption1" id="searchoption1">
		  <!--<option value="">Select Search Option</option>-->
		  <?php
		  if ($searchoption1 == 'CUMULATIVE')
		  {
		  ?>
		  <option value="CUMULATIVE" selected="selected">CUMULATIVE SEARCH ( List By Item )</option>
		  <?php
		  }
		  ?>
		  <?php
		  if ($searchoption1 == 'DETAILED')
		  {
		  ?>
		  <option value="DETAILED" selected="selected">DETAILED SEARCH ( List By Date )</option>
		  <?php
		  }
		  ?>
		  <option value="CUMULATIVE">CUMULATIVE SEARCH ( List By Item )</option>
		  <option value="DETAILED">DETAILED SEARCH ( List By Date )</option>
          </select>          </td>
        </tr>

        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="itemcode2" id="itemcode2" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $itemcode; ?>" size="10" readonly="readonly" /></td>
          <td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <strong><!--Item Code : --><?php //echo $itemcode; ?></strong></td>
          <td align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right">
            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
            <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
            <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" />
	<input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
          </div></td>
        </tr>
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Date Range : <?php echo $transactiondatefrom.' To '.$transactiondateto; ?></strong></td>
        </tr>
      </tbody>
    </table>
    </form>	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="98%" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="18%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext31"><a 
                  href="#"></a></td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext31"><a 
                  href="#"></a></td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext31"><a 
                  href="#"></a></td>
              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="13%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
              <td colspan="2" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Purchase</strong></div></td>
              <td colspan="2" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>PurchaseReturn</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Particulars </strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Remarks</strong></div></td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amt</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Qty</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amt</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Qty</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
            </tr>
            <?php
			if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
			//$categoryname = $_REQUEST['categoryname'];
			
			$colorloopcount = '';
			$sno = '';
			$stockdate = '';
			$transactionparticular = '';
			$stockremarks = '';
			$totalquantity = '';
			$totalsalesamount = '';
			$totalsalesquantity = '';
			$totalsalesreturnamount = '';
			$totalsalesreturnquantity = '';
			$totalpurchaseamount = '';
			$totalpurchasequantity = '';
			$totalpurchasereturnamount = '';
			$totalpurchasereturnquantity = '';
			$totaldccustomerquantity = '';
			$totaldccustomeramount = '';
			$totaldcsupplierquantity = '';
			$totaldcsupplieramount = '';
			$totaladjustmentaddquantity = '';
			$totaladjustmentminusquantity = '';
			
		    if ($categoryname == 'All Category') //To list all categories, if not selected.
			{
			
			if ($searchoption1 == 'DETAILED')
			{
				$query2 = "select * from master_stock where itemcode like '%$itemcode%' and transactionmodule like '%PURCHASE%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum' order by lastupdate";// and cstid='$custid' and cstname='$custname'";
			}
			if ($searchoption1 == 'CUMULATIVE')
			{
				$query2 = "select *, sum(quantity) as sumquantity, sum(totalrate) as sumtotalrate from master_stock where itemcode like '%$itemcode%' and transactionmodule like '%PURCHASE%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum' group by itemcode, transactionmodule order by itemname";// and cstid='$custid' and cstname='$custname'";
			}
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['auto_number'];
			$itemcode = $res2['itemcode'];
			$itemname = $res2['itemname'];
			$transactionmodule = $res2['transactionmodule'];
			$res2transactionparticular = $res2['transactionparticular'];
			
			$query3 = "select categoryname from master_itempharmacy where itemcode = '$itemcode' and status <> 'DELETED'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3categoryname = $res3['categoryname'];
			
			
			if ($searchoption1 == 'DETAILED')
			{
				$sumquantity = $res2['quantity'];
				$sumamount = $res2['totalrate'];
			}
			if ($searchoption1 == 'CUMULATIVE')
			{
				$sumquantity = $res2['sumquantity'];
				$sumamount = $res2['sumtotalrate'];
			}
			
			if ($transactionmodule == 'SALES')
			{
				//$salesquantity = $res2['quantity'];
				$salesquantity = $sumquantity;
				$salesreturnquantity = '';
				$purchasequantity = '';
				$purchasereturnquantity = '';
				$dccustomerquantity = '';
				$dcsupplierquantity = '';
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$salesquantity = round($salesquantity, 4);
				$totalsalesquantity = $totalsalesquantity + $salesquantity;
				
				$salesamount = $sumamount;
				$salesreturnamount = '';
				$purchaseamount = '';
				$purchasereturnamount = '';
				$dccustomeramount = '';
				$dcsupplieramount = '';
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totalsalesamount = $totalsalesamount + $salesamount;
				$totalsalesamount = number_format($totalsalesamount, 2, '.', '');
				
			}
			if ($transactionmodule == 'SALES RETURN')
			{
				$salesquantity = '';
				$salesreturnquantity = $sumquantity;
				$purchasequantity = '';
				$purchasereturnquantity = '';
				$dccustomerquantity = '';
				$dcsupplierquantity = '';
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$salesreturnquantity = round($salesreturnquantity, 4);
				$totalsalesreturnquantity = $totalsalesreturnquantity + $salesreturnquantity;
				
				$salesamount = '';
				$salesreturnamount = $sumamount;
				$purchaseamount = '';
				$purchasereturnamount = '';
				$dccustomeramount = '';
				$dcsupplieramount = '';
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totalsalesreturnamount = $totalsalesreturnamount + $salesreturnamount;
				$totalsalesreturnamount = number_format($totalsalesreturnamount, 2, '.', '');
				
			}
			if ($transactionmodule == 'PURCHASE')
			{
				$salesquantity = '';
				$salesreturnquantity = '';
				$purchasequantity = $sumquantity;
				$purchasereturnquantity = '';
				$dccustomerquantity = '';
				$dcsupplierquantity = '';
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$purchasequantity = round($purchasequantity, 4);
				$totalpurchasequantity = $totalpurchasequantity + $purchasequantity;

				$salesamount = '';
				$salesreturnamount = '';
				$purchaseamount =  $sumamount;
				$purchasereturnamount = '';
				$dccustomeramount = '';
				$dcsupplieramount = '';
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totalpurchaseamount = $totalpurchaseamount + $purchaseamount;
				$totalpurchaseamount = number_format($totalpurchaseamount, 2, '.', '');
				
			}
			if ($transactionmodule == 'PURCHASE RETURN')
			{
				$salesquantity = '';
				$salesreturnquantity = '';
				$purchasequantity = '';
				$purchasereturnquantity = $sumquantity;
				$dccustomerquantity = '';
				$dcsupplierquantity = '';
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$purchasereturnquantity = round($purchasereturnquantity, 4);
				$totalpurchasereturnquantity = $totalpurchasereturnquantity + $purchasereturnquantity;

				$salesamount = '';
				$salesreturnamount = '';
				$purchaseamount = '';
				$purchasereturnamount = $sumamount;
				$dccustomeramount = '';
				$dcsupplieramount = '';
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totalpurchasereturnamount = $totalpurchasereturnamount + $purchasereturnamount;
				$totalpurchasereturnamount = number_format($totalpurchasereturnamount, 2, '.', '');
				
			}
			if ($transactionmodule == 'DC CUSTOMER')
			{
				$salesquantity = '';
				$salesreturnquantity = '';
				$purchasequantity = '';
				$purchasereturnquantity = '';
				$dccustomerquantity = $sumquantity;
				$dcsupplierquantity = '';
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$dccustomerquantity = round($dccustomerquantity, 4);
				$totaldccustomerquantity = $totaldccustomerquantity + $dccustomerquantity;

				$salesamount = '';
				$salesreturnamount = '';
				$purchaseamount = '';
				$purchasereturnamount = '';
				$dccustomeramount = $sumamount;
				$dcsupplieramount = '';
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totaldccustomeramount = $totaldccustomeramount + $dccustomeramount;
				$totaldccustomeramount = number_format($totaldccustomeramount, 2, '.', '');
				
			}
			if ($transactionmodule == 'DC SUPPLIER')
			{
				$salesquantity = '';
				$salesreturnquantity = '';
				$purchasequantity = '';
				$purchasereturnquantity = '';
				$dccustomerquantity = '';
				$dcsupplierquantity = $sumquantity;
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$dcsupplierquantity = round($dcsupplierquantity, 4);
				$totaldcsupplierquantity = $totaldcsupplierquantity + $dcsupplierquantity;

				$salesamount = '';
				$salesreturnamount = '';
				$purchaseamount = '';
				$purchasereturnamount = '';
				$dccustomeramount = '';
				$dcsupplieramount = $sumamount;
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totaldcsupplieramount = $totaldcsupplieramount + $dcsupplieramount;
				$totaldcsupplieramount = number_format($totaldcsupplieramount, 2, '.', '');
				
			}
			if ($transactionmodule == 'ADJUSTMENT')
			{
				$salesquantity = '';
				$salesreturnquantity = '';
				$purchasequantity = '';
				$purchasereturnquantity = '';
				$dccustomerquantity = '';
				$dcsupplierquantity = '';
				if ($res2transactionparticular == 'BY ADJUSTMENT ADD')
				{
					$adjustmentaddquantity = $sumquantity;
					$adjustmentminusquantity = '';
					$adjustmentaddquantity = round($adjustmentaddquantity, 4);
					$totaladjustmentaddquantity = $totaladjustmentaddquantity + $adjustmentaddquantity;
				}
				if ($res2transactionparticular == 'BY ADJUSTMENT MINUS')
				{
					$adjustmentaddquantity = '';
					$adjustmentminusquantity = $sumquantity;
					$adjustmentminusquantity = round($adjustmentminusquantity, 4);
					$totaladjustmentminusquantity = $totaladjustmentminusquantity + $adjustmentminusquantity;
				}
			}
			else
			{	
				$quantity = '0';
			}
			
			
			if ($searchoption1 == 'DETAILED')
			{
				$quantity = $res2['quantity'];
				$stockdate = $res2['transactiondate'];
				$stockremarks = $res2['remarks'];
				$transactionparticular = $res2['transactionparticular'];
			}
			if ($searchoption1 == 'CUMULATIVE')
			{
				$quantity = $res2['sumquantity'];
			} 
			$quantity = round($quantity, 4);
			
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
			
			$sno = $sno + 1;
			
			$totalquantity = $totalquantity + $quantity;
			
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $sno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res3categoryname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemcode.' - '.$itemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                <div align="right"><?php echo $purchaseamount; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo $purchasequantity; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                <div align="right"><?php echo $purchasereturnamount; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo $purchasereturnquantity; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
			  <?php echo $stockdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="left"><?php echo $transactionparticular; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left">
			  <?php echo $stockremarks; ?>
			  </div></td>
            </tr>
            <?php
			$sumamount = '';
			$sumquantity = '';
			$salesquantity = '';
			$salesreturnquantity = '';
			$purchasequantity = '';
			$purchasereturnquantity = '';
			$adjustmentaddquantity = '';
			$adjustmentminusquantity = '';
			$purchasereturnquantity = '';
			$totalpurchasereturnquantity = '';
			
			$salesamount = '';
			$salesreturnamount = '';
			$purchaseamount = '';
			$purchasereturnamount = '';
			$adjustmentaddamount = '';
			$adjustmentminusamount = '';
			$totalpurchasereturnamount = '';
			$totalpurchasereturnamount = '';

			
			
			}
			
			}
			
			else if($categoryname != '') //To list all categories, if not selected.
			{
			
			if ($searchoption1 == 'DETAILED')
			{
				$query2 = "select * from master_stock where itemcode like '%$itemcode%' and transactionmodule like '%PURCHASE%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum' order by lastupdate";// and cstid='$custid' and cstname='$custname'";
			}
			if ($searchoption1 == 'CUMULATIVE')
			{
				$query2 = "select *, sum(quantity) as sumquantity, sum(totalrate) as sumtotalrate from master_stock where itemcode like '%$itemcode%' and transactionmodule like '%PURCHASE%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum' group by itemcode, transactionmodule order by itemname";// and cstid='$custid' and cstname='$custname'";
			}
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['auto_number'];
			$itemcode = $res2['itemcode'];
			$itemname = $res2['itemname'];
			$transactionmodule = $res2['transactionmodule'];
			$res2transactionparticular = $res2['transactionparticular'];
			
			$query3 = "select categoryname from master_itempharmacy where itemcode = '$itemcode' and status <> 'DELETED'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3categoryname = $res3['categoryname'];
			
			if ($categoryname == $res3categoryname)
			{
			
			if ($searchoption1 == 'DETAILED')
			{
				$sumquantity = $res2['quantity'];
				$sumamount = $res2['totalrate'];
			}
			if ($searchoption1 == 'CUMULATIVE')
			{
				$sumquantity = $res2['sumquantity'];
				$sumamount = $res2['sumtotalrate'];
			}
			
			if ($transactionmodule == 'SALES')
			{
				//$salesquantity = $res2['quantity'];
				$salesquantity = $sumquantity;
				$salesreturnquantity = '';
				$purchasequantity = '';
				$purchasereturnquantity = '';
				$dccustomerquantity = '';
				$dcsupplierquantity = '';
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$salesquantity = round($salesquantity, 4);
				$totalsalesquantity = $totalsalesquantity + $salesquantity;
				
				$salesamount = $sumamount;
				$salesreturnamount = '';
				$purchaseamount = '';
				$purchasereturnamount = '';
				$dccustomeramount = '';
				$dcsupplieramount = '';
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totalsalesamount = $totalsalesamount + $salesamount;
				$totalsalesamount = number_format($totalsalesamount, 2, '.', '');
				
			}
			if ($transactionmodule == 'SALES RETURN')
			{
				$salesquantity = '';
				$salesreturnquantity = $sumquantity;
				$purchasequantity = '';
				$purchasereturnquantity = '';
				$dccustomerquantity = '';
				$dcsupplierquantity = '';
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$salesreturnquantity = round($salesreturnquantity, 4);
				$totalsalesreturnquantity = $totalsalesreturnquantity + $salesreturnquantity;
				
				$salesamount = '';
				$salesreturnamount = $sumamount;
				$purchaseamount = '';
				$purchasereturnamount = '';
				$dccustomeramount = '';
				$dcsupplieramount = '';
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totalsalesreturnamount = $totalsalesreturnamount + $salesreturnamount;
				$totalsalesreturnamount = number_format($totalsalesreturnamount, 2, '.', '');
				
			}
			if ($transactionmodule == 'PURCHASE')
			{
				$salesquantity = '';
				$salesreturnquantity = '';
				$purchasequantity = $sumquantity;
				$purchasereturnquantity = '';
				$dccustomerquantity = '';
				$dcsupplierquantity = '';
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$purchasequantity = round($purchasequantity, 4);
				$totalpurchasequantity = $totalpurchasequantity + $purchasequantity;

				$salesamount = '';
				$salesreturnamount = '';
				$purchaseamount =  $sumamount;
				$purchasereturnamount = '';
				$dccustomeramount = '';
				$dcsupplieramount = '';
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totalpurchaseamount = $totalpurchaseamount + $purchaseamount;
				$totalpurchaseamount = number_format($totalpurchaseamount, 2, '.', '');
				
			}
			if ($transactionmodule == 'PURCHASE RETURN')
			{
				$salesquantity = '';
				$salesreturnquantity = '';
				$purchasequantity = '';
				$purchasereturnquantity = $sumquantity;
				$dccustomerquantity = '';
				$dcsupplierquantity = '';
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$purchasereturnquantity = round($purchasereturnquantity, 4);
				$totalpurchasereturnquantity = $totalpurchasereturnquantity + $purchasereturnquantity;

				$salesamount = '';
				$salesreturnamount = '';
				$purchaseamount = '';
				$purchasereturnamount = $sumamount;
				$dccustomeramount = '';
				$dcsupplieramount = '';
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totalpurchasereturnamount = $totalpurchasereturnamount + $purchasereturnamount;
				$totalpurchasereturnamount = number_format($totalpurchasereturnamount, 2, '.', '');
				
			}
			if ($transactionmodule == 'DC CUSTOMER')
			{
				$salesquantity = '';
				$salesreturnquantity = '';
				$purchasequantity = '';
				$purchasereturnquantity = '';
				$dccustomerquantity = $sumquantity;
				$dcsupplierquantity = '';
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$dccustomerquantity = round($dccustomerquantity, 4);
				$totaldccustomerquantity = $totaldccustomerquantity + $dccustomerquantity;

				$salesamount = '';
				$salesreturnamount = '';
				$purchaseamount = '';
				$purchasereturnamount = '';
				$dccustomeramount = $sumamount;
				$dcsupplieramount = '';
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totaldccustomeramount = $totaldccustomeramount + $dccustomeramount;
				$totaldccustomeramount = number_format($totaldccustomeramount, 2, '.', '');
				
			}
			if ($transactionmodule == 'DC SUPPLIER')
			{
				$salesquantity = '';
				$salesreturnquantity = '';
				$purchasequantity = '';
				$purchasereturnquantity = '';
				$dccustomerquantity = '';
				$dcsupplierquantity = $sumquantity;
				$adjustmentaddquantity = '';
				$adjustmentminusquantity = '';
				$dcsupplierquantity = round($dcsupplierquantity, 4);
				$totaldcsupplierquantity = $totaldcsupplierquantity + $dcsupplierquantity;

				$salesamount = '';
				$salesreturnamount = '';
				$purchaseamount = '';
				$purchasereturnamount = '';
				$dccustomeramount = '';
				$dcsupplieramount = $sumamount;
				$adjustmentaddamount = '';
				$adjustmentminusamount = '';
				$totaldcsupplieramount = $totaldcsupplieramount + $dcsupplieramount;
				$totaldcsupplieramount = number_format($totaldcsupplieramount, 2, '.', '');
				
			}
			if ($transactionmodule == 'ADJUSTMENT')
			{
				$salesquantity = '';
				$salesreturnquantity = '';
				$purchasequantity = '';
				$purchasereturnquantity = '';
				$dccustomerquantity = '';
				$dcsupplierquantity = '';
				if ($res2transactionparticular == 'BY ADJUSTMENT ADD')
				{
					$adjustmentaddquantity = $sumquantity;
					$adjustmentminusquantity = '';
					$adjustmentaddquantity = round($adjustmentaddquantity, 4);
					$totaladjustmentaddquantity = $totaladjustmentaddquantity + $adjustmentaddquantity;
				}
				if ($res2transactionparticular == 'BY ADJUSTMENT MINUS')
				{
					$adjustmentaddquantity = '';
					$adjustmentminusquantity = $sumquantity;
					$adjustmentminusquantity = round($adjustmentminusquantity, 4);
					$totaladjustmentminusquantity = $totaladjustmentminusquantity + $adjustmentminusquantity;
				}
			}
			else
			{	
				$quantity = '0';
			}
			
			
			if ($searchoption1 == 'DETAILED')
			{
				$quantity = $res2['quantity'];
				$stockdate = $res2['transactiondate'];
				$stockremarks = $res2['remarks'];
				$transactionparticular = $res2['transactionparticular'];
			}
			if ($searchoption1 == 'CUMULATIVE')
			{
				$quantity = $res2['sumquantity'];
			} 
			$quantity = round($quantity, 4);
			
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
			
			$sno = $sno + 1;
			
			$totalquantity = $totalquantity + $quantity;
			
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $sno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $categoryname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemcode.' - '.$itemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                <div align="right"><?php echo $purchaseamount; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo $purchasequantity; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                <div align="right"><?php echo $purchasereturnamount; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo $purchasereturnquantity; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
			  <?php echo $stockdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="left"><?php echo $transactionparticular; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left">
			  <?php echo $stockremarks; ?>
			  </div></td>
            </tr>
            <?php
			$sumamount = '';
			$sumquantity = '';
			$salesquantity = '';
			$salesreturnquantity = '';
			$purchasequantity = '';
			$purchasereturnquantity = '';
			$adjustmentaddquantity = '';
			$adjustmentminusquantity = '';
			$purchasereturnquantity = '';
			$totalpurchasereturnquantity = '';
			
			$salesamount = '';
			$salesreturnamount = '';
			$purchaseamount = '';
			$purchasereturnamount = '';
			$adjustmentaddamount = '';
			$adjustmentminusamount = '';
			$totalpurchasereturnamount = '';
			$totalpurchasereturnamount = '';

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
                bgcolor="#ecf0f5"><div align="right"><strong>Total Quantity</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div class="style1">
                <div align="right"><?php echo $totalpurchaseamount; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div class="style1">
                <div align="right"><?php echo $totalpurchasequantity; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div class="style1">
                <div align="right"><?php echo $totalpurchasereturnamount; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div class="style1">
                <div align="right"><?php echo $totalpurchasereturnquantity; ?></div>
              </div></td>
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
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
  <tr>
    <td valign="top">    
  <tr>
    <td width="99%" valign="top">    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>