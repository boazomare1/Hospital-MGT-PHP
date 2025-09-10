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
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
$billnumber = $_REQUEST['billnum'];
$billdate = $_REQUEST['billdate'];
$suppliername = $_REQUEST['suppliername'];
$suppliercode = $_REQUEST['suppliercode'];
$ponumber = $_REQUEST['pono'];
$accountssubid = $_REQUEST['accountssubid'];
$supplierbillno = $_REQUEST['supplierbillno1'];
$amount = $_REQUEST['totalpurchaseamount'];
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

$query751 = "select * from master_financialintegration where field='grn'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$coa = $res751['code'];


foreach($_POST['itemname'] as $key=>$value)
{
$itemname = $_POST['itemname'][$key];

$rate = $_POST['rate'][$key];
$quantity = $_POST['receivedquantity'][$key];
$allpackagetotalquantity = $_POST['totalquantity'][$key];

$free = $_POST['free'][$key];
$itemdiscountpercent = $_POST['discount'][$key];

$itemtaxpercent = $_POST['tax'][$key];

$salesprice = $_POST['saleprice'][$key];
$costprice = $_POST['costprice'][$key];

$quotedprice = $_POST['quotedprice'][$key];
$priceperpack = $_POST['priceperpack'][$key];




		

$balqty = $_POST['balqty'][$key];
if($balqty == $quantity)
{
$itemstatus = 'received';
$query5 = "update master_nmrfqpurchaseorder set goodsstatus = '$itemstatus' where billnumber = '$billnumber'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

}
else
{
$itemstatus = '';
$query5 = "update master_nmrfqpurchaseorder set goodsstatus = 'pending' where billnumber = '$billnumber'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

}


			$query4 = "insert into materialreceiptnote_nmdetails (companyanum, 
			billnumber, itemname, rate, quantity, 
			subtotal, free, discountpercentage, discountrupees,totalamount, 
			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount,  
			 salesprice, itemfreequantity, itemtotalquantity, 
			allpackagetotalquantity, 
			typeofpurchase,suppliername,suppliercode,ponumber,supplierbillnumber,costprice,location,store,coa,quotedprice,priceperpack) 
			values ('$companyanum', '$billnumber', '$itemname', '$rate', '$quantity', 
			'$amount', '$free', '$itemdiscountpercent', '$itemdiscountrupees',  
			'$amount', '$discountamount', '$username', '$ipaddress', '$billdate', 
			'$itemtaxpercent', '$itemtaxamount',  
			 '$salesprice',  '$free', '$quantity', 
			 '$allpackagetotalquantity', 
			'Process','$suppliername','$suppliercode','$ponumber','$supplierbillno','$costprice','$location','$store','$coa','$quotedprice','$priceperpack')";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				
			
}
		

header("location:menupage1.php?mainmenuid=MM029");
}


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

	$searchpo = $_POST['po'];
	$searchpo = trim($searchpo);
	$len1 = strlen($searchpo);
					$str1 = preg_replace('/[^\\/\-a-z\s]/i', '', $searchpo);
					
					if($str1 == 'PO-')
					{
$query5 = "select * from master_nmrfqpurchaseorder where billnumber = '$searchpo' and recordstatus='generated' order by billnumber";
}
else
{
$query5 = "select * from master_nmrfqpurchaseorder where billnumber = '$searchpo' and recordstatus='autogenerated' order by billnumber";
}
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res5 = mysqli_fetch_array($exec5))
{
	$billnum = $res5["billnumber"];
	$suppliername = $res5['suppliername'];
	$suppliercode = $res5['suppliercode'];
    $suppliername = strtoupper($suppliername);
    $billdate = $res5['billdate'];

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
$paynowbillprefix = 'NMMRN-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from materialreceiptnote_nmdetails where typeofpurchase='Process' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='NMMRN-'.'1';
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
	
	
	$billnumbercode = 'NMMRN-' .$maxanum;
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


?>

<?php
include("autocompletebuild_nmrfqpurchaseorder.php");

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
var orderedqty = document.getElementById("orderedquantity"+varserialnumber+"").value;
if(receivedqty != '')
{
is_int(receivedqty,varserialnumber);
}
var balqty = document.getElementById("balqty"+varserialnumber+"").value;
var originalbalanceqty = document.getElementById("originalbalanceqty"+varserialnumber+"").value;
if(parseFloat(receivedqty) > parseFloat(originalbalanceqty))
{
alert("Received quantity is greater than Balancequantity.Please Enter Lesser quantity");
document.getElementById("receivedquantity"+varserialnumber+"").value=0;
document.getElementById("balqty"+varserialnumber+"").value = originalbalanceqty;
return false;
}
var newbalanceqty = originalbalanceqty - receivedqty;
document.getElementById("balqty"+varserialnumber+"").value = newbalanceqty;
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
//var packsize1=document.getElementById("packsize"+varserialnumber1+"").value;
var free1=document.getElementById("free"+varserialnumber1+"").value;
if(free1 != '')
{
//var packvalue1=packsize1.substring(0,packsize1.length - 1);
var totalqty1=parseInt(receivedqty1)  + parseInt(free1);
//document.getElementById("totalquantity"+varserialnumber1+"").value=totalqty1;
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
//var packsize1=document.getElementById("packsize"+varserialnumber2+"").value;
//var packvalue1=packsize1.substring(0,packsize1.length - 1);
var spmarkup = document.getElementById("spmarkup"+varserialnumber2+"").value;
var totalamount = parseFloat(receivedqty2) * parseFloat(priceperpack2);

document.getElementById("totalamount"+varserialnumber2+"").value = totalamount.toFixed(2);
var tot=parseFloat(receivedqty2);
//alert("hi");
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
//var packsize3=document.getElementById("packsize"+varserialnumber3+"").value;
//var packvalue3=packsize3.substring(0,packsize3.length - 1);
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
var tot1=parseFloat(receivedqty3);
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
var tot1=parseFloat(receivedqty3);
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
//var packsize4=document.getElementById("packsize"+varserialnumber4+"").value;
//var packvalue4=packsize4.substring(0,packsize4.length - 1);
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
var tot2=parseFloat(receivedqty4);
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
var tot2=parseFloat(receivedqty4);

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

/*for(i=1;i<=totalcount5;i++)
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

	}*/
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
printmrn();
}

function billnotransfer()
{
var billno = document.getElementById("supplierbillno").value;
document.getElementById("supplierbillno1").value = billno;
}
</script>

<script>
function printmrn()
{
var popWin; 
popWin = window.open("print_mrnnm_dmp4inch1.php?billautonumber=<?php echo $billnumbercode; ?>&&billnum=<?php echo $billnum; ?>");
}
</script>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext21 {
FONT-WEIGHT: normal;FONT-FAMILY: Tahoma;COLOR: #3b3b3c;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bal
{
border-style:none;
background:none;
text-align:center;
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma;
}
</style>

<script src="js/datetimepicker_css.js"></script>
<?php include ("js/dropdownlistnmrfqpurchaseorder.php"); ?>
<script type="text/javascript" src="js/autocomplete_nmrfqpurchaseorder.js"></script>
<script type="text/javascript" src="js/autosuggestnmpurchaseorder.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">

<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
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
		 <form name="cbform1" method="post" action="nmmaterialreceiptnote.php"> 
		<table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
			<tr>
              <td bgcolor="#ecf0f5" class="bodytext3" colspan="8"><strong>NM Material Receipt Note</strong></td>
			 
		</tr>
			 
		
			  <tr>
			 
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>DOC No</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $billnumbercode; ?>
				<input name="docno" id="docno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A;" size="10" autocomplete="off" readonly="readonly" type="hidden"/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Select PO</strong></td>
                <td colspan="3" align="left" valign="top" >
				<input name="po" id="po" value="<?php echo $billnum; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" autocomplete="off"/>				</td>
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>LPO Date </strong></td>
                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $billdate; ?>
				<input name="lpodate" id="lpodate" value="<?php echo $billdate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly" type="hidden"/>				</td>
			    </tr>
				<tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $suppliername; ?> (<?php echo $suppliercode; ?>)
				<input name="supplier" id="supplier" value="<?php echo $suppliername; ?>" style="border: 1px solid #001E6A;" size="25" autocomplete="off" readonly="readonly" type="hidden"/>    
				<input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>">           </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Invoice No</strong></td>
                <td colspan="3" align="left" valign="middle" >
				<input name="supplierbillno" id="supplierbillno" value="" style="border: 1px solid #001E6A" size="10" rsize="20" autocomplete="off" onKeyUp="return billnotransfer()"/>				</td>
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>MRN Date </strong></td>
                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $dateonly; ?>
				<input name="grndate" id="grndate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly" type="hidden"/>				</td>
			    </tr>
				<tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Address</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $address; ?>
				<input name="address" id="address" value="<?php echo $address; ?>" style="border: 1px solid #001E6A;" size="30" autocomplete="off" readonly="readonly" type="hidden"/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Telephone</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $tele; ?>
				<input name="telephone" id="telephone" value="<?php echo $tele; ?>" style="border: 1px solid #001E6A" size="25" rsize="20" readonly="readonly" type="hidden"/>				</td>
             <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Time </strong></td>
                <td width="17%" colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $timeonly; ?>
				<input name="time" id="time" value="<?php echo $timeonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly="readonly" type="hidden"/>				</td>
				<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
			    </tr>
				<tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $location; ?></td>
				   <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Store</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3"><?php echo $store; ?></td>
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
		<form action="nmmaterialreceiptnote.php" method="post" name="form">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="1200" 
            align="left" border="0">
          <tbody id="foo">
		 <input type="hidden" name="billnum" value="<?php echo $billnumbercode; ?>">
		 <input type="hidden" name="billdate" value="<?php echo $dateonly; ?>">
		 <input type="hidden" name="suppliername" value="<?php echo $suppliername; ?>">
		 <input type="hidden" name="pono" value="<?php echo $billnum; ?>">
		 <input type="hidden" name="location" value="<?php echo $location; ?>">
		 <input type="hidden" name="store" value="<?php echo $store; ?>">
		 <input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>"> 
		 <input type="hidden" name="accountssubid" value="<?php echo $accountssubid; ?>">
		 <input type="hidden" name="supplierbillno1" id="supplierbillno1">
             <tr>
		               <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>S.No</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center" width="20%"><strong>Item</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Ord.Qty</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Recd.Qty</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Bal.Qty</strong></td>
                       
                      
                       <!--<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Free</strong></td>-->
                       
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>QP</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Price</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Disc %</strong></td>
					   <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Tax</strong></td>
					  <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Total Value</strong></td>
							
				</tr>
				  		<?php
			$colorloopcount = '';
			$sno = 0;
			$totalamount=0;	
			$len = strlen($billnum);
					$str = preg_replace('/[^\\/\-a-z\s]/i', '', $billnum);
					if($str == 'PO-')
					{
			$query76 = "select * from master_nmrfqpurchaseorder where billnumber='$billnum' and recordstatus='generated' and goodsstatus=''";
			}
			else
			{
			$query76 = "select * from master_nmrfqpurchaseorder where billnumber='$billnum' and recordstatus='autogenerated' and goodsstatus=''";
			}
			$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$number = mysqli_num_rows($exec76);
			while($res76 = mysqli_fetch_array($exec76))
			{
			$totalreceivedqty = 0;
			$itemname = $res76['itemname'];
			//$itemcode = $res76['itemcode'];
			$suppliername = $res76['suppliername'];
			$suppliercode = $res76['suppliercode'];
			
			$query761 = "select * from master_nmrfq where suppliercode='$suppliercode' and itemname='$itemname' and status = 'generated' order by auto_number desc";
			$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res761 = mysqli_fetch_array($exec761);
			$rate = $res761['rate'];
			$amount = $res761['amount'];
			$packagequantity = $res761['quantity'];
			//$packsize = $res761['packsize'];
			//$packsizelen = strlen($packsize);
			
			//$unitquantity = substr($packsize,0,$packsizelen-1);
//			$quotedprice = $amount/($unitquantity * $packagequantity);
			
			
			$query444 = "select * from materialreceiptnote_details where itemname='$itemname' and ponumber='$billnum'";
			$exec444 = mysqli_query($GLOBALS["___mysqli_ston"], $query444) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num444 = mysqli_num_rows($exec444);
			while($res444 = mysqli_fetch_array($exec444))
			{
			$receivedqty = $res444['quantity'];
			$totalreceivedqty = $totalreceivedqty+$receivedqty;
			}
			
			$balanceqty = $packagequantity - $totalreceivedqty;
			

		  
		
?>
  <tr>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
		<input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>">
		
		<input type="hidden" name="rate[]" value="<?php echo $rate; ?>">
		<input type="hidden" name="quantity[]" value="<?php echo $quantity; ?>">
		<input type="hidden" name="totalamount[]" value="<?php echo $amount; ?>">
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagequantity; ?><input type="hidden" name="orderedquantity" id="orderedquantity<?php echo $sno; ?>" value="<?php echo $packagequantity; ?>"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="receivedquantity[]" id="receivedquantity<?php echo $sno; ?>" size="6" onKeyUp="return totalcalc('<?php echo $sno; ?>');" class="bodytext21" autocomplete="off"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="balqty[]" id="balqty<?php echo $sno; ?>" value="<?php echo $balanceqty; ?>" class="bal" readonly="readonly" size="10"></div></td>
		<input type="hidden" name="originalbalanceqty" id="originalbalanceqty<?php echo $sno; ?>" value="<?php echo $balanceqty; ?>">
		
		
		<!--<td class="bodytext31" valign="center"  align="left"><div align="center">--><input type="hidden" name="free[]" id="free<?php echo $sno; ?>" size="6" onKeyUp="return totalcalc1('<?php echo $sno; ?>');" class="bodytext21" autocomplete="off"></div><!--</td>-->
		
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $rate; ?><input type="hidden" name="quotedprice[]" id="quotedprice" value="<?php echo $quotedprice; ?>" />
		<input type="hidden" name="spmarkup" id="spmarkup<?php echo $sno; ?>" value="<?php echo $spmarkup; ?>"><input type="hidden" name="saleprice[]" id="saleprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="priceperpack[]" id="priceperpack<?php echo $sno; ?>" size="6" onKeyUp="return totalamount('<?php echo $sno; ?>','<?php echo $number; ?>');" class="bodytext21" autocomplete="off"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="discount[]" id="discount<?php echo $sno; ?>" size="6" onKeyUp="return totalamount5('<?php echo $sno; ?>','<?php echo $number; ?>');" class="bodytext21" autocomplete="off"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="tax[]" id="tax<?php echo $sno; ?>" size="6" onKeyUp="return totalamount20('<?php echo $sno; ?>','<?php echo $number; ?>');" class="bodytext21" autocomplete="off"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="totalamount[]" id="totalamount<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly"></div></td>
		<input type="hidden" name="costprice[]" id="costprice<?php echo $sno; ?>" size="6" class="bodytext21" readonly="readonly">
						</tr>
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
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5"></td>
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
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				
               </tr>
           
          </tbody>
        </table>	</td>
      </tr>
				    
				  <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
      <tr>
	  <td>
	  <table width="716">
     <tr>
	 <td width="20" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Total Purchase Cost</td>
	   <td width="111" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="totalpurchaseamount" id="totalpurchaseamount" size="10" readonly="readonly"></td>
	     
	 </tr>
		</table>
		</td>
		</tr>				
		        
      <tr>
        
		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frmflag2" value="frmflag2">
               <input name="Submit222" type="submit"  value="Save" class="button" onClick="return funcsave('<?php echo $number; ?>')"/>		 </td>
      </tr>
	  </table>
      </td>
      </tr>
    </form>
  </table>

<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>