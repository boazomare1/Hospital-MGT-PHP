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

if (isset($_REQUEST["searchoption1"])) { $searchoption1 = $_REQUEST["searchoption1"]; } else { $searchoption1 = ""; }
//$searchoption1 = $_REQUEST['searchoption1'];

if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
//$itemcode = $_REQUEST['itemcode'];
if (isset($_REQUEST["itemname"])) { $searchitemname = $_REQUEST["itemname"]; } else { $searchitemname = ""; }
//$searchitemname = $_REQUEST['itemname'];
if ($searchitemname != '')
{
	$arraysearchitemname = explode('||', $searchitemname);
	$itemcode = $arraysearchitemname[0];
	$itemcode = trim($itemcode);
	$searchoption1 = 'DETAILED';
}
//echo $searchoption1;

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
	
/*	if (document.stockinward.itemcode.value == "")
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
*/
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

<body onLoad="return funcCustomerDropDownSearch1();">
<table width="2000" border="0" cellspacing="0" cellpadding="2">
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
    <td width="1%" rowspan="3" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
		
			<form name="stockinward" action="costofpharmacysalesreport.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return process1()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="5" bgcolor="#ecf0f5" class="bodytext31"><strong>Sales Margin Report</strong></td>
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
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A; text-align:left" size="50" autocomplete="off">
            <input name="searchbutton12" type="submit" id="searchbutton12" style="border: 1px solid #001E6A" value="Search Item Name" /></td>
        </tr>
        <tr>
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="itemcode" id="itemcode">
				<?php
				if ($itemcode != '')
				{
				$query43 = "select * from master_itempharmacy where itemcode = '$itemcode' and status <> 'DELETED'";
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die ("Error in Query43".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res43 = mysqli_fetch_array($exec43);
				?>
				<option value="<?php echo $itemcode; ?>" selected="selected"><?php echo $res43['itemcode'].' - '.$res43['itemname']; ?></option>
				<option value="">All Items</option>
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
          </select>
		  <input name="customername" type="hidden" id="customername" style="border: 1px solid #001E6A; text-align:left">
		  <input name="suppliername" type="hidden" id="suppliername" style="border: 1px solid #001E6A; text-align:left"></td>
          </tr>
        <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
        <td width="372" align="left" valign="center"  bgcolor="#ffffff">
	  
		<!--	<select name="searchoption1" id="searchoption1">
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
			</select>-->		
		  
			</td>
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
    </form>		
	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31"><a 
                  href="#"></a></td>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31"><a 
                  href="#"></a></td>
              
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Code </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
              
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Unit Purchase Price </strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total Sales  Qty </strong></div></td>
              
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total Purchase Price </strong></div></td>
              
              </tr>
            <?php
			if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
			//$categoryname = $_REQUEST['categoryname'];
			if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
			//$searchitemname = $_REQUEST['itemname'];
			if (isset($_REQUEST["suppliername"])) { $suppliername = $_REQUEST["suppliername"]; } else { $suppliername = ""; }
			//$searchitemname = $_REQUEST['itemname'];
			
			$colorloopcount = '';
			$sno = '';
			$totalquantity = '';
			$stockdate = '';
			$transactionparticular = '';
			$stockremarks = '';
			$partyname = '';
			$totalsalesmargin = '';

			//echo $searchoption1;
			//if ($searchoption1 = '')
			//{
			
			$query2 = "select * from master_stock where itemcode like '%$itemcode%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2anum = $res2['auto_number'];
			$itemcode = $res2['itemcode'];
			$itemname = $res2['itemname'];
			$transactionmodule = $res2['transactionmodule'];
			$res2transactionparticular = $res2['transactionparticular'];
			
			$query3 = "select * from master_itempharmacy where itemcode = '$itemcode' and categoryname like '%$categoryname%' and status <> 'DELETED'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount3 = mysqli_num_rows($exec3);
			if ($rowcount3 > 0)
			{
			$res3 = mysqli_fetch_array($exec3);
			$packageanum = $res3['packageanum'];
			
		    $query4 = "select * from master_packagepharmacy where auto_number = '$packageanum'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$quantityperpackage = $res4['quantityperpackage'];
			
			$unitsalesprice = $res3['rateperunit'];
			@$unitsalesprice = $unitsalesprice/$quantityperpackage;
			$unitsalesprice = number_format($unitsalesprice, 2, '.', '');
			
			$unitpurchaseprice = $res3['purchaseprice'];
			@$unitpurchaseprice = $unitpurchaseprice/$quantityperpackage;
			$unitpurchaseprice = number_format($unitpurchaseprice, 2, '.', '');
			
			$query5 = "select sum(quantity) as sumsalestotalquantity from pharmacysales_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$sumsalestotalquantity = $res5['sumsalestotalquantity'];
			$sumsalestotalquantity = round($sumsalestotalquantity, 2);
			
			$totalsalesprice = $sumsalestotalquantity * $unitsalesprice;
			$totalsalesprice = number_format($totalsalesprice, 2, '.', '');
			
			$totalpurchaseprice = $sumsalestotalquantity * $unitpurchaseprice;
			$totalpurchaseprice = number_format($totalpurchaseprice, 2, '.', '');
			
			$salesmargin = $totalsalesprice - $totalpurchaseprice;
			$salesmargin = number_format($salesmargin, 2, '.', '');
			
			$totalsalesmargin = $totalsalesmargin + $totalpurchaseprice;
			$totalsalesmargin = number_format($totalsalesmargin, 2, '.', '');
			
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $sno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemname; ?></div></td>
              
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo $unitpurchaseprice; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo $sumsalestotalquantity; ?></div>
              </div></td>
              
              <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                  <div align="right"><?php echo $totalpurchaseprice; ?></div>
              </div></td>
              
              </tr>
            <?php
			}
			
			}
			
			//}
			?>
			<!--<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div class="style1">
                <div align="right"><?php //echo $totaldcoutwardcustomerquantity; ?></div>
              </div></td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div class="style1">
                <div align="right"><?php //echo $totalsalesreturnquantity; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div class="style1">
                <div align="right"><?php //echo $totalpurchasequantity; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div class="style1">
                <div align="right"><?php //echo $totalpurchasereturnquantity; ?></div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div class="style1">
                <div align="right"><?php //echo $totaldcinwardcustomerquantity; ?></div>
              </div></td>-->
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total Quantity</strong></td>
			 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div class="style1">
                <div align="right"><?php echo $totalsalesmargin; ?></div>
              </div></td>
              
              
             
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
    <td width="98%" valign="top">    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>