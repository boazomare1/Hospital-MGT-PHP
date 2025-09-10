<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$totalitemrate1 = '';


//To populate the autocompetelist_services1.js
include ("autocompletebuild_item1pharmacy.php");

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
//$searchitemname = $_REQUEST['itemname'];
if ($searchitemname != '')
{
	$arraysearchitemname = explode('||', $searchitemname);
	$itemcode = $arraysearchitemname[0];
	$itemcode = trim($itemcode);
}


if (isset($_REQUEST["expiryyear"])) { $expiryyear = $_REQUEST["expiryyear"]; } else { $expiryyear = ""; }
if (isset($_REQUEST["expirymonth"])) { $expirymonth = $_REQUEST["expirymonth"]; } else { $expirymonth = ""; }
//echo $expirymonth;
//echo $expiryyear;


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

function process1()
{
	if (document.stockinward.searchoption1.value == "")
	{
		alert ("Please Select Search Option.")
		return false;
	}
}


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
		
		
			<form name="stockinward" action="stockreportbyexpirydate1.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return process1()">
			  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="5" bgcolor="#ecf0f5" class="bodytext31"><strong>Expiry Stock Report</strong></td>
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
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="categoryname" id="categoryname">
            <?php
			$categoryname = $_REQUEST['categoryname'];
			if ($categoryname != '')
			{
			?>
            <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
            <option value="">Show All Category</option>
            <?php
			}
			else
			{
			?>
            <option selected="selected" value="">Show All Category</option>
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
          </select></td>
        </tr>
		
        <tr>
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Search</strong></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A; text-align:left" size="50" autocomplete="off">
            <input name="searchbutton12" type="submit" id="searchbutton12" style="border: 1px solid #001E6A" value="Search Item Name" /></td>
        </tr>
        <tr>
          <td width="157" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="itemcode" id="itemcode">
            <option selected="selected" value="">All Items</option>
 				<?php
				if ($itemcode != '')
				{
				$query43 = "select * from master_itempharmacy where itemcode = '$itemcode' and status <> 'DELETED'";
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die ("Error in Query43".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res43 = mysqli_fetch_array($exec43);
				?>
				<option value="<?php echo $itemcode; ?>" selected="selected"><?php echo $res43['itemcode'].' - '.$res43['itemname']; ?></option>
				<?php
				}
				else
				{
				?>
				<option selected="selected" value="">All Items</option>
				<?php
				}
				?>
           <?php
				$query42 = "select itemcode, itemname from master_itempharmacy where status <> 'DELETED' order by itemname";
				$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res42 = mysqli_fetch_array($exec42))
				{
				$itemcode42 = $res42['itemcode'];
				$itemname42 = $res42['itemname'];
				?>
            <option value="<?php echo $itemcode42; ?>"><?php echo $itemcode42.' - '.$itemname42; ?></option>
            <?php
				}
				?>
          </select>		  </td></tr>
		  <tr>
          <td width="157" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Expiry Month / Year </strong></td>
          <td width="53" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="expirymonth" id="expirymonth">
            <?php
				if ($expirymonth != '')
				{
				?>
            <option value="<?php echo $expirymonth; ?>" selected="selected"><?php echo $expirymonth; ?></option>
            <?php
				}
				else
				{
				?>
            <option value="<?php echo date('m'); ?>"><?php echo date('m'); ?></option>
            <?php
				}
				?>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select></td>
          <td width="6" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">/</td>
          <td width="267" align="left" valign="center"  bgcolor="#ffffff"><span class="style1"><span class="bodytext31">
            <select name="expiryyear" id="expiryyear">
              <?php
				if ($expiryyear != '')
				{
				?>
              <option value="<?php echo $expiryyear; ?>" selected="selected"><?php echo $expiryyear; ?></option>
              <?php
				}
				else
				{
				?>
              <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
              <?php
				}
				?>
              <?php
				for ($i=2013; $i<=2020; $i++)
				{
				?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php
				}
				?>
            </select>
          </span></span></td>
         <td width="277" align="left" valign="center"  bgcolor="#ffffff">&nbsp;</td>
        </tr>
		 <tr>
		 <td align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right">
		  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
		  <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1"></div></td>
        <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
          <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td></tr>
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="itemcode2" id="itemcode2" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $itemcode; ?>" size="10" readonly="readonly" /></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1043" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="22%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="16%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="15%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Code </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch No </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Expiry Month </td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Name </strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Quantity. </strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Unit Price</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total Price </strong></div></td>
            </tr>
			
			
			
            <?php
			if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
			if ($frmflag1 == 'frmflag1')
			{			
			
			if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
			//$categoryname = $_REQUEST['categoryname'];
			$expirydate = '';
			$colorloopcount = '';
			$sno = '';
			$totalquantity = '';
			$stockdate = '';
			$transactionparticular = '';
			$stockremarks = '';
			$suppliername = '';
			$batchnumber = '';

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
			
			$totalpurchaseprice1 = '';
			$totalitemrate1 = '';
			$totalcurrentstock1  = '';

			//$query2 = "select * from master_stock where itemcode like '%$itemcode%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
			$query2 = "select * from master_itempharmacy where itemcode like '%$itemcode%' and categoryname like '%$categoryname%' and status <> 'DELETED' order by itemname";// limit 0,100 ";//limit 0,100";// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			
			$res2anum = $res2['auto_number'];
			$itemcode = $res2['itemcode'];
			$itemname = $res2['itemname'];
			$res2categoryname = $res2['categoryname'];
			$purchaseprice = $res2['purchaseprice']; //Unit price is calculated below.
			$itemrate = $res2['rateperunit']; //Unit price is calculated below.
			//$stockdate = $res2['transactiondate'];
			//$stockremarks = $res2['remarks'];
			//$transactionparticular = $res2['transactionparticular'];
			$itempackageanum = $res2['packageanum'];
			$res2packagename = $res2['packagename'];
			$res2packagename = stripslashes($res2packagename);
			
			//To calculate price for packaged items to divide by number of items count.
			$query31 = "select * from master_packagepharmacy where auto_number = '$itempackageanum'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$quantityperpackage = $res31['quantityperpackage']; //Value called for purchase calc.
			
			@$itemrate = $itemrate / $quantityperpackage;
			$itemrate = number_format($itemrate, 2, '.', '');
			@$itempurchaserate = $purchaseprice / $quantityperpackage;
			$itempurchaserate = number_format($itempurchaserate, 2, '.', '');
		
			$query1 = "select sum(quantity) as sumsales from pharmacysales_details where itemcode = '$itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalsales = $res1['sumsales'];
			
			$query1 = "select sum(quantity) as sumsalesreturn from pharmacysalesreturn_details where itemcode = '$itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalsalesreturn = $res1['sumsalesreturn'];
			
			$query1 = "select sum(quantity) as sumpurchase from purchase_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalpurchase = $res1['sumpurchase'];
			$totalpurchase = $totalpurchase * $quantityperpackage;
			
			$query1 = "select sum(quantity) as sumpurchasereturn from purchasereturn_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalpurchasereturn = $res1['sumpurchasereturn'];
			
			$query1 = "select sum(quantity) as sumdccustomer from dccustomer_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totaldccustomer = $res1['sumdccustomer'];
			
			$query1 = "select sum(quantity) as sumdcsupplier from dcsupplier_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totaldcsupplier = $res1['sumdcsupplier'];
			
			$query1 = "select sum(quantity) as sumadjustmentadd from master_stock where itemcode = '$itemcode' and 
			transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT ADD' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalsumadjustmentadd = $res1['sumadjustmentadd'];
			
			$query1 = "select sum(quantity) as sumadjustmentminus from master_stock where itemcode = '$itemcode' and 
			transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT MINUS' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$totalsumadjustmentminus = $res1['sumadjustmentminus'];
			
			$query1 = "select*from master_stock where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$suppliername = $res1['suppliername'];
			
			$currentstock = $totalpurchase;
			$currentstock = $currentstock - $totalpurchasereturn;
			$currentstock = $currentstock - $totalsales;
			$currentstock = $currentstock + $totalsalesreturn;
			$currentstock = $currentstock - $totaldccustomer;
			$currentstock = $currentstock + $totaldcsupplier;
			$currentstock = $currentstock + $totalsumadjustmentadd;
			$currentstock = $currentstock - $totalsumadjustmentminus;
			
			
			if ($currentstock != 0)
			{
			
			//To Find Expiry Drugs On Current Stock.
			$query1batch = "select * from purchase_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum' group by batchnumber";
			$exec1batch = mysqli_query($GLOBALS["___mysqli_ston"], $query1batch) or die ("Error in Query1batch".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1batch = mysqli_fetch_array($exec1batch))
			{
				$res1batchnumber = $res1batch['batchnumber'];
				$res1expirydate = $res1batch['expirydate'];
				$res1expirydatearray = explode('-', $res1expirydate);
				$res1expiryyear = $res1expirydatearray[0];
				$res1expirymonth = $res1expirydatearray[1];
				$res1expirydate = $res1expirymonth.'/'.$res1expiryyear;
				
				
				$query2batch = "select sum(allpackagetotalquantity) as sumpurchasetotalquantity from purchase_details where itemcode = '$itemcode' and batchnumber ='$res1batchnumber' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
				$exec2batch = mysqli_query($GLOBALS["___mysqli_ston"], $query2batch) or die ("Error in Query2batch".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2batch = mysqli_fetch_array($exec2batch);
				$sumpurchasetotalquantity = $res2batch['sumpurchasetotalquantity'];
				
				$query2batch = "select sum(quantity) as sumpurchasereturntotalquantity from purchasereturn_details where itemcode = '$itemcode' and batchnumber ='$res1batchnumber' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
				$exec2batch = mysqli_query($GLOBALS["___mysqli_ston"], $query2batch) or die ("Error in Query2batch".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2batch = mysqli_fetch_array($exec2batch);
				$sumpurchasereturntotalquantity = $res2batch['sumpurchasereturntotalquantity'];
				
				$query2batch = "select sum(quantity) as sumsalestotalquantity from pharmacysales_details where itemcode = '$itemcode' and batchnumber ='$res1batchnumber' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
				$exec2batch = mysqli_query($GLOBALS["___mysqli_ston"], $query2batch) or die ("Error in Query2batch".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2batch = mysqli_fetch_array($exec2batch);
				$sumsalestotalquantity = $res2batch['sumsalestotalquantity'];
				
				$query2batch = "select sum(quantity) as sumsalesreturntotalquantity from pharmacysalesreturn_details where itemcode = '$itemcode' and batchnumber ='$res1batchnumber' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
				$exec2batch = mysqli_query($GLOBALS["___mysqli_ston"], $query2batch) or die ("Error in Query2batch".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2batch = mysqli_fetch_array($exec2batch);
				$sumsalesreturntotalquantity = $res2batch['sumsalesreturntotalquantity'];
				
				$batchtotalsales = $sumsalestotalquantity - $sumsalesreturntotalquantity;
				$batchtotalpurchase = $sumpurchasetotalquantity - $sumpurchasereturntotalquantity;
				
				$batchcurrentstock = $batchtotalpurchase - $batchtotalsales;
			}
			
			
			$totalitemrate = $itemrate * $currentstock;
			$totalitemrate = number_format($totalitemrate, 2, '.', '');
			
			//$totalpurchaseprice = $purchaseprice * $currentstock;
			$totalpurchaseprice = $itempurchaserate * $currentstock;
			$totalpurchaseprice = number_format($totalpurchaseprice, 2, '.', '');
			
			$totalcurrentstock1 = $totalcurrentstock1 + $currentstock;
			
			$totalitemrate1 = $totalitemrate1 + $totalitemrate;
			$totalitemrate1 = number_format($totalitemrate1, 2, '.', '');
			
			$totalpurchaseprice1 = $totalpurchaseprice1 + $totalpurchaseprice;
			$totalpurchaseprice1 = number_format($totalpurchaseprice1, 2, '.', '');
			
			$query50 = "select * from purchase_details where itemname = '$itemname' and recordstatus <> 'DELETED' and companyanum = '$companyanum' group by batchnumber";
			$exec50= mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die ("Error in Query50".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res50 = mysqli_fetch_array($exec50);
			$batchnumber = $res50['batchnumber'];
			
			$expirymonth = $expirymonth;
			if ($expirymonth == '') $expirymonth = date('m');
			$expiryyear = $expiryyear;
			if ($expiryyear == '') $expiryyear = date('Y');
			$expirymonthyear = $expirymonth.'/'.$expiryyear;
			//echo $expirymonthyear;
			//echo $res1expirydate;
			//echo '<br>';
			
			if ($res1expirydate == $expirymonthyear)
			{
			
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
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left" 
                ><?php echo $sno; ?></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31"><?php echo $itemcode; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31"><?php echo $itemname; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31">
                <div align="left"><?php echo $batchnumber; ?>&nbsp;</div>
              </div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31">
                <div align="left"><?php echo $res1expirydate; ?>&nbsp;</div>
              </div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="right">
                <div class="bodytext31">
                  <div align="left"><?php echo $suppliername; ?>&nbsp;</div>
                </div>
              </div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31">
                <div align="left"><?php echo $currentstock; ?>&nbsp;</div>
              </div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31">
                <div align="right"><?php echo $itemrate; ?>&nbsp;</div>
              </div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31">
                <div align="right"><?php echo $totalitemrate; ?>&nbsp;</div>
              </div></td>
            </tr>
          <?php /*?>  <?php
			$currentstock = '';
			$itemrate = '';
			$totalitemrate = '';
			?>
			<?php 
			$query50 = "select * from purchase_details where itemname = '$itemname' and recordstatus <> 'DELETED' and companyanum = '$companyanum' group by batchnumber";
			$exec50= mysql_query($query50) or die ("Error in Query50".mysql_error());
			while ($res50 = mysql_fetch_array($exec50))
			{
			$itemname = $res50['itemname'];
			$batchnumber = $res50['batchnumber'];
			$expirydate = $res50['expirydate'];
			
			?>		
			<?php 
			}
			?><?php */?>
			<?php
			}
			
			}
			
			}
			
			}
			
			?>


            <tr>
			 <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo $totalcurrentstock1; ?>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo $totalitemrate1; ?>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><!--Total Price--> </strong></div></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php //echo $totalitemrate1; ?>&nbsp;</strong></div></td>
				
            </tr>
          </tbody>
        </table>	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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