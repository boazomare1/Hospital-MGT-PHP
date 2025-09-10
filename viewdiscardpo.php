<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
$currenttime = date("H:i:s");

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{}

?>
<?php 
if(isset($_REQUEST['itemcode']))
{
}
?>
<?php
if(isset($_REQUEST['billnumber']))
{
$pono = $_REQUEST['billnumber'];
$query55 = "select * from purchaseorder_details where billnumber='$pono'";
$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55=mysqli_fetch_array($exec55);
$suppliername = $res55['suppliername'];
$suppliercode = $res55['suppliercode'];
$remarks = $res55['remarks'];

$query66 = "select * from master_supplier where suppliercode='$suppliercode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$addressname = $res66['address1'];
$address = $addressname;
$addressname1 = $res66['address2'];
if($addressname1 != '')
{
$address = $address.','.$addressname1;
}
$area = $res66['area'];
if($area != '')
{
$address = $address.','.$area;
}
$city = $res66['city'];
if($city !='')
{
$address = $address.','.$city;
}
$state = $res66['state'];
if($state !='')
{
$address = $address.','.$state;
}
$country = $res66['country'];
if($country !='')
{
$address = $address.','.$country;
}
$telephone2 = $res66['mobilenumber'];
$tele=$telephone2;
$telephone = $res66['phonenumber1'];
if($telephone != '')
{
$tele=$tele.','.$telephone;
}
$telephone1 = $res66['phonenumber2'];
if($telephone1 != '')
{
$tele=$tele.','.$telephone1;
}

$email = $res66['emailid1'];
$email1 = $res66['emailid2'];
if($email1 != '')
{
$email = $email.','.$email1;
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
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<?php include("autocompletebuild_medicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestmedicine1.js"></script>
<?php include("js/dropdownlist1scriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autocomplete_medicine1.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch5.js"></script>
<script type="text/javascript" src="js/insertnewitem32.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}
function calc()
{
var reqqty=document.getElementById("reqqty").value;
var packsize=document.getElementById("packsize").value;

var packvalue=packsize.substring(0,packsize.length - 1);
var rate=document.getElementById("rate").value;
var amount=parseFloat(reqqty) * parseFloat(rate);
document.getElementById("amount").value=amount.toFixed(2);
var pkgqty=reqqty/packvalue;
packvalue=parseInt(packvalue);
if(reqqty < packvalue)
{
pkgqty=1;
}


document.getElementById("pkgqty").value=Math.round(pkgqty);
}
</script>

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


function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch4();
	funcPopupPrintFunctionCall();
	
}
function btnDeleteClick10(delID4,vrate4)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal;
	//alert(delID4);
	var varDeleteID4= delID4;
	//alert(vrate4);
	
	//alert(rateref);
	//alert (varDeleteID3);
	var fRet7; 
	fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet7 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child4 = document.getElementById('idTR'+varDeleteID4);  
	//alert (child3);//tr name
    var parent4 = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child4);
	
	var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name
    var parent4 = document.getElementById('insertrow'); // tbody name.
	
	if (child4 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child4);
	}

	var currenttotal=document.getElementById('total').value;
	//alert(currenttotal);
	newtotal= currenttotal-vrate4;
	
	//alert(newtotal);
	
	document.getElementById('total').value=newtotal.toFixed(2);
		
}
function amountcalc(varserialnumber)
{
var varserialnumber= varserialnumber;
var receivedquantity = document.getElementById("packagequantity"+varserialnumber+"").value;
var packsize=document.getElementById("packagename"+varserialnumber+"").value;
var packvalue=packsize.substring(0,packsize.length - 1);
packvalue=parseInt(packvalue);
var totalquantity=parseInt(receivedquantity) * parseInt(packvalue);
document.getElementById("totalquantity"+varserialnumber+"").value = totalquantity;

var rate = document.getElementById("rate"+varserialnumber+"").value;
if(receivedquantity != '')
{
var amount = parseFloat(totalquantity) * parseFloat(rate);
}
document.getElementById("existamount"+varserialnumber+"").value = amount.toFixed(2);
}

function deletevalid()
{
var del;
del=confirm("Do You want to delete this medicine ?");
if(del == false)
{
return false;
}
}
</script>
<script>
function calculate(serial)
{
var serial = serial;
var reqqty=document.getElementById("totalquantity"+serial+"").value;
var packsize=document.getElementById("packagename"+serial+"").value;
var packvalue=packsize.substring(0,packsize.length - 1);
var pkgqty=reqqty/packvalue;
packvalue=parseInt(packvalue);
if(reqqty < packvalue)
{
pkgqty=1;
}
document.getElementById("packagequantity"+serial+"").value=Math.round(pkgqty);
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bal
{
border-style:none;
background:none;
text-align:right;
FONT-FAMILY: Tahoma;
FONT-SIZE: 11px;
}
-->
</style>
</head>

<body onLoad="return funcOnLoadBodyFunctionCall();">
<form method="post" name="form1" action="viewpo.php">
<?php 
$query34="select * from purchase_indent where approvalstatus='approved' and pogeneration=''";
		$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw1=mysqli_num_rows($exec34);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            
			<?php
			if ($st == 'success' && $billautonumber != '')
			{
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
              <td colspan="8"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage1('<?php echo $billautonumber; ?>')" value="Click Here To Print Invoice" class="button" style="border: 1px solid #001E6A"/>			  </td>
              <td width="1%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
			<?php
			}
			?>
			  <tr>
			    <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>PO No</strong></td>
                <td width="23%" align="left" valign="top" class="bodytext3"><?php echo $pono; ?>
				<input type="hidden" name="pono" id="pono" value="<?php echo $pono; ?>" style="border: 1px solid #001E6A;" size="10" autocomplete="off" readonly/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Date</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $currentdate; ?>
				<input type="hidden" name="date" id="date" value="<?php echo $currentdate; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" readonly/>				</td>
			    </tr>
				<tr>
			    <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>
                <td width="23%" align="left" valign="top" class="bodytext3"><?php echo $suppliername; ?> & <?php echo $suppliercode; ?>
				<input type="hidden" name="suppliername" id="suppliername" value="<?php echo $suppliername; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Telephone</strong></td>
                <td width="16%" align="left" valign="top" class="bodytext3"><?php echo $tele; ?>
				<input type="hidden" name="telephone" id="telephone" value="<?php echo $tele; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly/>                  </td>
			    </tr>
				<tr>
			   <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Address</strong></td>
                <td width="23%" align="left" valign="top" class="bodytext3"><?php echo $address; ?>
				<input type="hidden" name="address" value="<?php echo $address; ?>"></td>
				   <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Email</strong></td>
				  <td width="16%" align="left" valign="top" class="bodytext3"><?php echo $email; ?>
				<input type="hidden" name="email" id="email" value="<?php echo $email; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly/>                  </td>
			
			    </tr>
				<tr>
				  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
				</tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="23%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Item</strong></div></td>
				 <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pack Size</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ord.Qty</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Tot.Qty</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
              </tr>
			
            
			<?php
			$colorloopcount = '';
			$sno = '';
		$query34="select * from purchaseorder_details where billnumber='$pono' and recordstatus='deleted' group by itemname";
		$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num34 = mysqli_num_rows($exec34);
		while($res34=mysqli_fetch_array($exec34))
			{
			$totalquantity =0;
			$totalpieces =0;
			$amount = 0;
			$itemname=$res34['itemname'];
			$itemcode=$res34['itemcode'];
			$medpack=$res34['packsize'];
			$query35="select * from purchaseorder_details where billnumber='$pono' and recordstatus='deleted' and itemname='$itemname'";
		$exec35=mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res35=mysqli_fetch_array($exec35))
		{
		$packagequantity=$res35['packagequantity'];
		$piecequantity=$res35['quantity'];
		$amt = $res35['totalamount'];
		$amount = $amount + $amt;
		$totalquantity=$totalquantity+$packagequantity;
		$totalpieces = $totalpieces+$piecequantity;
	}
			$query77 = "select * from master_medicine where itemcode='$itemcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$rate = $res77['purchaseprice'];
			if($medpack == '')
			{
			$medpack = $res77['packagename'];
			}
		
		$amount=number_format($amount,2,'.','');
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
			    <div align="left"><?php echo $itemname; ?></div></td>
				<input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>">
				<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">
				<td class="bodytext31" valign="center"  align="center"><?php echo $medpack; ?>
				</td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalquantity; ?><input type="hidden" readonly name="packagequantity[]" id="packagequantity<?php echo $sno ;?>" size="6" value="<?php echo $totalquantity; ?>" onKeyUp="return amountcalc('<?php echo $sno ;?>');"></div></td>
				<td class="bodytext31" valign="center"  align="left"> <div align="center"><input type="text" size="6" name="totalquantity[]" id="totalquantity<?php echo $sno ;?>" value="<?php echo $totalpieces; ?>" class="bal" readonly></div></td>
				<td class="bodytext31" valign="center"  align="left"> <div align="center"><input type="text" size="12" name="existamount[]" id="existamount<?php echo $sno ;?>" value="<?php echo $amount; ?>" class="bal" readonly></div></td>
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
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><a href="viewdiscardpurchaseorder.php"><strong>Back</strong></a></td>
              </tr>
          </tbody>
        </table></td>
      </tr>
     </table>
</table>
</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>

