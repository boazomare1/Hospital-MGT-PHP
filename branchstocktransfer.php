<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$datetimeonly = date("Y-m-d H:i:s");

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
$tolocation=isset($_REQUEST['tolocation'])?$_REQUEST['tolocation']:'';

	//ends here
	$requestdocno = $_REQUEST['requestdocno'];

	$fromlocationcode = $locationcode;
	$tolocationcode = $tolocation;
	
	$query56 = "select * from master_location where locationcode='$fromlocationcode'";
	$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res56 = mysqli_fetch_array($exec56);
	$fromlocationname = $res56['locationname'];

	$query56 = "select * from master_location where locationcode='$tolocationcode'";
	$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res56 = mysqli_fetch_array($exec56);
	$tolocationname = $res56['locationname'];

	$index = array(); 
	for($j=1;$j<50;$j++)
	{	
		if(isset($_REQUEST['serialnumber'.$j]))
		{
			$serialnumber = $_REQUEST['serialnumber'.$j];
		
			if($serialnumber != '')
			{
			$medicinename=$_REQUEST['medicinename'.$j];
			$medicinename=trim($medicinename);
			$medicinecode=$_REQUEST['medicinecode'.$j];
			$medicinecode=trim($medicinecode);
			//$transferquantity = $_REQUEST['transferqty'.$j];
			$batch = $_REQUEST['batch'.$j];
			$expdate = $_REQUEST['expdate'.$j];
			$avlquantity = $_REQUEST['avlquantity'.$j];
			$tnxquantity = $_REQUEST['tnxquantity'.$j];
			$rate = $_REQUEST['costprice'.$j];
			$amount = $_REQUEST['amount'.$j];
			$fromstorename = $_REQUEST['fromstorename'.$j];
			$fromstorecode = $_REQUEST['fromstorecode'.$j];
			$tostore = $_REQUEST['tostore'.$j];
			$tostorecode = $_REQUEST['tostorecode'.$j];
			$index[$j]=array($medicinename,$medicinecode, $batch,$expdate, $avlquantity,$tnxquantity, $rate,$amount,$fromstorename,$fromstorecode,$tostore,$tostorecode);	
			
			}
		}
	}
	
			// Function to group by a specific key within each inner array
			function groupByStore($array) {
				$result = [];
				foreach ($array as $item) {
					$storeKey = $item[9]; // Assuming the 'STO' column is at index 5
					if (!isset($result[$storeKey])) {
						$result[$storeKey] = [];
					}
					$result[$storeKey][] = $item;
				}
				return $result;
			}

			// Grouping by 'STO' column (assuming it's at index 5 in each inner array)
			$groupedData = groupByStore($index);
			
			 // Iterate through the grouped array
				foreach ($groupedData as $vale => $items) {
				
				$query_bill_location = "select auto_number from master_location where locationcode = '$locationcode'";
				$exec_bill_loctation = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill_location) or die ("Error in Query_bill_location".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				$res_bill_loct = mysqli_fetch_array($exec_bill_loctation);
				$location_num = $res_bill_loct['auto_number'];
				$query_bill = "select prefix from bill_formats where description = 'Branch_stocktransfer'";
				$exec_bill = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill) or die ("Error in Query_bill".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				$res_bill = mysqli_fetch_array($exec_bill);
				$consultationprefix = $res_bill['prefix'];
				$consultationprefix1=strlen($consultationprefix);
				$query23 = "select * from branch_stock_transfer order by auto_number desc limit 0, 1";
				$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res23 = mysqli_fetch_array($exec23);
				$billnumber1 = $res23["docno"];
				$billdigit1=strlen($billnumber1);
				if ($billnumber1 == '')
				{
					$billnumbercode1 =$consultationprefix."-".'1'."-".date('y')."-".$location_num;
					$openingbalance1 = '0.00';
				}
				else
				{
					$billnumber1 = $res23["docno"];
					//$billnumbercode1 = substr($billnumber1,$paynowbillprefix12, $billdigit1);
					//echo $billnumbercode;
					$pieces = explode('-', $billnumber1);
					$new_billnum=$pieces[1];
					$billnumbercode1 = intval($new_billnum);
					$billnumbercode1 = $billnumbercode1 + 1;
					$maxanum1 = $billnumbercode1;
					$billnumbercode1 = $consultationprefix."-".$maxanum1."-".date('y')."-".$location_num;
					$openingbalance1 = '0.00';
					//echo $companycode;
				}				
					foreach ($items as $item) {
					
					//$index[$j]=array($medicinename,$medicinecode, $batch,$expdate, $avlquantity,$tnxquantity, $rate,$amount,$fromstorename,$fromstorecode,$tostore,$tostorecode);
					$values = explode(', ', implode(', ', $item));
					$exp_medicienname=$values[0];
					$exp_mediciencode=$values[1];
					$exp_batch=$values[2];
					$exp_expdate=$values[3];
					$exp_avlquantity=$values[4];
					$exp_txnquantity=$values[5];
					$exp_rate=$values[6];
					$exp_amount=$values[7];
					$exp_fromstorename=$values[8];
					$exp_fromstorecode=$values[9];
					$exp_tostore=$values[10];
					$exp_tostorecode=$values[11];
					$fifo_code=$exp_batch;
					
					
					$querybatstock2 = "select batch_quantity,batchnumber from transaction_stock where batch_stockstatus='1' and itemcode='$exp_mediciencode' and locationcode='$fromlocationcode' and fifo_code='$fifo_code' and storecode ='$exp_fromstorecode'";
					$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resbatstock2 = mysqli_fetch_array($execbatstock2);
					$bat_quantity = $resbatstock2["batch_quantity"];
					$batchnumber = $resbatstock2["batchnumber"];
					$currentstock = $bat_quantity;
					$fromstorequantitybeforetransfer = $currentstock;
					$fromstorequantityaftertransfer = $currentstock - $exp_txnquantity;
					
					$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$exp_mediciencode' and locationcode='$tolocationcode' and fifo_code='$fifo_code' and storecode ='$exp_tostorecode'";
					$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resbatstock2 = mysqli_fetch_array($execbatstock2);
					$bat_quantity = $resbatstock2["batch_quantity"];
					$currentstock = $bat_quantity;
					$tostorequantitybeforetransfer = $currentstock;
					$tostorequantityaftertransfer = $currentstock + $exp_txnquantity;

					$query31 = "select * from master_itempharmacy where itemcode = '$exp_mediciencode'"; 
					$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res31 = mysqli_fetch_array($exec31);
					$categoryname = $res31['categoryname'];

					if($exp_medicienname!="" && $batchnumber!='' && $exp_txnquantity>'0')
					{
					$querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$exp_mediciencode' and locationcode='$fromlocationcode'";
					$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$rescumstock2 = mysqli_fetch_array($execcumstock2);
					$cum_quantity = $rescumstock2["cum_quantity"];
					$cum_quantity = $cum_quantity-$exp_txnquantity;

					if($cum_quantity=='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}
					
					if($cum_quantity>=0)
					{
					$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$exp_mediciencode' and locationcode='$fromlocationcode' and fifo_code='$fifo_code' and storecode ='$exp_fromstorecode'";
					$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resbatstock2 = mysqli_fetch_array($execbatstock2);
					$bat_quantity = $resbatstock2["batch_quantity"];
					$bat_quantity = $bat_quantity-$exp_txnquantity;

					if($bat_quantity=='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}
					if($bat_quantity>=0)
					{
					$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$exp_mediciencode' and locationcode='$fromlocationcode' and storecode='$exp_fromstorecode' and fifo_code='$fifo_code'";
					$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

					$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$exp_mediciencode' and locationcode='$fromlocationcode'";
					$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

					$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
					batchnumber, batch_quantity,transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)
					values ('$fifo_code','master_stock_transfer','$exp_mediciencode', '$exp_medicienname', '$dateonly','0', 'Stock Transfer From', 
					'$batchnumber', '$bat_quantity', '$exp_txnquantity','$cum_quantity', '$billnumbercode1', '','$cum_stockstatus','$batch_stockstatus', '$fromlocationcode','','$exp_fromstorecode', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$exp_rate','$exp_amount')";
					$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$medicinequery2="insert into branch_stock_transfer(docno,fromstore,tostore,itemcode,itemname,transferquantity,batch,fromstorequantitybeforetransfer,fromstorequantityaftertransfer,tostorequantitybeforetransfer,tostorequantityaftertransfer,rate,amount,username,ipaddress,companyanum,recordstatus,entrydate,categoryname,locationname,locationcode,tolocationname,tolocationcode,fifo_code)values('$billnumbercode1','$exp_fromstorecode','$exp_tostorecode','$exp_mediciencode','$exp_medicienname','$exp_txnquantity','$batchnumber','$fromstorequantitybeforetransfer','$fromstorequantityaftertransfer','$tostorequantitybeforetransfer','$tostorequantityaftertransfer','$exp_rate','$exp_amount','$username','$ipaddress','$companyanum','pending','$updatedatetime','$categoryname','$fromlocationname','$fromlocationcode','$tolocationname','$tolocationcode','$fifo_code')";
					$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					}
					}
					}
					}
				}
	
		//exit;
		//header("location:mainmenu1.php");
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
///$paynowbillprefix = 'ITRN-';
//$paynowbillprefix1=strlen($paynowbillprefix);


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

$query_bill_location = "select auto_number from master_location where locationcode = '$locationcode'";
$exec_bill_loctation = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill_location) or die ("Error in Query_bill_location".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill_loct = mysqli_fetch_array($exec_bill_loctation);
$location_num = $res_bill_loct['auto_number'];
$query_bill = "select prefix from bill_formats where description = 'Branch_stocktransfer'";
$exec_bill = mysqli_query($GLOBALS["___mysqli_ston"], $query_bill) or die ("Error in Query_bill".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res_bill = mysqli_fetch_array($exec_bill);
$consultationprefix = $res_bill['prefix'];
$consultationprefix1=strlen($consultationprefix);
$query2 = "select * from branch_stock_transfer order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$consultationprefix."-".'1'."-".date('y')."-".$location_num;
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	//$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$pieces = explode('-', $billnumber);
	$new_billnum=$pieces[1];
	$billnumbercode = intval($new_billnum);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;
	$billnumbercode =$consultationprefix."-".$maxanum."-".date('y')."-".$location_num;
	$openingbalance = '0.00';
	//echo $companycode;
}

?>
<script>
function funcOnLoadBodyFunctionCall()
{

		//funcstoreDropDownSearch4();
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
	
	var removeval=document.getElementById("amount"+varDeleteID).value;
	var grandtot=document.getElementById("grandtot").value;
	var addingtoval=parseFloat(grandtot.replace(/,/g,''))-parseFloat(removeval);
	addingtoval = parseFloat(addingtoval).toFixed(2);
	addingtoval = addingtoval.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("grandtot").value=addingtoval;
	
	
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
	if(document.getElementById("tolocation").value=='')
	{
		alert("Please Select To Location");
		document.getElementById("tolocation").focus();
		return false;
	}
}

function functiontostock(id)
{
	/*var tostore= document.getElementsByClassName('tostore');
	
	var cnt=parseInt(tostore.length);
	
	for(var i=0; i < cnt; i++)
	{
		tostore[i].style.display='block';
		
		}
		
	document.getElementById(id).style.display='none';
	return true;*/
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
<?php //include("js/dropdownlist1scriptingtostore.php"); ?>
<!--<script type="text/javascript" src="js/autocomplete_store.js"></script>
<script type="text/javascript" src="js/autosuggeststore.js"></script>-->

<?php //include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<!--<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> 
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>-->

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine_1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>
<script type="text/javascript" src="js/autosuggestbatch1.js"></script>

<script type="text/javascript" src="js/insertnewitemrequestmedicine_1_branch.js"></script>
<script type="text/javascript" src="js/batchselectionscript_1_branch.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  

<script>
function validate(){

	if(document.getElementById("tolocation").value=='')
	{
		alert("Please Select To Location");
		document.getElementById("tolocation").focus();
		return false;
	}

	if(!($('#insertrow').find('tr').length > 0))
	{
		
	alert("Add atleast one item");
	return false;
	}
	$('#savebutton').prop('disabled','disabled');

}
function medicinecheck()
{
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Cancelled");
		return false;
	}
	
	
	return true;
	
}


</script>

      
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
.bal1
{
border-style:none;
background:none;
text-align:right;
font-weight: bold;
 FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
		
		
              <form name="cbform1" method="post" action="branchstocktransfer.php" onSubmit="return validate();">
                <table width="86%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="8" bgcolor="#ecf0f5" class="bodytext32"><strong>Branch Stock transfer </strong></td>
                      <td colspan="5" bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="50" align="left" valign="middle"  class="bodytext32"><strong>Doc No</strong> &nbsp;&nbsp;</td>
                      <td align="left" class="bodytext3">
                        <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="<?php echo $billnumbercode; ?>" size="11" autocomplete="off" readonly>
                        <input type="hidden" name="locationanum" id="locationanum" value="<?php echo $res7locationanum; ?>">
                        <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
                        <input type="hidden" name="locationname" id="locationname" value="<?php echo $res1location; ?>">
                        <input type="hidden" name="requestdocno" value="<?php echo $docno; ?>">
						                        <input type="hidden" name="typetransfer" id="typetransfer" value="transfer">

                      </span></td>
					  <td align="left" class="bodytext3"><strong>From Location</strong></td>
					  <td align="left" class="bodytext3"><select name="location" id="location" >
					
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select></td>
                      <!--<td width="47" align="left" valign="middle" class="bodytext32"><strong>From Store</strong></td>
                      <td width="112" align="left" valign="middle" class="bodytext32">
                       <select name="fromstore" id="fromstore">
			  <option value="">Select Store</option>
			  </select>
             </td>-->
			 <td align="left" class="bodytext3"><strong>To Location</strong></td>
					  <td align="left" class="bodytext3"><select name="tolocation" id="tolocation" >
                  	 <option value="">Select Location</option>
				  <?php
						
						$query1 = "select * from master_location where status <> 'deleted' and locationcode!='$locationcode' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" id="<?php echo $res1locationanum; ?>" class="tolocation"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select></td>
                      <!--<td width="55" align="middle" valign="middle" class="bodytext32"><strong>To Store</strong></td>
                      <td colspan="2" align="left" valign="middle" class="bodytext32">
                         <select name="tostore" id="tostore">
			  <option value="" >Select Store</option>
			  </select>
						 </td>-->
                      <input name="searchtostore1hiddentextbox" id="searchtostore1hiddentextbox" type="hidden" value="">
                      <input name="searchtostoreanum1" id="searchtostoreanum1" value="" type="hidden">
                      <td width="" align="middle" valign="middle"><span class="bodytext32"><strong>Date</strong></span></td>
					  <td align="left" valign="top"><span class="bodytext32">&nbsp;
					    <input name="date" type="text" id="date" style="border: 1px solid #001E6A;" value="<?php echo date('d/m/Y', strtotime($updatedatetime)); ?>" size="8" autocomplete="off" readonly>
					  </span></td>
                    </tr>
					</tbody>
					</table>
                <table width="86%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
					<tr><td>&nbsp;</td></tr>
                    <tr>
                      <td align="left" valign="left" class="bodytext32" bgcolor="#ecf0f5"><strong>Item</strong></td>
                      <td align="left" valign="left" class="bodytext32" bgcolor="#ecf0f5"><strong>From Store</strong></td>
                      <td align="left" valign="left" class="bodytext32" bgcolor="#ecf0f5"><strong>To Store</strong></td>
                      <td align="left" valign="left" class="bodytext32" bgcolor="#ecf0f5"><strong>Batch</strong></td>
                      <td align="left" valign="left" class="bodytext32" bgcolor="#ecf0f5"><strong>Exp.Dt</strong></td>
                      <td align="left" valign="left" bgcolor="#ecf0f5" class="bodytext32"><strong>Avl.Qty</strong></td>
                      <td  align="left" valign="left" bgcolor="#ecf0f5" class="bodytext32"><strong>Trn.Qty</strong></td>
                      <td  align="right" valign="right" class="bodytext32" bgcolor="#ecf0f5"><strong>Cost</strong></td>
                      <td align="right" valign="left" bgcolor="#ecf0f5" class="bodytext32"><strong>Amount</strong></td>
					  <td align="center" valign="left" class="bodytext32" bgcolor="#ecf0f5"><strong></strong></td>
                    </tr>
					
					 <tbody id="insertrow"></tbody>
					<tr>
						<input type="hidden" name="serialnumberinc" id="serialnumberinc" value="1">
						<input type="hidden" name="medicinecode" id="medicinecode" value="">
						
						<td><input name="medicinename" type="text" id="medicinename" size="35" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()" onClick="functioncheckstore()">
						<input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
						<input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
						<input name="avlquantity" type="hidden" id="avlquantity" size="8"></td>
						
						<td align="left" valign="left">
						<input type="text" name="fromstorename[]" id="fromstorename" class="bal" size="10" readonly>
						<input type="hidden" name="fromstorecode[]" id="fromstorecode" class="bal" size="10" readonly>
						<input type="hidden" name="fromstore[]" id="fromstore" class="bal" size="10" readonly></td>
						
						<td align="left" valign="left">
						<input type="text" name="tostore[]" id="tostore" class="bal" size="10" readonly>
						<input type="hidden" name="tostorecode[]" id="tostorecode" class="bal" size="10" readonly></td>
						
						<td align="left" valign="left">
						<select name="batch[]" id="batch" 
						onChange="return funcbatchselection(this.value)">
						<option value="" selected="selected">Select Batch</option>
						</select></td>
						
						<td align="left" valign="left"><input type="text" name="expirydate[]" id="expirydate" class="bal" size="10" readonly></td>
						
						<td align="left" valign="left"><input type="text" name="availablestock[]" id="availablestock" class="bal" size="10" readonly></td>
						
						<td align="left" valign="left"><input type="hidden" name="reqquantity[]" id="reqquantity" class="bal" size="10" readonly>
						<input type="text" name="transferqty[]" id="transferqty" size="6" onKeyUp="return amountcalc();"></td>
						
						<td align="right" valign="left" class="bodytext32"><input type="text" id="costprice" name="cost[]" class="bal" value=""  size="10" readonly></td>
						
						<td align="right" valign="right"><input type="text" name="amount[]" id="amount" class="bal" size="10" readonly></td>
						
						<td width="">&nbsp;<label><input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A"></label></td>

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
					
					<tr>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="right" valign="middle" class="bodytext32" bgcolor="#ecf0f5"><strong>Grand Total:</strong></td>
                      <td align="right" valign="middle" class="bodytext32" bgcolor="#ecf0f5"><strong><input  type="text" name="grandtot" id="grandtot" class="bal1" size="16" value="0" readonly></strong></td>
					</tr>
					 <tr><td>&nbsp;</td></tr>
					 
					 <tr>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>
                      <td align="right" valign="middle" class="bodytext32" bgcolor="#ecf0f5"></td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <input  style="border: 1px solid #001E6A; padding: 10px 30px; " type="submit" style="" value="Stock Transfer" name="Submit" onClick="return medicinecheck();"/></td>
					</tr>
					
                </table>
              </form>		
			  </td>
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

