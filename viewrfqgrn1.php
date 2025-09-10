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


if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];


$billnumber = $_REQUEST['billnum'];
$store = $_REQUEST['store1'];
$billdate = $_REQUEST['billdate'];
$suppliername = $_REQUEST['suppliername'];
$suppliercode = $_REQUEST['suppliercode'];
$ponumber = $_REQUEST['pono'];
$accountssubid = $_REQUEST['accountssubid'];
$supplierbillno = $_REQUEST['supplierbillno1'];
$amount = $_REQUEST['totalpurchaseamount1'];
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];


$query751 = "select * from master_financialintegration where field='grn'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$coa = $res751['code'];


foreach($_POST['itemname'] as $key=>$value)
{
$itemname = $_POST['itemname'][$key];
$itemcode = $_POST['itemcode'][$key];
$query5 = "select * from master_itempharmacy where itemcode = '$itemcode'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$itemanum = $res5['auto_number'];
$rate = $_POST['rate'][$key];
$quantity = $_POST['receivedquantity'][$key];
$allpackagetotalquantity = $_POST['totalquantity'][$key];
$orderedquantity = $_POST['orderedquantity'][$key];
$free = $_POST['free'][$key];
$itemdiscountpercent = $_POST['discount'][$key];
$totalamount = $_POST['totalamount1'][$key];
$itemtaxpercent = $_POST['tax'][$key];
$batchnumber = $_POST['batch'][$key];
$salesprice = $_POST['saleprice1'][$key];
$costprice = $_POST['costprice'][$key];
$expirydate = $_POST['expirydate'][$key];
			$expirymonth = substr($expirydate, 0, 2);
			$expiryyear = substr($expirydate, 3, 2);
			$expiryday = '01';
			$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
		
$packagename = $_POST['packsize'][$key];
 $balqty = $_POST['balqty'][$key];
if(intval($orderedquantity) == intval($quantity))
{
$itemstatus = 'received';
}
else
{
$itemstatus = '';
}

			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$itemunitabb = $res31['unitname_abbreviation'];
			$res31packageanum = $res31['packageanum'];
			$categoryname = $res31['categoryname'];

			//$packagename = addslashes($packagename);
			$query32 = "select * from master_packagepharmacy where auto_number = '$res31packageanum'";//packagename = '$packagename'";
			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res32 = mysqli_fetch_array($exec32);
			$packageanum = $res32['auto_number'];
			$quantityperpackage = $res32['quantityperpackage'];
			
			$query33 = "select * from materialreceiptnote_details where billnumber='$ponumber' and itemcode='$itemcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res33 = mysqli_fetch_array($exec33);
			$purchaseordernumber = $res33['ponumber'];
			
			



			$query4 = "insert into purchase_details (bill_autonumber, companyanum, 
			billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, 
			subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, 
			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, 
			batchnumber, salesprice, expirydate, itemfreequantity, itemtotalquantity, 
			packageanum, packagename, quantityperpackage, allpackagetotalquantity, 
			manufactureranum, manufacturername,typeofpurchase,suppliername,suppliercode,ponumber,supplierbillnumber,costprice,location,store,coa,categoryname) 
			values ('$billautonumber', '$companyanum', '$billnumber', '$itemanum', '$itemcode', '$itemname', '$itemdescription', '$rate', '$quantity', 
			'$totalamount', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$opening
			stock', '$closingstock', 
			'$totalamount', '$discountamount', '$username', '$ipaddress', '$billdate', 
			'$itemtaxpercent', '$itemtaxamount', '$itemunitabb', 
			'$batchnumber', '$salesprice', '$expirydate', '$free', '$quantity', 
			'$packageanum', '$packagename', '$quantityperpackage', '$allpackagetotalquantity', 
			'$manufactureranum', '$manufacturername','Process','$suppliername','$suppliercode','$ponumber','$supplierbillno','$costprice','$location','$store','$coa','$categoryname')";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query56 = "update materialreceiptnote_details set itemstatus='$itemstatus' where billnumber='$ponumber' and itemcode='$itemcode'";
			$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
			$query561 = "update master_itempharmacy set rateperunit='$salesprice',purchaseprice='$costprice' where itemcode='$itemcode'";
			$exec561 = mysqli_query($GLOBALS["___mysqli_ston"], $query561) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query562 = "update master_medicine set rateperunit='$salesprice',purchaseprice='$costprice' where itemcode='$itemcode'";
			$exec562 = mysqli_query($GLOBALS["___mysqli_ston"], $query562) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$query56 = "update master_rfqpurchaseorder set goodsstatus='$itemstatus' where billnumber='$purchaseordernumber' and itemcode='$itemcode'";
			$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			
}
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT';
		$particulars = 'BY CREDIT (Inv NO:'.$billnumber.$supplierbillnumber.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, creditamount,balanceamount,
		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode) 
		values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$amount', '$amount', '$amount',
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$transactiontype = 'PURCHASE';
		$transactionmode = 'BILL';
		$particulars = 'BY PURCHASE (Inv NO:'.$billnumber.$supplierbillnumber.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount,
		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode) 
		values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$amount', 
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query3 = "insert into master_purchase (companyanum, billnumber, billdate, suppliercode, suppliername,totalamount,totalquantity,ipaddress,supplierbillnumber)values('$companyanum','$billnumber','$updatedatetime','$suppliercode', '$suppliername','$amount','$quantity','$ipaddress','$supplierbillno')";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));





//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$referalname=$_REQUEST['delete'];
mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_referal where referalname='$referalname'");
}
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	/*$searchpo = $_POST['po'];
	$searchpo = trim($searchpo);
	$len1 = strlen($searchpo);
					$str1 = preg_replace('/[^\\/\-a-z\s]/i', '', $searchpo);
					
					$searchpo = $mrnno;
					
					if($str1 == 'MRN-')
					{
$query5 = "select * from materialreceiptnote_details where billnumber = '$searchpo' and itemstatus='' order by billnumber";
}
else
{*/ $searchpo = $billnum1;
$query5 = "select * from materialreceiptnote_details where billnumber = '$billnum1' and itemstatus='' order by billnumber";
//}
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res5 = mysqli_fetch_array($exec5))
{
	$billnum = $res5["billnumber"];
	$suppliername = $res5['suppliername'];
	$suppliercode = $res5['suppliercode'];
    $suppliername = strtoupper($suppliername);
    $billdate = $res5['entrydate'];
	$supplierbillnumber = $res5['supplierbillnumber'];

	$query1 = "select * from master_accountname where id='$suppliercode'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_num_rows());
	$res1 = mysqli_fetch_array($exec1);
	$accountssubanum = $res1['accountssub'];
	
	$query11 = "select * from master_accountssub where auto_number='$accountssubanum'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res11 = mysqli_fetch_array($exec11);
	$accountssubid = $res11['id'];
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
}

	//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];

}


//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];



/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/

//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];




if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

?>


<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'GRN-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from purchase_details where typeofpurchase='Process' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='GRN-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'GRN-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];

$query78 = "select * from purchase_details where billnumber='$billnum2' and ponumber='$billnum1' ";
$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78 = mysqli_fetch_array($exec78);
 mysqli_num_rows($exec78); 
$res78store = $res78['store'];
$res78entrydate = $res78['entrydate'];
$res78suppliername = $res78['suppliername'];
$res78suppliercode = $res78['suppliercode'];
$res78supplierbillnumber = $res78['supplierbillnumber'];

$query100 = "select * from materialreceiptnote_details where billnumber = '$billnum1' and itemstatus='received' order by billnumber";
$exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
$res100 = mysqli_fetch_array($exec100);
$res100billdate = $res100['entrydate'];
?>

<?php
include("autocompletebuild_materialreceiptnote.php");

?>

<script type="text/javascript">

function loadprintpage1(varPaperSizeCatch)
{
	//var varBillNumber = document.getElementById("billnumber").value;
	var varPaperSize = varPaperSizeCatch;
	//alert (varPaperSize);
	//return false;
	<?php
	//To previous js error if empty. 
	if ($previousbillnumber == '') 
	{ 
		$previousbillnumber = 1; 
		$previousbillautonumber = 1; 
		$previouscompanyanum = 1; 
	} 
	?>
	var varBillNumber = document.getElementById("quickprintbill").value;
	var varBillAutoNumber = "<?php //echo $previousbillautonumber; ?>";
	var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
	if (varBillNumber == "")
	{
		alert ("Bill Number Cannot Be Empty.");//quickprintbill
		document.getElementById("quickprintbill").focus();
		return false;
	}
	
	var varPrintHeader = "INVOICE";
	var varTitleHeader = "ORIGINAL";
	if (varTitleHeader == "")
	{
		alert ("Please Select Print Title.");
		document.getElementById("titleheader").focus();
		return false;
	}
	
	//alert (varBillNumber);
	//alert (varPrintHeader);
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

	if (varPaperSize == "A4")
	{
		window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}


function funcDefaultTax1() //Function to CST Taxes if required.
{
	//alert ("Default Tax");
	<?php
	//delbillst=billedit&&delbillautonumber=13&&delbillnumber=1
	//To avoid change of bill number on edit option after selecting default tax.
	if (isset($_REQUEST["delbillst"])) { $delBillSt = $_REQUEST["delbillst"]; } else { $delBillSt = ""; }
	//$delBillSt = $_REQUEST["delbillst"];
	if (isset($_REQUEST["delbillautonumber"])) { $delBillAutonumber = $_REQUEST["delbillautonumber"]; } else { $delBillAutonumber = ""; }
	//$delBillAutonumber = $_REQUEST["delbillautonumber"];
	if (isset($_REQUEST["delbillnumber"])) { $delBillNumber = $_REQUEST["delbillnumber"]; } else { $delBillNumber = ""; }
	//$delBillNumber = $_REQUEST["delbillnumber"];
	
	?>
	var varDefaultTax = document.getElementById("defaulttax").value;
	if (varDefaultTax != "")
	{
		<?php
		if ($delBillSt == 'billedit')
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="sales1.php";
	}
	//return false;
}
function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch3();
	funcPopupPrintFunctionCall();
	
}


</script>
<script>
function totalcalc(varserialnumber)
{
var varserialnumber = varserialnumber;
var receivedqty = document.getElementById("receivedquantity"+varserialnumber+"").value;
if(receivedqty != '')
{
is_int(receivedqty,varserialnumber);
}
var balqty = document.getElementById("balqty"+varserialnumber+"").value;
if(parseFloat(receivedqty) > parseFloat(balqty))
{
alert("Received quantity is greater than Balancequantity.Please Enter Lesser quantity");
document.getElementById("receivedquantity"+varserialnumber+"").value=0;
return false;
}
if(receivedqty != '')
{
var packsize=document.getElementById("packsize"+varserialnumber+"").value;
var packvalue=packsize.substring(0,packsize.length - 1);
var totalqty=parseInt(receivedqty) * parseInt(packvalue);
document.getElementById("totalquantity"+varserialnumber+"").value=totalqty;
}
return true;
}
 function is_int(value,varserialnumber8){ 
  if((parseFloat(value) == parseInt(value)) && !isNaN(value)){
      return true;
  } else { 
  alert("Quantity should be integer");
  document.getElementById("receivedquantity"+varserialnumber8+"").value=0;
      return false;
  } 
}
function totalcalc1(varserialnumber1)
{
var varserialnumber1 = varserialnumber1;
var receivedqty1 = document.getElementById("receivedquantity"+varserialnumber1+"").value;
var packsize1=document.getElementById("packsize"+varserialnumber1+"").value;
var free1=document.getElementById("free"+varserialnumber1+"").value;
if(free1 != '')
{
var packvalue1=packsize1.substring(0,packsize1.length - 1);
var totalqty1=parseInt(receivedqty1) * parseInt(packvalue1) + parseInt(free1);
document.getElementById("totalquantity"+varserialnumber1+"").value=totalqty1;
}
}
function totalamount(varserialnumber2,totalcount)
{
var grandtotaladjamt = 0;
var varserialnumber2 = varserialnumber2;
var totalcount = totalcount;
var receivedqty2 = document.getElementById("receivedquantity"+varserialnumber2+"").value;
var priceperpack2 = document.getElementById("priceperpack"+varserialnumber2+"").value;
if(priceperpack2 != '' && receivedqty2 != '')
{
var packsize1=document.getElementById("packsize"+varserialnumber2+"").value;
var packvalue1=packsize1.substring(0,packsize1.length - 1);
var spmarkup = document.getElementById("spmarkup"+varserialnumber2+"").value;
var totalamount = parseFloat(receivedqty2) * parseFloat(priceperpack2);

document.getElementById("totalamount"+varserialnumber2+"").value = totalamount.toFixed(2);
var tot=parseFloat(receivedqty2) * parseFloat(packvalue1);

var costprice1 = parseFloat(totalamount)/parseFloat(tot);
document.getElementById("costprice"+varserialnumber2+"").value = costprice1.toFixed(2);

var saleprice = parseFloat(costprice1) * parseFloat(spmarkup);
document.getElementById("saleprice"+varserialnumber2+"").value = saleprice.toFixed(2);

for(i=1;i<=totalcount;i++)
{
var totaladjamount=document.getElementById("totalamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);

}
document.getElementById("totalpurchaseamount").value = grandtotaladjamt.toFixed(2);
}
}

function totalamount5(varserialnumber3,totalcount1)
{

var totalcount1 = totalcount1;
var grandtotaladjamt1 = 0;
var varserialnumber3 = varserialnumber3;
var receivedqty3 = document.getElementById("receivedquantity"+varserialnumber3+"").value;
var priceperpack3 = document.getElementById("priceperpack"+varserialnumber3+"").value;

var totalamount3 = parseFloat(receivedqty3) * parseFloat(priceperpack3);
var packsize3=document.getElementById("packsize"+varserialnumber3+"").value;
var packvalue3=packsize3.substring(0,packsize3.length - 1);
var discountpercent3 = document.getElementById("discount"+varserialnumber3+"").value;
if(discountpercent3 !='')
{
var tax = document.getElementById("tax"+varserialnumber3+"").value;
var spmarkup1 = document.getElementById("spmarkup"+varserialnumber3+"").value;
if(tax == '')
{
var totalamount31 = parseFloat(totalamount3) * parseFloat(discountpercent3);
var totalamount32 = parseFloat(totalamount31) / 100;

var finalamount3 = parseFloat(totalamount3) - parseFloat(totalamount32);
var tot1=parseFloat(receivedqty3) * parseFloat(packvalue3);
var costprice1 = parseFloat(finalamount3)/parseFloat(tot1);
document.getElementById("costprice"+varserialnumber3+"").value = costprice1.toFixed(2);
var saleprice = parseFloat(costprice1) * parseFloat(spmarkup1);
document.getElementById("saleprice"+varserialnumber3+"").value = saleprice.toFixed(2);
}
else
{
var totalamount31 = parseFloat(totalamount3) * parseFloat(discountpercent3);
var totalamount32 = parseFloat(totalamount31) / 100;

var finalamount3 = parseFloat(totalamount3) - parseFloat(totalamount32);
var finaltaxamount = parseFloat(finalamount3) * parseFloat(tax);
var finaltaxamount1 = parseFloat(finaltaxamount)/100;

var finaltaxamount3 = parseFloat(finalamount3) + parseFloat(finaltaxamount1);
var tot1=parseFloat(receivedqty3) * parseFloat(packvalue3);
var costprice1 = parseFloat(finaltaxamount3)/parseFloat(tot1);
document.getElementById("costprice"+varserialnumber3+"").value = costprice1.toFixed(2);
var saleprice = parseFloat(costprice1) * parseFloat(spmarkup1);
document.getElementById("saleprice"+varserialnumber3+"").value = saleprice.toFixed(2);
}

document.getElementById("totalamount"+varserialnumber3+"").value = finalamount3.toFixed(2);
for(i=1;i<=totalcount1;i++)
{
var totaladjamount=document.getElementById("totalamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
grandtotaladjamt1=grandtotaladjamt1+parseFloat(totaladjamount);

}
document.getElementById("totalpurchaseamount").value = grandtotaladjamt1.toFixed(2);
}
}

function totalamount20(varserialnumber4,totalcount2)
{
var totalcount2 = totalcount2;
var grandtotaladjamt2 = 0;
var varserialnumber4 = varserialnumber4;
var receivedqty4 = document.getElementById("receivedquantity"+varserialnumber4+"").value;
var priceperpack4 = document.getElementById("priceperpack"+varserialnumber4+"").value;
var packsize4=document.getElementById("packsize"+varserialnumber4+"").value;
var packvalue4=packsize4.substring(0,packsize4.length - 1);
var totalamount4 = parseFloat(receivedqty4) * parseFloat(priceperpack4);
var discountpercent4 = document.getElementById("discount"+varserialnumber4+"").value;
var spmarkup2 = document.getElementById("spmarkup"+varserialnumber4+"").value;
if(discountpercent4 != '')
{
var totalamount41 = parseFloat(totalamount4) * parseFloat(discountpercent4);
var totalamount42 = parseFloat(totalamount41) / 100;

var finalamount4 = parseFloat(totalamount4) - parseFloat(totalamount42);
var tax = document.getElementById("tax"+varserialnumber4+"").value;
if(tax != '')
{
var finaltaxamount = parseFloat(finalamount4) * parseFloat(tax);
var finaltaxamount1 = parseFloat(finaltaxamount)/100;

var finaltaxamount2 = parseFloat(finalamount4) + parseFloat(finaltaxamount1);
var tot2=parseFloat(receivedqty4) * parseFloat(packvalue4);
var costprice = parseFloat(finaltaxamount2)/parseFloat(tot2);
document.getElementById("costprice"+varserialnumber4+"").value = costprice.toFixed(2);
var saleprice = parseFloat(costprice) * parseFloat(spmarkup2);
document.getElementById("saleprice"+varserialnumber4+"").value = saleprice.toFixed(2);
}
}
else
{
var tax = document.getElementById("tax"+varserialnumber4+"").value;
if(tax != '')
{
var finaltaxamount = parseFloat(totalamount4) * parseFloat(tax);
var finaltaxamount1 = parseFloat(finaltaxamount)/100;

var finaltaxamount2 = parseFloat(totalamount4) + parseFloat(finaltaxamount1);
var tot2=parseFloat(receivedqty4) * parseFloat(packvalue4);

var costprice = parseFloat(finaltaxamount2)/parseFloat(tot2);
document.getElementById("costprice"+varserialnumber4+"").value = costprice.toFixed(2);
var saleprice = parseFloat(costprice) * parseFloat(spmarkup2);
document.getElementById("saleprice"+varserialnumber4+"").value = saleprice.toFixed(2);
}
}

document.getElementById("totalamount"+varserialnumber4+"").value = finaltaxamount2.toFixed(2);
for(i=1;i<=totalcount2;i++)
{
var totaladjamount=document.getElementById("totalamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount);

}
document.getElementById("totalpurchaseamount").value = grandtotaladjamt2.toFixed(2);
}


function funcsave(totalcount5)
{
var totalcount5 =totalcount5;

if(document.getElementById("po").value =='')
{
alert("Please Select Purchase Order");
document.getElementById("po").focus();
return false;
}
if(document.getElementById("supplierbillno").value =='')
{
alert("Please Enter Supplier Invoice Number");
document.getElementById("supplierbillno").focus();
return false;
}
if(document.getElementById("store").value =='')
{
alert("Please Select Store");
document.getElementById("store").focus();
return false;
}
for(i=1;i<=totalcount5;i++)
{
var receivedquantity=document.getElementById("receivedquantity"+i+"").value;
if(receivedquantity == "")
{
alert("Please Enter Received Quantity");
document.getElementById("receivedquantity"+i+"").focus();
return false; 
}

}

for(i=1;i<=totalcount5;i++)
{
var batch=document.getElementById("batch"+i+"").value;
if(batch == "")
{
alert("Please Enter batch Number");
document.getElementById("batch"+i+"").focus();
return false; 
}

}
for(i=1;i<=totalcount5;i++)
{
var varItemExpiryDate=document.getElementById("expirydate"+i+"").value;
if(varItemExpiryDate == "")
{
alert("Please Enter Expiry Date");
document.getElementById("expirydate"+i+"").focus();
return false; 
}
var varItemExpiryDateLength = varItemExpiryDate.length;
	var varItemExpiryDateLength = parseInt(varItemExpiryDateLength);
	if (varItemExpiryDateLength != 5)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Length Should Be Five Characters.");
		document.getElementById("expirydate"+i+"").focus();
		return false;
	}
	var varItemExpiryDateArray = varItemExpiryDate.split("/");
	//alert(varItemExpiryDateArray);
	var varItemExpiryDateArrayLength = varItemExpiryDateArray.length;
	//alert(varItemExpiryDateArrayLength);
	if (varItemExpiryDateArrayLength != 2)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Forward Slash Is Missing.");
		document.getElementById("expirydate"+i+"").focus();
		return false;
	}
	
	var varItemExpiryDateMonthLength = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateMonthLength);
	var varItemExpiryDateMonthLength = varItemExpiryDateMonthLength.length;
	//alert(varItemExpiryDateMonthLength);
	var varItemExpiryDateMonthLength = parseInt(varItemExpiryDateMonthLength);
	if (varItemExpiryDateMonthLength != 2)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Preceding Zero Is Required Except November & December.");
		document.getElementById("expirydate"+i+"").focus();
		return false;
	}
	
	var varItemExpiryDateYearLength = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateYearLength);
	var varItemExpiryDateYearLength = varItemExpiryDateYearLength.length;
	//alert(varItemExpiryDateYearLength);
	var varItemExpiryDateYearLength = parseInt(varItemExpiryDateYearLength);
	if (varItemExpiryDateYearLength != 2)
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Simply Give Current Year In Two Digits.");
		document.getElementById("expirydate"+i+"").focus();
		return false;
	}
	
	var varItemExpiryDateMonth = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateMonthLength);
	if (isNaN(varItemExpiryDateMonth))
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Month Should Be Number.");
		document.getElementById("expirydate"+i+"").focus();
		return false;
	}

	var varItemExpiryDateYear = varItemExpiryDateArray[1];
	//alert(varItemExpiryDateYear);
	if (isNaN(varItemExpiryDateYear))
	{
		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Year Should Be Number.");
		document.getElementById("expirydate"+i+"").focus();
		return false;
	}

	
	var varItemExpiryDateMonth = varItemExpiryDateArray[0];
	//alert(varItemExpiryDateMonthLength);
	if (varItemExpiryDateMonth > 12 || varItemExpiryDateMonth == 0)
	{
		alert ("Expiry Month Should Be Between 1 And 12.");
		document.getElementById("expirydate"+i+"").focus();
		return false;
	}

	var varItemExpiryDateYear = varItemExpiryDateArray[1];
	//alert(varItemExpiryDateYear);
	if (varItemExpiryDateYear < 13 || varItemExpiryDateYear > 23)
	{
		alert ("Expiry Year Should Be Between 2013 And 2023.");
		document.getElementById("expirydate"+i+"").focus();
		return false;
	}

	}
for(i=1;i<=totalcount5;i++)
{
var priceperpack=document.getElementById("priceperpack"+i+"").value;
if(priceperpack == "")
{
alert("Please Enter Price Per Pack");
document.getElementById("priceperpack"+i+"").focus();
return false; 
}

}

}

function billnotransfer()
{
var billno = document.getElementById("supplierbillno").value;
document.getElementById("supplierbillno1").value = billno;
}

function validationcheck()
{

var varUserChoice; 
	varUserChoice = confirm('Are you sure of saving the entry? Pl note that once saved, Inventory and Financial Data will be updated.'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	else
	{
		//alert ("Entry Saved.");
		document.cbform1.submit();
		//return true;
	}

}

function storeassign()
{

var store = document.getElementById("store").value;
document.getElementById("store1").value = store;
}
</script>

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
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
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
              <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" colspan="8"><strong>Goods Received Note</strong></td>
		</tr>
		
			  <tr>
			 
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>DOC No</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $billnum2; ?>
				<input name="docno" id="docno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A;" size="10" autocomplete="off" readonly="readonly" type="hidden"/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>MRN</strong></td>
                 <td colspan="3" align="left" class="bodytext3" valign="top" ><?php echo $billnum1; ?>
				<input type="hidden" name="po" id="po" value="<?php echo $billnum; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" autocomplete="off"/>				</td>
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>MRN Date </strong></td>
                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $res100billdate; ?>
				<input name="lpodate" id="lpodate" value="<?php echo $billdate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly" type="hidden"/>				</td>
			    </tr>
				<tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $res78suppliername; ?> & <?php echo $res78suppliercode; ?>
				<input name="supplier" id="supplier" value="<?php echo $suppliername; ?>" style="border: 1px solid #001E6A;" size="25" autocomplete="off" readonly="readonly" type="hidden"/>    
				<input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>">           </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Invoice No</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3" ><?php echo $res78supplierbillnumber; ?>
				<input type="hidden" name="supplierbillno" id="supplierbillno" value="<?php echo $supplierbillnumber; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" autocomplete="off" onKeyUp="return billnotransfer()"/>				</td>
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>GRN Date </strong></td>
                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $res78entrydate; ?>
				<input name="grndate" id="grndate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly" type="hidden"/>				</td>
			    </tr>
				<tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Address</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $address; ?>
				<input name="address" id="address" value="<?php echo $address; ?>" style="border: 1px solid #001E6A;" size="30" autocomplete="off" readonly="readonly" type="hidden"/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Telephone</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $tele; ?>
				<input name="telephone" id="telephone" value="<?php echo $tele; ?>" style="border: 1px solid #001E6A" size="25" rsize="20" readonly="readonly" type="hidden"/>				</td>
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
			    </tr>
				<tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $location; ?></td>
				   <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Store</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $res78store; ?></td>
		</tr>
            </tbody>
        </table>
		</form></td>
      </tr>
      <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
      <tr>
        <td>
		<form action="rfqgoodsreceivednote.php" method="post" name="form" onSubmit="return validationcheck()">
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
			/*$colorloopcount = '';
			$sno = 0;
			$totalamount=0;	
			$grandtotalamount = 0;
			$len = strlen($billnum);
					$str = preg_replace('/[^\\/\-a-z\s]/i', '', $billnum);
					if($str == 'MRN-')
					{
			$query76 = "select * from materialreceiptnote_details where billnumber='$billnum1' and itemstatus=''";
			}
			else
			{*/
			$query76 = "select * from purchase_details where billnumber='$billnum2' and itemstatus=''";
			//}
			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$number = mysqli_num_rows($exec76);
			while($res76 = mysqli_fetch_array($exec76))
			{
			$totalreceivedqty = 0;
			$itemname = $res76['itemname'];
			$itemcode = $res76['itemcode'];
			$rate = $res76['priceperpack'];
			$quantity = $res76['quantity'];
			$amount = $res76['totalamount'];
			$suppliercode = $res76['suppliercode'];
			$batchnumber = $res76['batchnumber'];
			$expirydate = $res76['expirydate'];
			$free = $res76['itemfreequantity'];
			$priceperpack = $res76['priceperpack'];
			$totalqty = $res76['allpackagetotalquantity'];
			$discountpercent = $res76['discountpercentage'];
			$itemtaxpercentage = $res76['itemtaxpercentage'];
			$itemtotalamount = $rate * $quantity;
			
			$grandtotalamount = $grandtotalamount + $itemtotalamount;
			
			$packsize = $res76['unit_abbreviation'];
			$packsizelen = strlen($packsize);
			
			$unitquantity = substr($packsize,0,$packsizelen-1);
			$costprice = $itemtotalamount/($unitquantity * $quantity);
			
			$query761 = "select * from master_rfq where suppliercode='$suppliercode' and medicinecode='$itemcode' and status = 'generated' order by auto_number desc";
			$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res761 = mysqli_fetch_array($exec761);
			$orderedquantity = $res761['packagequantity'];
			$amount3 = $res761['amount'];
			$quotedprice = $res761['rate'];
			
			if($rate > $quotedprice)
			{
			$error_css='background-color:red';
			}
			else if($rate < $quotedprice)
			{
			$error_css = 'background-color:yellow';
			}
			else
			{
			$error_css = '';
			}
	
				$balanceqty = $orderedquantity - $quantity;
				
				$expirydate = explode("-",$expirydate);
			$year =  $expirydate[0];
			$year = substr($year,2,4);
			$month = $expirydate[1];
			$newexpirydate = $expirydate[1].'/'.$year;
			

			$query77 = "select * from master_medicine where itemcode='$itemcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$packagesize = $res77['packagename'];
			$spmarkup = $res77['spmarkup'];
			$saleprice = $spmarkup * $costprice;
			
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
		<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="left"><?php echo $itemname; ?></div></td>
		<input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>">
		<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">
		<input type="hidden" name="rate[]" value="<?php echo $rate; ?>">
		<input type="hidden" name="quantity[]" value="<?php echo $quantity; ?>">
		<input type="hidden" name="totalamount[]" value="<?php echo $amount; ?>">
		<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo intval($orderedquantity); ?></div></td><input type="hidden" name="orderedquantity[]" id="orderedquantity<?php echo $sno; ?>" value="<?php echo intval($orderedquantity); ?>">
		<td class="bodytext3" valign="center"  align="left"><div align="center"><input type="hidden" name="receivedquantity[]" id="receivedquantity<?php echo $sno; ?>" size="6" onKeyUp="return totalcalc('<?php echo $sno; ?>');" class="bodytext21" autocomplete="off" value="<?php echo intval($quantity); ?>" readonly="readonly"><?php echo intval($quantity); ?></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $balanceqty; ?><input type="hidden" name="balqty[]" id="balqty<?php echo $sno; ?>" value="<?php echo $balanceqty; ?>"></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"><input type="hidden" name="batch[]" id="batch<?php echo $sno; ?>" size="6" class="bodytext21" autocomplete="off" value="<?php echo $batchnumber; ?>" readonly="readonly"><?php echo $batchnumber; ?></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"><input type="hidden" name="expirydate[]" id="expirydate<?php echo $sno; ?>" size="6" autocomplete="off" value="<?php echo $newexpirydate; ?>" readonly="readonly"><?php echo $newexpirydate; ?></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"><?php echo $packagesize; ?><input type="hidden" name="packsize[]" id="packsize<?php echo $sno; ?>" value="<?php echo $packagesize; ?>"></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"><input type="hidden" name="free[]" id="free<?php echo $sno; ?>" size="6" onKeyUp="return totalcalc1('<?php echo $sno; ?>');" class="bodytext21" autocomplete="off" value="<?php echo intval($free); ?>" readonly="readonly"><?php echo intval($free); ?></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="center"><input type="hidden" name="totalquantity[]" id="totalquantity<?php echo $sno; ?>" size="6" class="bodytext21" value="<?php echo intval($totalqty); ?>" readonly="readonly"><?php echo intval($totalqty); ?></div></td>
		<td class="bodytext3" valign="center"  align="right"><?php echo number_format($quotedprice,2,'.',','); ?></td>
		<td class="bodytext3" valign="center"  align="right"><div align="right"><input type="hidden" name="priceperpack[]" id="priceperpack<?php echo $sno; ?>" size="6" onKeyUp="return totalamount('<?php echo $sno; ?>','<?php echo $number; ?>');" class="bodytext21" autocomplete="off" value="<?php echo $rate; ?>" readonly="readonly" align="right" style="<?php echo $error_css; ?>"><?php echo number_format($rate,2,'.',','); ?></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="right"><input type="hidden" name="discount[]" id="discount<?php echo $sno; ?>" size="6" onKeyUp="return totalamount5('<?php echo $sno; ?>','<?php echo $number; ?>');" class="bodytext21" autocomplete="off" value="<?php echo $discountpercent; ?>" readonly="readonly"><?php echo number_format($discountpercent,2,'.',','); ?></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="right"><input type="hidden" name="tax[]" id="tax<?php echo $sno; ?>" size="6" onKeyUp="return totalamount20('<?php echo $sno; ?>','<?php echo $number; ?>');" class="bodytext21" autocomplete="off" value="<?php echo $itemtaxpercentage; ?>" readonly="readonly"><?php echo number_format($itemtaxpercentage,2,'.',','); ?></div></td>
		<td class="bodytext3" valign="center"  align="left"><div align="right"><input type="hidden" name="totalamount[]" id="totalamount<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly" value="<?php echo number_format($itemtotalamount,2,'.',','); ?>"><?php echo number_format($itemtotalamount,2,'.',','); ?></div></td>
		<input type="hidden" name="totalamount1[]" id="totalamount<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly" value="<?php echo $itemtotalamount; ?>">
		<td class="bodytext3" valign="center"  align="left"><div align="right"><input type="hidden" name="costprice[]" id="costprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly" value="<?php echo number_format($costprice,2,'.',','); ?>"><?php echo number_format($costprice,2,'.',','); ?></div></td>
		<td  align="left" valign="center" class="bodytext3"><div align="right">
		  <input  type="hidden" name="saleprice1[]" id="saleprice1<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly" value="<?php echo $saleprice; ?>">
            <input type="hidden" name="spmarkup" id="spmarkup<?php echo $sno; ?>" value="<?php echo $spmarkup; ?>">
		  <input type="hidden" name="saleprice[]" id="saleprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly" value="<?php echo number_format($saleprice,2,'.',','); ?>">
		  <?php echo number_format($saleprice,2,'.',','); ?></div></td>
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
                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount,2,'.',','); ?></strong></td>
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