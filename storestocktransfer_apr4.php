<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];


$docno = $_SESSION['docno'];
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
		
						
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);

$res1location = $res1["locationname"];
$locationcode = $res1["locationcode"];
$query2 = "select ms.store,ms.storecode from master_store AS ms LEFT JOIN master_location AS ml ON ms.location=ml.auto_number WHERE ml.locationcode = '".$locationcode."'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);

 $res2storename = $res2["store"];
 $res2storecode = $res2["storecode"];


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
//here get location name and code for inserting
$locationnameget=isset($_REQUEST['locationname'])?$_REQUEST['locationname']:'';
$locationcodeget=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$storecode=isset($_REQUEST['tostore'])?$_REQUEST['tostore']:'';

//ends here
$requestdocno = $_REQUEST['requestdocno'];
$fromstore = $_REQUEST['fromstore'];
$tostore = $_REQUEST['tostore'];
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

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
	//echo $billnumbercode;
	$billnumbercode1 = intval($billnumbercode1);
	$billnumbercode1 = $billnumbercode1 + 1;

	$maxanum1 = $billnumbercode1;
	
	
	$billnumbercode1 = 'ITRN-'.$maxanum1;
	$openingbalance1 = '0.00';
	//echo $companycode;
}
	
	$locationcode = $_REQUEST['locationcode'];
	$locationname = $_REQUEST['locationname'];
	
	for($i=1;$i<50;$i++)
	{
		if(isset($_REQUEST['serialnumber'.$i]))
		{
		$serialnumber = $_REQUEST['serialnumber'.$i];
		
			if($serialnumber != '')
			{
			   
		$medicinename=$_REQUEST['medicinename'.$i];
		$medicinename=trim($medicinename);
		$medicinecode=$_REQUEST['medicinecode'.$i];
		$transferquantity = $_REQUEST['transferqty'.$i];
		$batch = $_REQUEST['batch'.$i];
		$expdate = $_REQUEST['expdate'.$i];
		$avlquantity = $_REQUEST['avlquantity'.$i];
		$tnxquantity = $_REQUEST['tnxquantity'.$i];
		$rate = $_REQUEST['costprice'.$i];
		$amount = $_REQUEST['amount'.$i];
		$itemcode = $medicinecode;
		$store = $fromstore;
		$batchname = $batch;
		
		include('autocompletestockbatch.php');
		$currentstock = $currentstock;
		$fromstorequantitybeforetransfer = $currentstock;
		$fromstorequantityaftertransfer = $currentstock - $tnxquantity;
		
		$store = $tostore;
		$itemcode = $itemcode;
		include('autocompletestockbatch.php');
		$currentstock = $currentstock;
		$tostorequantitybeforetransfer = $currentstock;
		$tostorequantityaftertransfer = $currentstock + $tnxquantity;
		
			$query31 = "select * from master_itempharmacy where itemcode = '$medicinecode'"; 
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			
			$categoryname = $res31['categoryname'];
		
			if($medicinename!="" && $batchname!='' && $tnxquantity>'0')
		{
		
	$medicinequery2="insert into master_stock_transfer(docno,fromstore,tostore,itemcode,itemname,transferquantity,batch,fromstorequantitybeforetransfer,fromstorequantityaftertransfer,tostorequantitybeforetransfer,tostorequantityaftertransfer,rate,amount,username,ipaddress,companyanum,recordstatus,entrydate,categoryname,locationname,locationcode,tolocationname,tolocationcode)
	values('$billnumbercode1','$fromstore','$tostore','$medicinecode','$medicinename','$tnxquantity','$batch','$fromstorequantitybeforetransfer','$fromstorequantityaftertransfer','$tostorequantitybeforetransfer','$tostorequantityaftertransfer','$rate','$amount','$username','$ipaddress','$companyanum','completed','$updatedatetime','$categoryname','$locationname','$locationcode','$locationname','$locationcode')";
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		//$query55 = "update master_internalstockrequest set recordstatus = 'completed' where docno = '$requestdocno' and itemcode='$medicinecode' ";
		//$exec55 = mysql_query($query55) or die(mysql_error());
		}
		
		}
		
		}
		/*else
		{
			$query55 = "update master_internalstockrequest set recordstatus = 'discarded' and itemcode='$medicinecode' where docno = '$requestdocno'";
			$exec55 = mysql_query($query55) or die(mysql_error());
		}*/
		}
		header("location:mainmenu1.php");
		exit;
}

?>
<?php

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$docno = $_REQUEST['docno'];
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	
	$query3 = "update master_internalstockrequest set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	header("location:storestocktransfer.php");

}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'ITRN-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_stock_transfer order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ITRN-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'ITRN-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

?>
<?php
/*$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];*/
$query23 = "select * from master_employeelocation where username='$username' and locationcode = '$locationcode'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['locationcode'];
$location = $res23['locationname'];
$locationanum = $res23['locationanum'];

/*$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];
*/
$res7storeanum = $res23['storecode'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];
$storecode = $res75['storecode'];

?>
<script>
function funcOnLoadBodyFunctionCall()
{

		funcstoreDropDownSearch4();
		funcCustomerDropDownSearch4();
	
	
}
function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	

}
</script>
<script>
function validcheck()
{
if(confirm("Are You Want To Save The Record?")==false){return false;}	
}

function medicinecheck()
{
if(document.cbform1.tostore.value=="")
	{
		alert("Please Select the store");
		document.cbform1.tostore.focus();
		return false;
	}

	
	
	return true;
	
}
function amountcalc(serial)
{
var serial = serial;
var transferqty = document.getElementById("transferqty").value;
var batch = document.getElementById("batch").value;
if(batch == '')
{
alert("Please Select Batch");
document.getElementById("transferqty").value = 0;

document.getElementById("amount").value = 0.00;

return false;
}
var reqquantity = document.getElementById("reqquantity").value;
if(parseInt(transferqty) > parseInt(reqquantity))
{
alert("Transfer Quantity cannot be morethan Requested Quantity");
document.getElementById("transferqty").value = 0;

document.getElementById("amount").value = 0.00;

return false;
}

var availqty = document.getElementById("availablestock").value;
if(parseInt(transferqty) > parseInt(availqty))
{
alert("Transfer Quantity cannot be morethan Available Quantity");
document.getElementById("transferqty").value = 0;

document.getElementById("amount").value = 0.00;

return false;
}

var costprice = document.getElementById("costprice").value;
if(costprice == "")
{
var costprice = 0.00;
}
var amount = parseFloat(transferqty) * parseFloat(costprice);
document.getElementById("amount").value = amount.toFixed(2);
}
function valid()
{
//alert("hi");
var numrows = document.getElementById("numrows").value;
for(i=1;i<=numrows;i++)
{
	var batch = document.getElementById("batch"+i+"").value;
	if(batch=='')
	{
	 alert("Select Batch");
	 return false;
	}
}
//return false;
}

function funcDeleteMedicine(varPaymentTypeAutoNumber)
{
    var varPaymentTypeAutoNumber = varPaymentTypeAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varPaymentTypeAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Payment Type Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Payment Type Entry Delete Not Completed.");
		return false;
	}
	//return false;

}

function functioncheckstore()
{
	if(document.getElementById("fromstore").value=='')
	{
		alert("Please Select From Store");
		document.getElementById("fromstore").focus();
		return false;
		}
	}

function functiontostock(id)
{
	var tostore= document.getElementsByClassName('tostore');
	
	var cnt=parseInt(tostore.length);
	
	for(var i=0; i < cnt; i++)
	{
		tostore[i].style.display='block';
		
		}
		
	document.getElementById(id).style.display='none';
	return true;
	}

</script>
<script type="text/javascript">
function funcmedicinesearch4()
{

}


</script>
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<?php include("js/dropdownlist1scriptingtostore.php"); ?>
<script type="text/javascript" src="js/autocomplete_store.js"></script>
<script type="text/javascript" src="js/autosuggeststore.js"></script>

<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>


<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine_1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>

<script type="text/javascript" src="js/insertnewitemrequestmedicine_1.js"></script>
<script type="text/javascript" src="js/batchselectionscript_1.js"></script>
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
text-align:center;
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bali
{
text-align:right;
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

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
		
		
              <form name="cbform1" method="post" action="storestocktransfer.php" onSubmit="return validcheck()">
                <table width="1197" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="3" bgcolor="#ecf0f5" class="bodytext32"><strong>Store Stock transfer </strong></td>
                      <td colspan="5" bgcolor="#ecf0f5" class="bodytext32"><strong>Location : </strong><?php echo $res1location;?></td>
                    </tr>
                    <tr>
                      <td width="54" align="left" valign="middle"  class="bodytext32">Doc No &nbsp;&nbsp;
                      
                        <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="<?php echo $billnumbercode; ?>" size="8" autocomplete="off" readonly>
                        <input type="hidden" name="location" id="location" value="<?php echo $res7locationanum; ?>">
                        <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
                        <input type="hidden" name="locationname" id="locationname" value="<?php echo $res1location; ?>">
                        <input type="hidden" name="requestdocno" value="<?php echo $docno; ?>">
                      </span></td>
                      <td width="47" align="left" valign="middle" class="bodytext32"><strong>From </strong></td>
                      <td width="112" align="left" valign="middle" class="bodytext32">
                       <select name="fromstore" id="fromstore" onChange="functiontostock(this.value)">
			  <option value="">Select Store</option>
			 <?php
			 $queryy2 = "select ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$locationcode."' and me.username = '".$username."' ";
				$execy2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryy2) or die ("Error in queryy2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($resy2 = mysqli_fetch_array($execy2))
				{
					
					//$res2itemcode = $res2['itemcode'];
					$res2store = $resy2['storecode'];
					$res2storename = $resy2['store'];
					?>
					<option value="<?php echo $res2store; ?>"><?php echo $res2storename; ?></option>
				<?php
				}
				?>
			  </select>
             </td>
                      <td width="55" align="middle" valign="middle" class="bodytext32"><strong>To </strong></td>
                      <td colspan="2" align="left" valign="middle" class="bodytext32">
                         <select name="tostore" id="tostore">
			  <option value="">Select Store</option>
			 <?php
			  $query2 = "select * from master_store where location = '$locationanum' and recordstatus <> 'Deleted' order by store";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res2 = mysqli_fetch_array($exec2))
				{
					//$res2itemcode = $res2['itemcode'];
					$res2store = $res2['storecode'];
					$res2storename = $res2['store'];
					?>
					<option value="<?php echo $res2store; ?>" id="<?php echo $res2store; ?>" class="tostore"><?php echo $res2storename; ?></option>
				<?php
				}
				?>
			  </select>
						 </td>
                      <input name="searchtostore1hiddentextbox" id="searchtostore1hiddentextbox" type="hidden" value="">
                      <input name="searchtostoreanum1" id="searchtostoreanum1" value="" type="hidden">
                      <td width="120" align="middle" valign="middle"><span class="bodytext32">Date</span></td>
					  <td align="left" valign="top"><span class="bodytext32">&nbsp;
					    <input name="date" type="text" id="date" style="border: 1px solid #001E6A;" value="<?php echo $updatedatetime; ?>" size="8" autocomplete="off" readonly>
					  </span></td>
                    </tr>
                
                    <tr>
                      <td align="left" valign="left" class="bodytext32" bgcolor="#ecf0f5"><strong>Item</strong></td>
                      <td align="left" valign="left" class="bodytext32" bgcolor="#ecf0f5"><strong>Batch</strong></td>
                      <td align="left" valign="left" class="bodytext32" bgcolor="#ecf0f5"><strong>Exp.Dt</strong></td>
                      <td width="52" align="left" valign="left" bgcolor="#ecf0f5" class="bodytext32"><strong>Avl.Qty</strong></td>
                      <td width="44" align="left" valign="left" bgcolor="#ecf0f5" class="bodytext32"><strong>Trn.Qty</strong></td>
                      <td align="center" valign="left" class="bodytext32" bgcolor="#ecf0f5"><strong>Cost</strong></td>
                      <td width="50" align="left" valign="left" bgcolor="#ecf0f5" class="bodytext32"><strong>Amount</strong></td>
					  <td align="center" valign="left" class="bodytext32" bgcolor="#ecf0f5"><strong></strong></td>
                    </tr>
					<tbody id="insertrow">
					</tbody>
                   <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                        <td><input name="medicinename" type="text" id="medicinename" size="35" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()" onClick="functioncheckstore()"></td>
								   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
			
						<input name="avlquantity" type="hidden" id="avlquantity" size="8"></td>
                      <td align="left" valign="top"><select name="batch[]" id="batch" 
                      onChange="return funcbatchselection(this.value)">
                          <option value="" selected="selected">Select Batch</option>
                      </select></td>
                      <td align="left" valign="left"><input type="text" name="expirydate[]" id="expirydate" class="bal" size="10" readonly></td>
					  <td align="left" valign="left"><input type="text" name="availablestock[]" id="availablestock" class="bal" size="10" readonly></td>
                      <td align="left" valign="left"><input type="hidden" name="reqquantity[]" id="reqquantity" class="bal" size="10" readonly>
                     <input type="text" name="transferqty[]" id="transferqty" size="6" onKeyUp="return amountcalc();"></td>
                      <td align="left" valign="left" class="bodytext32"><input type="text" id="costprice" name="cost[]" class="bal" value="" readonly></td>
                      <td align="left" valign="left"><input type="text" name="amount[]" id="amount" class="bal" size="10" readonly></td>
					<td width="118"><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					
					 </tr>
                    
                    <tr>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
					 </tr>
                  <td align="left" valign="middle" class="bodytext32"></td>
                      <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                   
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">
					<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" onClick="return medicinecheck();"/>
						                        </td>
					<td align="left" valign="top">
				</td>
                  </tr>
                </table>
              </form>		</td>
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

