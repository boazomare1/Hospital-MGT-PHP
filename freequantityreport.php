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
$number = '';

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
$number = 10;
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
<script type="text/javascript" src="js/autocomplete_item1.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<script src="js/datetimepicker_css.js"></script>
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




</script>

<body onLoad="return funcCustomerDropDownSearch1();">
<table width="1901" border="0" cellspacing="0" cellpadding="2">
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
		
		
			<form name="stockinward" action="freequantityreport.php" method="post" onKeyDown="return disableEnterKey()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="5" bgcolor="#ecf0f5" class="bodytext31"><strong>Free Quantity Items</strong></td>
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
          <td width="77" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
          <td width="681" colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
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
          </select>
		  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1"></td>
          <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
          </tr>
		   <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> <strong>Date From</strong> </td>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
			  <input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>
              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong> Date To</strong> </td>
              <td align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
			  </span></td>
            </tr>
		  <tr>
		  
				<td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
				
				<input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" />	</td>			
				</tr>
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="itemcode2" id="itemcode2" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $itemcode; ?>" size="10" readonly="readonly" /></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">&nbsp;		  </td>
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
              <td width="12%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
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
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Per Unit </strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Per Pack</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff"   class="bodytext31"><strong>Item Code </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff"   class="bodytext31"><strong>Item Name </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff"   class="bodytext31"><strong>Category</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff"   class="bodytext31"><strong>Package</strong></td>
				<td align="left" valign="center"  
                bgcolor="#ffffff"   class="bodytext31"><strong>Free Quantity </strong></td>
                
              <td align="left" valign="center"  
                bgcolor="#ffffff"  class="bodytext31"><div align="right"><strong>Selling Price</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total SP </strong></div></td>
              <td align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>PurchasePrice</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> TotalPP </strong></td>
            </tr>
            <?php
			
			
			if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
			//$categoryname = $_REQUEST['categoryname'];
			
			if (isset($_REQUEST["movingitemselection"])) { $movingitemselection = $_REQUEST["movingitemselection"]; } else { $movingitemselection = ""; }
			//echo $movingitemselection;
			
			$movingitemquery = '';
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
			
			$totalpurchaseprice1 = '';
			$totalitemrate1 = '';
			$totalcurrentstock1  = '';
			if($number ==10)
			{
			//To fetch qunatity of sales from pharmacysales_details for filtering non moving items.
			$query3 = "select * from purchase_details where itemfreequantity <> '0.0000' and itemname like '%$searchitemname%' and itemcode like '%$itemcode%' and entrydate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED'";// itemcode = '$itemcode' and";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
		    $itemcode = $res3['itemcode'];
			$itemname = $res3['itemname'];
			$packageanum = $res3['packageanum'];
			$itemfreequantity = $res3['itemfreequantity'];
			$salesprice = $res3['salesprice'];
			
			$query4 = "select * from master_medicine where itemcode = '$itemcode'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4categoryname = $res4['categoryname'];
			
			$query5 ="select * from master_packagepharmacy where auto_number = '$packageanum'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 =mysqli_fetch_array($exec5);
			$res5packagename = $res5['packagename'];
			
			$query6 ="select * from master_itempharmacy where itemcode = '$itemcode'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 =mysqli_fetch_array($exec6);
			$res6purchaseprice = $res6['purchaseprice'];
			
			$totalitemrate = $salesprice * $itemfreequantity;
			$totalpurchaseprice = $res6purchaseprice * $itemfreequantity;
			
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
			
			//$totalitemrate = $itemrate * $res3sumquantity;
			//$totalitemrate = number_format($totalitemrate, 2, '.', '');
			
			//$totalpurchaseprice = $purchaseprice * $currentstock;
			//$totalpurchaseprice = $itempurchaserate * $res3sumquantity;
			//$totalpurchaseprice = number_format($totalpurchaseprice, 2, '.', '');
			
			//$totalcurrentstock1 = $totalcurrentstock1 + $currentstock;
			
			$totalitemrate1 = $totalitemrate1 + $totalitemrate;
			$totalitemrate1 = number_format($totalitemrate1, 2, '.', '');
			
			$totalpurchaseprice1 = $totalpurchaseprice1 + $totalpurchaseprice;
			$totalpurchaseprice1 = number_format($totalpurchaseprice1, 2, '.', '');

			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $itemname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="left"><?php echo $res4categoryname; ?>&nbsp;</div>
              </div></td>
              <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                  <div align="left"><?php echo $res5packagename; ?>&nbsp;</div>
              </div></td>
			   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                  <div align="left"><?php echo round($itemfreequantity, 2) ; ?>&nbsp;</div>
              </div></td>
              
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31">
			    <div align="right"><?php echo $salesprice; ?>&nbsp;</div>
			  </div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31">
			    <div align="right"><?php echo $totalitemrate; ?>&nbsp;</div>
			  </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo $res6purchaseprice; ?>&nbsp;</div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
                  <div align="right"><?php echo $totalpurchaseprice; ?>&nbsp;</div>
              </div></td>
            </tr>
            <?php
			$currentstock = '';
			$itemrate = '';
			$totalitemrate = '';
	         }
			}
				
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>Total Stock </strong></div></td>
              
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $totalcurrentstock1; ?>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo $totalitemrate1; ?></strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo $totalpurchaseprice1; ?>&nbsp;</strong></div></td>
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
    <td width="97%" valign="top">    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>