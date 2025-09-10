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

$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];


$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

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

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchsuppliername = $_POST['medicinename'];
	//echo $searchsuppliername;
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("||", $searchsuppliername);
		$arraysuppliercode = $arraysupplier[0];
		$arraysuppliername = $arraysupplier[1];
		$arraysuppliername = trim($arraysuppliername);
		
		
		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		$openingbalance = $res1['openingbalance'];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
	}

	//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];

}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if ($frmflag2 == 'frmflag2')
{
    $itemname=$_REQUEST['itemname'];
	$itemcode=$_REQUEST['itemcode'];
	$remarks=$_REQUEST['remarks'];
	$store=$_REQUEST['storename'];
	$tostore=$_REQUEST['tostore2'];
	$adjustmentdate=date('Y-m-d');
	
			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$categoryname = $res31['categoryname'];

$paynowbillprefix1 = 'ITRN-';
$paynowbillprefix12=strlen($paynowbillprefix1);
$query23 = "select * from master_stock_transfer order by auto_number desc limit 0, 1";
$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$billnumber1 = $res23["docno"];
$billdigit1=strlen($billnumber1);
if ($billnumber1 == '')
{
	$billnumbercode1 ='ITRN-'.'1';
	$openingbalance1 = '0.00';
}
else
{
	$billnumber1 = $res23["docno"];
	$billnumbercode1 = substr($billnumber1,$paynowbillprefix12, $billdigit1);
	$billnumbercode1 = intval($billnumbercode1);
	$billnumbercode1 = $billnumbercode1 + 1;
	$maxanum1 = $billnumbercode1;
	$billnumbercode1 = 'ITRN-'.$maxanum1;
	$openingbalance1 = '0.00';
}
	foreach($_POST['batch'] as $key => $value)
		{
		$batchnumber=$_POST['batch'][$key];
		$quantity=$_POST['quantity'][$key];
		$query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
	$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res40 = mysqli_fetch_array($exec40);
	$rateperunit = $res40['rateperunit'];
	$amount=$rateperunit * $quantity;
		
	$medicinequery2="insert into master_stock_transfer(docno,fromstore,tostore,itemcode,itemname,transferquantity,batch,rate,amount,username,ipaddress,companyanum,location,recordstatus,entrydate,categoryname)
	values('$billnumbercode1','$store','$tostore','$itemcode','$itemname','$quantity','$batchnumber','$rateperunit','$amount','$username','$ipaddress','$companyanum','$location','completed','$updatedatetime','$categoryname')";
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}
	header("location:stocktransferadjustment.php");
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

function cbsuppliername1()
{
	document.cbform1.submit();
}

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("medicinename"), new StateSuggestions());        
}



</script>
<?php include("autocompletebuild_med.php"); ?>
<script type="text/javascript" src="js/autosuggestmed.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_med.js"></script>
<script type="text/javascript">


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


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

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
		return false;
	}
	else
	{
		return true;
	}

}

function paymententry1process2()
{
	if (document.getElementById("medicinename").value == "")
	{
		alert ("Enter The Medicine Name");
		document.getElementById("medicinename").focus();
		return false;
	}
	if (document.getElementById("store").value == "")
	{
		alert ("Please Select From Store");
		document.getElementById("store").focus();
		return false;
	}
		if (document.getElementById("tostore").value == "")
	{
		alert ("Please Select To Store");
		document.getElementById("tostore").focus();
		return false;
	}

	
}


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
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
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
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="stocktransferadjustment.php" onSubmit="return paymententry1process2()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Store Transfer </strong></td>
              </tr>
          
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Drug </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="medicinename" type="text" id="medicinename" style="border: 1px solid #001E6A;" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
            <tr>
              <td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Drug </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input value="<?php echo $cbsuppliername; ?>" name="cbsuppliername" type="text" id="cbsuppliername" readonly="readonly" onKeyDown="return disableEnterKey()" size="50" style="border: 1px solid #001E6A"></td>
              </tr>
			  <tr>
              <td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> From Store </td>
              <td colspan="" align="left" valign="top"  bgcolor="#FFFFFF">			  
			  <select name="store" id="store">
			   <?php
			$store = $_REQUEST['store'];
			if ($store != '')
			{
			?>
            <option value="<?php echo $store; ?>" selected="selected"><?php echo $store; ?></option>
            <option value=""> Select Store </option>
            <?php
			}
			else
			{
			?>
		  <option selected="selected" value="">Select Store</option>
		  <?php
		  }
		  ?>
		   <?php
		        $query44 = "select * from master_employee where status = 'Active' and username = '$username' ";
				$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res44 = mysqli_fetch_array($exec44);
			    $res44store = $res44['store'];
				$res44showlocations= $res44['showlocations'];
				
			 if($res44showlocations == 'on')
				  {
				$query42 = "select * from master_store where recordstatus <> 'DELETED' group by store order by store";
				  }
				  else
				  {	
				  $query42 = "select * from master_store where auto_number = '$res44store' and recordstatus <> 'DELETED' group by store order by store";
                  }				$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res42 = mysqli_fetch_array($exec42))
				{
				$stores = $res42['store'];
				$storecodes = $res42['storecode'];
				?>
            <option value="<?php echo $stores; ?>"><?php echo $stores; ?></option>
            <?php
				}
				?>
			  
			  </select>
			  </td>
			  
              <td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">To Store </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">			  
			  <select name="tostore" id="tostore">
			   <?php
			$tostore = $_REQUEST['tostore'];
			if ($tostore != '')
			{
			?>
            <option value="<?php echo $tostore; ?>" selected="selected"><?php echo $tostore; ?></option>
            <option value=""> Select Store </option>
            <?php
			}
			else
			{
			?>
		  <option selected="selected" value="">Select Store</option>
		  <?php
		  }
		  ?>
		   <?php
		        $query44 = "select * from master_employee where status = 'Active' and username = '$username' ";
				$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res44 = mysqli_fetch_array($exec44);
			    $res44store = $res44['store'];
				$res44showlocations= $res44['showlocations'];
				
			 if($res44showlocations == 'on')
				  {
				$query42 = "select * from master_store where recordstatus <> 'DELETED' group by store order by store";
				  }
				  else
				  {	
				  $query42 = "select * from master_store where auto_number = '$res44store' and recordstatus <> 'DELETED' group by store order by store";
                  }				$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res42 = mysqli_fetch_array($exec42))
				{
				$tostore = $res42['store'];
				$tostorecodes = $res42['storecode'];
				?>
            <option value="<?php echo $tostore; ?>"><?php echo $tostore; ?></option>
            <?php
				}
				?>
			  
			  </select>
			  </td>
			  
			  
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
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
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="stocktransferadjustment.php">	
		
<?php
	$colorloopcount=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchsuppliername = $_POST['medicinename'];
	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$store = $_POST['store'];
	
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("||", $searchsuppliername);
			$arraysuppliercode = $arraysupplier[0];
		$arraysuppliername = $arraysupplier[1];
		$arraysuppliername = trim($arraysuppliername);
		
		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		$openingbalance = $res1['openingbalance'];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
		$itemcode=$arraysuppliercode;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
	}
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext311"><strong><?php echo $suppliername; ?></strong></td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
           </tr>
            <tr>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>
				  <td width="6%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Medicine Code</strong></td>
              <td width="20%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Medicine </strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Batch </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Stock </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Quantity </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong></strong></div></td>
             
  </tr>
           <?php
             $sno=0;
			 $i=0;
					
			
			$query41="select * from purchase_details where itemcode='$itemcode' group by batchnumber";
			$exec41=mysqli_query($GLOBALS["___mysqli_ston"], $query41);
			$numb41=mysqli_num_rows($exec41);
			while($res41=mysqli_fetch_array($exec41))
			{
			$batchname = $res41['batchnumber']; 
			$companyanum = $_SESSION["companyanum"];
			$itemcode = $itemcode;
			$batchname = $batchname;
	include ('autocompletestockbatch.php');
	$currentstock = $currentstock;

if($currentstock != 0 )
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

			//if ($balanceamount != 0.00)
			//{
			?>
           <tr<?php echo $colorcode; ?>>
		     <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?></td>
			   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $itemcode; ?></td>
				<input type="hidden" name="itemcode" value="<?php echo $itemcode; ?>">
				<input type="hidden" name="storename" value="<?php echo $store; ?>">
				<input type="hidden" name="tostore2" value="<?php echo $tostores= $_REQUEST['tostore'];; ?>">
				
				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $suppliername; ?></td>
				<input type="hidden" name="itemname" value="<?php echo $suppliername; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $batchname; ?></td>
				<input type="hidden" name="batch[]" id="batch" value="<?php echo $batchname; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $currentstock; ?></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" size="6" name="quantity[]" id="quantity"></td>
<!--			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" size="6" name="minusstock[]" id="minusstock"></td>
-->			
		   </tr>
		   <?php 
		   } 
		   }
		   ?>
           
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
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($totalpurchaseamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
      
			</tr>
			<tr>
			<td align="left" valign="middle" class="bodytext3">&nbsp;</td>
			<td align="left" valign="middle" class="bodytext3"><strong>Remarks</strong></td>
			<td align="left" valign="middle" class="bodytext3"><textarea cols="30" name="remarks"></textarea></td>
			</tr>
			<tr>
			
			  <td colspan="7" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right">  <input type="hidden" name="frmflag2" value="frmflag2">
                      <input name="Submit" type="submit"  value="Save" class="button" style="border: 1px solid #001E6A"/>
                  </td>
           
			</tr>
          </tbody>
        </table>
<?php
}

?>	
		
		
		
		
		
		</td>
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

