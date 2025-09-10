<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
include ("residental_doctor_func.php");
include ("includes/check_user_access.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");  
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno=$_SESSION["docno"];
$totallab=0;
$query01="select locationcode,locationname from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01=mysqli_fetch_array($exc01);
$main_locationcode = $res01['locationcode'];
$locationname = $res01['locationname'];
$locationcode=$main_locationcode;

$query018="select auto_number from master_location where locationcode='$main_locationcode'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];

$query1111 = "select * from master_employee where username = '$username'";
			$exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while ($res1111 = mysqli_fetch_array($exec1111))
			 {
			   $locationnumber = $res1111["location"];
			   $query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'deleted'";
				$exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while ($res1112 = mysqli_fetch_array($exec1112))
			 {
			   $locationname = $res1112["locationname"];    
				$locationcode = $res1112["locationcode"];
			 }
			 }
			
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["docno_val"])) { $docno_val = $_REQUEST["docno_val"]; } else { $docno_val = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
 	
	
		$totalamount=$_REQUEST['totalamount'];
		$billdate=$_REQUEST['billdate'];
		$entrydate = $billdate;
		$paymentmode = $_REQUEST['billtype'];
		$billtype = $_REQUEST['billtype'];
		$chequedate = $_REQUEST['chequedate'];
		$bankname = $_REQUEST['chequebank'];
		$bankbranch = $_REQUEST['bankbranch'];
		$remarks = $_REQUEST['remarks'];
		$card = $_REQUEST['cardname'];
		$cardnumber = $_REQUEST['cardnumber'];
		$bankname1 = $_REQUEST['bankname1'];
		$paymenttype = $_REQUEST['paymenttype'];
		$subtype='CASH HOSPITAL';
		$accountname='CASH - HOSPITAL';
		$mpesanumber = $_REQUEST['mpesanumber'];
		$onlinenumber = $_REQUEST['onlinenumber'];
		$chequenumber = $_REQUEST['chequenumber'];
		$cardnumber= $_REQUEST['cardnumber'];
		$txn_no=$mpesanumber;
		if($txn_no=='')
		{
			$txn_no=$onlinenumber;
		}
		if($txn_no=='')
		{
			$txn_no=$chequenumber;
		}
		if($txn_no=='')
		{
			$txn_no=$cardnumber;
		}
		$chequecode = '';
		$cashcode = '';
		$mpesacode = '';
		$bankcode = '';
		$onlinecode = '';
	
		//get location from form
		 $locationname=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		 $locationcode=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
		 
		 $ambcount=isset($_REQUEST['ambcount'])?$_REQUEST['ambcount']:'';
		  $ambcount1=isset($_REQUEST['ambcount1'])?$_REQUEST['ambcount1']:'';
		
		$desipaddress=$_REQUEST['desipaddress'];
		$desusername=$_REQUEST['desusername'];
		$fxrate = $_REQUEST['fxrate'];
		$docno_val= $_REQUEST['docno_val'];
	
			
	$query3 = "select * from bill_formats where description = 'other_sales'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$paynowbillprefix = $res3['prefix'];
	$paynowbillprefix1=strlen($paynowbillprefix);
	$query2 = "select * from other_sales_billing order by auto_number desc limit 0, 1";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$billnumber = $res2["billno"];
	$billdigit=strlen($billnumber);
	
	$dispensingkey=isset($_REQUEST['dispensingkey'])?$_REQUEST['dispensingkey']:'';
	
	
	if ($billnumber == '')
	{
		$billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
			$openingbalance = '0.00';
	
	}
	else
	{
		
		$billnumber = $res2["billno"];
		$maxcount=split("-",$billnumber);
		$maxcount1=$maxcount[1];
		$maxanum = $maxcount1+1;
		
		
		$billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
		$openingbalance = '0.00';
		//echo $companycode;
	}
	
if ($paymentmode == 'CASH')
{
$cashtakenfromcustomer=$cashgivenbycustomer-$cashgiventocustomer;
if($cashtakenfromcustomer=='' || $cashtakenfromcustomer=='0' || $cashtakenfromcustomer=='0.00'){
$cashtakenfromcustomer=$totalamount;
}
$query386="select ledger_id,ledger_name from finance_ledger_mapping where map_anum='1' order by auto_number desc";
$exec386=mysqli_query($GLOBALS["___mysqli_ston"], $query386) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res7691 = mysqli_fetch_array($exec386);
$ledgercode = $res7691['ledger_id'];
$ledgername = $res7691['ledger_name'];
}
else if ($paymentmode == 'ONLINE')
{
$query386="select ledger_id,ledger_name from finance_ledger_mapping where map_anum='3' order by auto_number desc";
$exec386=mysqli_query($GLOBALS["___mysqli_ston"], $query386) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res7691 = mysqli_fetch_array($exec386);
$ledgercode = $res7691['ledger_id'];
$ledgername = $res7691['ledger_name'];
}

else if ($paymentmode == 'CHEQUE')
{
$query386="select ledger_id,ledger_name from finance_ledger_mapping where map_anum='2' order by auto_number desc";
$exec386=mysqli_query($GLOBALS["___mysqli_ston"], $query386) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res7691 = mysqli_fetch_array($exec386);
$ledgercode = $res7691['ledger_id'];
$ledgername = $res7691['ledger_name'];

$query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$bankcode = $res55['ledgercode'];
}
else if($paymentmode == 'CREDIT CARD')
{
$query386="select ledger_id,ledger_name from finance_ledger_mapping where map_anum='4' order by auto_number desc";
$exec386=mysqli_query($GLOBALS["___mysqli_ston"], $query386) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res7691 = mysqli_fetch_array($exec386);
$ledgercode = $res7691['ledger_id'];
$ledgername = $res7691['ledger_name'];	
}
else if ($paymentmode == 'SPLIT')
{
$query386="select ledger_id,ledger_name from finance_ledger_mapping where map_anum='1' order by auto_number desc";
$exec386=mysqli_query($GLOBALS["___mysqli_ston"], $query386) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res7691 = mysqli_fetch_array($exec386);
$ledgercode = $res7691['ledger_id'];
$ledgername = $res7691['ledger_name'];		
}
else if ($paymentmode == 'MPESA')
{
$query386="select ledger_id,ledger_name from finance_ledger_mapping where map_anum='5' order by auto_number desc";
$exec386=mysqli_query($GLOBALS["___mysqli_ston"], $query386) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res7691 = mysqli_fetch_array($exec386);
$ledgercode = $res7691['ledger_id'];
$ledgername = $res7691['ledger_name'];
}
	
	$billnumber = $billnumbercode;
		
		$query386="select * from other_sales_billing where billno='$billnumber'";
		$exec386=mysqli_query($GLOBALS["___mysqli_ston"], $query386) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num386=mysqli_num_rows($exec386);
	if($num386 == 0)
	{
		$query3861="select * from other_sales_billing where consultationid='$consultationid' ";
		$exec3861=mysqli_query($GLOBALS["___mysqli_ston"], $query3861) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3861=mysqli_num_rows($exec3861);

 $query3861="select description,units,rate,amount,name,billingaccountname,billingaccountcode from other_sales where docno='$docno_val'";
$exec3861=mysqli_query($GLOBALS["___mysqli_ston"], $query3861) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
while($res3861 = mysqli_fetch_array($exec3861))
{
$description=$res3861['description'];
$units=$res3861['units'];
$rate=$res3861['rate'];
$amount=$res3861['amount'];
$name=$res3861['name'];	
$billingaccountname=$res3861['billingaccountname'];
$billingaccountcode=$res3861['billingaccountcode'];	
 $referalquery1="insert into other_sales_billing(billno,totalamount,billdate,accountname,referalname,doctorstatus,billstatus,username,subtype,consultationid,locationname,locationcode,fxrate,fxamount,created_at,transactionmode,txnno,ledgername,ledgercode,osno,description,units,rate,amount,bankcode,chequedate,bankname,name,billingaccountname,billingaccountcode)
values('$billnumber','$totalamount','$billdate','$accountname','$referalname','unpaid','paid','$username','$subtype','$consultationid','$locationname','$locationcode','$fxrate','$totalamount','$updatedatetime','$paymentmode','$txn_no','$ledgername','$ledgercode','$docno_val','$description','$units','$rate','$amount','$bankcode','$chequedate','$bankname','$name','$billingaccountname','$billingaccountcode')";
$exec38610=mysqli_query($GLOBALS["___mysqli_ston"], $referalquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

}
$query30=mysqli_query($GLOBALS["___mysqli_ston"], "update other_sales set paymentstatus='completed' where docno='$docno_val'");
$source='othersales';
	//header("location:print_othersales.php?billno=$billnumber&&docno=$docno_val&&locationcode=$locationcode");
	header("location:patientbillingstatus_bills.php?billno=$billnumber&&docno_val=$docno_val&&locationcode=$locationcode&&source=$source");
		exit;
		}
		else
		{
		header("location:patientbillingstatus_bills.php");
		}
}
//to redirect if there is no entry in masters category or item or customer or settings
//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{}
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}
//This include updatation takes too long to load for hunge items database.
//To populate the autocompetelist_services1.js
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
if ($delbillst == "" && $delbillnumber == "")
{
	$res41customername = "";
	$res41customercode = "";
	$res41tinnumber = "";
	$res41cstnumber = "";
	$res41address1 = "";
	$res41deliveryaddress = "";
	$res41area = "";
	$res41city = "";
	$res41pincode = "";
	$res41billdate = "";
	$billnumberprefix = "";
	$billnumberpostfix = "";
}
?>

<?php
$query3 = "select * from bill_formats where description = 'other_sales'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = $res3['prefix'];
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from other_sales_billing order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{

		$billnumbercode =$paynowbillprefix."-".'1'."-".date('y')."-".$location_auto;
		$openingbalance = '0.00';
}
else
{
	/*$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode=abs($billnumbercode);
	$billnumbercode = $billnumbercode + 1;
	$maxanum = $billnumbercode;*/
	
	$billnumber = $res2["billno"];
	$maxcount=split("-",$billnumber);
	$maxcount1=$maxcount[1];
	$maxanum = $maxcount1+1;

	$billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;
	$openingbalance = '0.00';
	//echo $companycode;
}

?>
<script language="javascript">
<?php
if ($delbillst != 'billedit') // Not in edit mode or other mode.
{
?>
	//Function call from billnumber onBlur and Save button click.
	function billvalidation()
	{
		billnovalidation1();
	}
<?php
}
?>

function funcOnLoadBodyFunctionCall()
{
	funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	funcPopupPrintFunctionCall();
	//alert ("Auto Print Function Runs Here.");	
}
function funcPopupPrintFunctionCall()
{
	///*
	//alert ("Auto Print Function Runs Here.");
	<?php
	if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
	//$src = $_REQUEST["src"];
	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
	//$st = $_REQUEST["st"];
	if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
	//$previousbillnumber = $_REQUEST["billnumber"];
	if (isset($_REQUEST["billautonumber"])) { $previousbillautonumber = $_REQUEST["billautonumber"]; } else { $previousbillautonumber = ""; }
	//$previousbillautonumber = $_REQUEST["billautonumber"];
	if (isset($_REQUEST["companyanum"])) { $previouscompanyanum = $_REQUEST["companyanum"]; } else { $previouscompanyanum = ""; }
	//$previouscompanyanum = $_REQUEST["companyanum"];
	if ($src == 'frm1submit1' && $st == 'success')
	{
	$query1print = "select * from master_printer where defaultstatus = 'default' and status <> 'deleted'";
	$exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query1print) or die ("Error in Query1print.".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1print = mysqli_fetch_array($exec1print);
	$papersize = $res1print["papersize"];
	$paperanum = $res1print["auto_number"];
	$printdefaultstatus = $res1print["defaultstatus"];
	
	if ($paperanum == '1') //For 40 Column paper
	{
	?>
		//quickprintbill1();
		quickprintbill1sales();
	//alert ("Auto Print Function Runs Here.");
	<?php
	}
	else if ($paperanum == '2') //For A4 Size paper
	{
	?>
		loadprintpage1('A4');
	<?php
	}
	else if ($paperanum == '3') //For A4 Size paper
	{
	?>
		loadprintpage1('A5');
	<?php
	}
	}
	?>
	//*/
}
//Print() is at bottom of this page.
</script>
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
	//alert(varBillNumber);
	var varBillAutoNumber ="<?php //echo $previousbillautonumber; ?>" ;
	//alert(varBillAutoNumber);
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
		window.open("print_paynow.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_paynow_a5.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}
function cashentryonfocus1()
{
	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
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
		window.location="billing_paynow.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="billing_paynow.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="billing_paynow.php";
	}
	//return false;
}
</script>
<script type="text/javascript">
/*function balancecalc(mode)
{
var mode = mode;
var cashamount = document.getElementById("cashamount").value;
//alert(cashamount);
if(cashamount == '')
{
cashamount = 0;
}
var chequeamount = document.getElementById("chequeamount").value;
if(chequeamount == '')
{
chequeamount = 0;
}
var cardamount = document.getElementById("cardamount").value;
if(cardamount == '')
{
cardamount = 0;
}
var onlineamount = document.getElementById("onlineamount").value;
if(onlineamount == '')
{
onlineamount = 0;
}
var mpesaamount = document.getElementById("creditamount").value;
if(mpesaamount == '')
{
mpesaamount = 0;
}
var balance =  document.getElementById("totalamount").value;
var totalamount = parseFloat(cashamount)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount);
var newbalance=parseFloat(balance) - parseFloat(totalamount);
newbalance = newbalance.toFixed(2);
if(newbalance < 0)
{
alert("Entered Amount is greater than Bill Amount");
if(mode == '1')
{
document.getElementById("cashamount").value = '0.00';
}    
if(mode == '2')
{
document.getElementById("creditamount").value = '0.00';
}  
if(mode == '3')
{
document.getElementById("chequeamount").value = '0.00';
}  
if(mode == '4')
{
document.getElementById("cardamount").value = '0.00';
}  
if(mode == '5')
{
document.getElementById("onlineamount").value = '0.00';
}            
          
return false;
}
if(newbalance == -0.00)
{
newbalance = 0;
newbalance = newbalance.toFixed(2);
}
document.getElementById("tdShowTotal").innerHTML = newbalance;
}*/
function balancecalc(mode)
{
   // alert(mode);
	var mode = mode;
	
	var cashgivenbycustomer = document.getElementById("cashgivenbycustomer").value;
	if(cashgivenbycustomer == '')
	{
		cashgivenbycustomer = 0;
	}
	var billtype = document.getElementById("billtype").value;
	//alert(cashamount);
	var cashamount = document.getElementById("cashamount").value;
	if(cashamount == '')
	{
	cashamount = 0;
	}
	var chequeamount = document.getElementById("chequeamount").value;
	if(chequeamount == '')
	{
	chequeamount = 0;
	}
	var cardamount = document.getElementById("cardamount").value;
	if(cardamount == '')
	{
	cardamount = 0;
	}
	var onlineamount = document.getElementById("onlineamount").value;
	if(onlineamount == '')
	{
	onlineamount = 0;
	}
	var adjustamount = document.getElementById("adjustamount").value;
	if(adjustamount == '')
	{
		adjustamount = 0;
	}
	var mpesaamount = document.getElementById("creditamount").value;
	if(mpesaamount == '')
	{
	mpesaamount = 0;
	}
	var balance_amt = parseFloat($('#hid_bal_amt').val());
	if(parseFloat(adjustamount) >parseFloat( balance_amt) )
	{
		alert('Adjust amount exceeds Available Amount');
		$('#adjustamount').val('0.00');
		$('#adjustamount').keyup();
		return false;
	}
	else
	{
		
		var adv_dep_bal_amt = parseFloat(balance_amt) - parseFloat(adjustamount);
		adv_dep_bal_amt = adv_dep_bal_amt.toFixed(2);
		//var format_bal = adv_dep_bal_amt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		$('#adv_dep_bal_amt').text(adv_dep_bal_amt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		$('#net_deposit_amt').val(adv_dep_bal_amt);
	}
	var balance =  document.getElementById("totalamount").value;
	var totalamount = parseFloat(cashgivenbycustomer)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount) + parseFloat(adjustamount);
	
	//alert(totalamount);
	var newbalance=parseFloat(balance) - parseFloat(totalamount);
	
	if(newbalance < 0)
	{
		alert("Given amount already exits the Bill amount!");
		
		if(mode == '1')
		{
			document.getElementById("cashamount").value = '0.00';
		}    
		if(mode == '2')
		{
			document.getElementById("creditamount").value = '0.00';
		}  
		if(mode == '3')
		{
			document.getElementById("chequeamount").value = '0.00';
		}  
		if(mode == '4')
		{
			document.getElementById("cardamount").value = '0.00';
		}  
		if(mode == '5')
		{
			document.getElementById("onlineamount").value = '0.00';
		}            
		
		/*var cashpay=document.getElementById("cashgivenbycustomer").value;
		var mpaypay=document.getElementById("creditamount").value;
		var cheqpay=document.getElementById("chequeamount").value;
		var cardpay=document.getElementById("cardamount").value;
		var onlipay=document.getElementById("onlineamount").value;
		
		var totalamount1 = document.getElementById("totalamount").value ;
		
		var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay);   
		
		var show1=parseFloat(totalamount1)-parseFloat(allcash);
		if(parseFloat(show1)<=0)
		{
			document.getElementById("tdShowTotal").innerHTML=0.00;
			document.getElementById("balanceamt").value=0.00;
		}
		else
		{
			document.getElementById("tdShowTotal").innerHTML=show1.toFixed(2);
			document.getElementById("balanceamt").value=show1.toFixed(2);
		}*/
		return false;
	}
	
	var balance =  document.getElementById("totalamount").value;
	var cashpay=document.getElementById("cashgivenbycustomer").value;
	if(cashpay==''){
		cashpay=0.00;
	}
	var mpaypay=document.getElementById("creditamount").value;
	var cheqpay=document.getElementById("chequeamount").value;
	var cardpay=document.getElementById("cardamount").value;
	var onlipay=document.getElementById("onlineamount").value;
	var totalamount = parseFloat(cashpay)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount)+ parseFloat(adjustamount);
	if(billtype=='SPLIT')
	{
		//alert(balance);
		document.getElementById("cashamount").value = parseFloat(balance) - (parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount) + parseFloat(adjustamount));
		//alert(parseFloat(totalamount) - (parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount)));
	}
	
	//alert(balance);
	var newbalance=parseFloat(balance) - parseFloat(totalamount);
	if(parseFloat(newbalance)<=0)
	{
		document.getElementById("tdShowTotal").innerHTML=0.00;
		document.getElementById("balanceamt").value=0.00;
	}
	else
	{
		document.getElementById("tdShowTotal").innerHTML=newbalance.toFixed(2);
		document.getElementById("balanceamt").value=newbalance.toFixed(2);
	}
	
document.getElementById("tdShowTotal").innerHTML=(document.getElementById("tdShowTotal").innerHTML).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//document.getElementById("tdShowTotal").innerHTML = newbalance.toFixed(2);
}
</script>
<script>
function functioncurrencyfx(val)
{	
	var myarr = val.split(",");
	var currate=myarr[0];
	var currency=myarr[1];
	
	var ledgername=myarr[2];
	var ledgercode=myarr[3];
	//alert(currate);
	//alert(currency);
	document.getElementById("fxamount").value=  currate;
	
	document.getElementById("ledgername").value=  ledgername;
	document.getElementById("ledgercode").value=  ledgercode;
	
	document.getElementById("amounttot").value='';
	document.getElementById("currencyamt").value='';
	
	
}
function funcamountcalc()
{
if(document.getElementById("currencyamt").value != '')
{
var currency = document.getElementById("currencyamt").value;
var rate = document.getElementById("fxamount").value;
var amount = currency * rate;
document.getElementById("amounttot").value = amount.toFixed(2);
}
}
function checkit()
{
alert("TEsting");	
}
</script>
<script>
function btnDeleteClick4(delID)
{
//var pharmamount=pharmamount;
	//alert ("Inside btnDeleteClick.");
	var newtotal4;
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
	//alert('amounttot['+varDeleteID+']');
		var curamount = document.getElementById('amounttot['+varDeleteID+']').value; // currency amount
		var totalcashgiven = document.getElementById("cashgivenbycustomer").value;
		
		document.getElementById("cashgivenbycustomer").value=parseFloat(document.getElementById("cashgivenbycustomer").value)-parseFloat(curamount);
		document.getElementById("cashamount").value=document.getElementById("cashgivenbycustomer").value;
		//funcbillamountcalc1();
		var totalamount = document.getElementById("totalamount").value ;
		if (document.getElementById("billtype").value == "CASH")
		{
			var cashgiventocustomer=document.getElementById("cashgiventocustomer").value;
			var totalamt=document.getElementById("totalamount").value;
			if(parseFloat(totalamt)<=parseFloat(document.getElementById("cashgivenbycustomer").value))
			{
				document.getElementById("cashgiventocustomer").value=parseFloat(document.getElementById("cashgivenbycustomer").value)-parseFloat(totalamt);
			}
			else {document.getElementById("cashgiventocustomer").value=0;}
			
			var balanceinfo=parseFloat(totalamount)-parseFloat(document.getElementById("cashgivenbycustomer").value);
			if(parseFloat(balanceinfo)>0)
			{
				document.getElementById("balanceamt").value=balanceinfo;
				document.getElementById("tdShowTotal").innerHTML =balanceinfo;
			}
			else
			{
				document.getElementById("balanceamt").value=0.00;
				document.getElementById("tdShowTotal").innerHTML =0.00;			
			}
							
		}
	
		if (document.getElementById("billtype").value == "SPLIT")
		{
			var cashgiventocustomer=document.getElementById("cashgiventocustomer").value;
			var totalamt=document.getElementById("totalamount").value;
			
			var cashpay=document.getElementById("cashgivenbycustomer").value;
				if(cashpay==''){
						cashpay=0.00;
				}
			var mpaypay=document.getElementById("creditamount").value;
			var cheqpay=document.getElementById("chequeamount").value;
			var cardpay=document.getElementById("cardamount").value;
			var onlipay=document.getElementById("onlineamount").value;
			var adjustpay=document.getElementById("adjustamount").value;
			
			var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay)+parseFloat(adjustpay);
			//alert(allcash);
			if(parseFloat(totalamt)<=parseFloat(allcash))
			{
				var cashgtocst=parseFloat(document.getElementById("cashgivenbycustomer").value)-parseFloat(totalamt);
				document.getElementById("cashgiventocustomer").value=parseFloat(cashgtocst);
				if(parseFloat(cashgtocst)>=parseFloat(cashpay))
				{
					alert("Change is more than cash taken!");
					document.getElementById("cashgiventocustomer").value=0;
				}
			}
			else {document.getElementById("cashgiventocustomer").value=0;}
			
			
			var cashpay=totalcashgiven;
				if(cashpay==''){
					cashpay=0.00;
				}
			var mpaypay=document.getElementById("creditamount").value;
			var cheqpay=document.getElementById("chequeamount").value;
			var cardpay=document.getElementById("cardamount").value;
			var onlipay=document.getElementById("onlineamount").value;
			var adjustpay=document.getElementById("adjustamount").value;
			
			var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay)+parseFloat(adjustpay);
			var balanceinfo=parseFloat(totalamount)- ( parseFloat(allcash) - parseFloat(curamount) );
			if(parseFloat(balanceinfo)>0)
			{
				document.getElementById("balanceamt").value=balanceinfo;
				document.getElementById("tdShowTotal").innerHTML =balanceinfo;
			}
			else
			{
				document.getElementById("balanceamt").value=0.00;
				document.getElementById("tdShowTotal").innerHTML =0.00;			
			}
		
		}
		
	//	alert(curamount);
		
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		//amounttot[2]
		//var curamount = document.getElementById('amounttot'+varDeleteID); // currency amount
		//alert(curamount);
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	var currenttotal4=document.getElementById('amounttot').value;
	//alert(currenttotal);
	newtotal4= currenttotal4-varDeleteID;
	
	newtotal4 = newtotal4.toFixed(2);
	
	document.getElementById('amounttot').value=0.00;
	
	document.getElementById("tdShowTotal").innerHTML=(document.getElementById("tdShowTotal").innerHTML).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	
	funcPaymentInfoCalculation1();
}
</script>
<?php include ("js/sales1scripting_new_adj.php"); ?>
<script type="text/javascript" src="js/insertitemcurrencyfx.js"></script>
<script type="text/javascript" src="js/insertnewitem7.js"></script>
<style type="text/css">
.bodytext3 {
	FONT-WEIGHT: normal;
	FONT-SIZE: 11px;
	/* [disabled]COLOR: #3B3B3C; */
	FONT-FAMILY: Tahoma
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
</style>
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script>
$( document ).ready(function() {
var values = $('#currency').val().split(",");
document.getElementById('fxamount').value=values[0];    
 document.getElementById('ledgername').value=values[2];
document.getElementById('ledgercode').value=values[3];  
  
});
</script>
<script>
function printPaynowBill()
 {
var popWin; 
popWin = window.open("print_billpaynowbill_dmp4inch1.php?patientcode=<?php echo $patientcode; ?>&&billautonumber=<?php echo $billnumbercode; ?>&&ranum=<?php echo (rand(10,100)); ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
 }
</script>
<script>
/*function funcSaveBill13()
{
	var billtype=document.getElementById('billtype').value;
	if(billtype=='')
	{
	    alert('Please Select Payment Mode');
	    document.getElementById('billtype').focus();
	    return false;
	}
	
var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry.....?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	else
	{
		//alert ("Entry Saved.");
		document.form1.submit();
		//return true;
	}
	} */
	</script>
	
<script>	
function loadprintpage3()
{
	var varBillNumber1 = document.getElementById("quickprintbill").value;
	
	window.open("print_paynow.php?billautonumber="+varBillNumber1+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<script>	
function quickprintbill2sales()
{
   
	var varBillNumber1 = document.getElementById("quickprintbill").value;
	
	window.open("print_paynow_dmp4inch1view1.php?billautonumber="+varBillNumber1+"","OriginalWindowA4<?php echo $banum; ?>",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
</head>
<style>
.radio-toolbar1 input[type="radio"] {
    display:none; 
}

.radio-toolbar input[type="radio"] {
    display:none; 
}

.radio-toolbar label {
    display:inline-block;
    background-color:#FFF;
    padding:4px 11px;
    font-family:Arial;
    font-size:16px;
}

.radio-toolbar input[type="radio"]:checked + label { 
    background-color:#093;
	color:#FFF;
}
</style>
<script>

function setCurrenttype(data){
	$('.dummycashrow').html('');
		var ans=$('#totalamount1212').val();
		var ans=parseFloat(ans).toFixed(2);
		var ans = ans.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		//alert($ans);
	//$('#tdShowTotal').html(ans);
	$('#billtype').val('');
	$('.offlinebtrn').hide();	
	$('#banktrnno').val('0');
	$('.offlinepaymentsinnnerclass').hide();	
	$('#nettamount').val('0.00');		
	$('#checkno').val('');
	$('.offlinepaymentsclass').show();		
	$('#checkno').val('0');
	
}


</script>
<script>
function funcPopupOnLoader()
{
funcOnLoadBodyFunctionCall();
<?php 
if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }
?>
var patientcodes;
var patientcodes = "<?php echo $savedpatientcode; ?>";
//alert(patientcodes);
if(patientcodes != "") 
{
	window.open("print_registration_label.php?previouspatientcode="+patientcodes+" ","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
}
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall()">
<form name="form1" id="form1" method="post" action="billing_paynow-othersales.php" onKeyDown="return disableEnterKey(event)" onSubmit="return funcSaveBill1()">
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
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr >
                <td colspan="6" bgcolor="#ecf0f5" class="bodytext32"><strong>Other Sales Details</strong></td>
                
                <td  bgcolor="#ecf0f5" class="bodytext32"><strong>Location:&nbsp;&nbsp;<?php echo $locationname ?> </strong></td>
                 <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">
                <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">
			 </tr>
			 <?php
			 if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
			 if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
				//$st = $_REQUEST["st"];
				
     		 if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
			if ($st == 'success' && $billautonumber != '')
			{
			?>
            <tr>
             
              <td colspan="8"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage3()" value="Click Here To Print Invoice" class="button" style="border: 1px solid #001E6A"/>			  </td>
            </tr>
			<?php
			}
			?>
				   
			
			  <tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table>
   </td>
      </tr>
	  
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
           <tr bgcolor="#011E6A">
                <td colspan="8" bgcolor="#ecf0f5" class="bodytext32"><strong>Transaction Details</strong></td>
			 </tr>
          
            <tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" colspan="2"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
				  </tr>
			   <input type="hidden" id="docno_val" name="docno_val" value="<?php echo $docno_val; ?>">
			<?php
            $query3118=mysqli_query($GLOBALS["___mysqli_ston"], "select * from  other_sales where  docno='$docno_val'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
           while( $exec3118=mysqli_fetch_array($query3118))
		   {
            $docno_os = $exec3118['docno'];
            $description=$exec3118['description'];
            $units=$exec3118['units'];
            $rate=$exec3118['rate'];
            $amount=$exec3118['amount'];
            $consultationdate=$exec3118['consultationdate'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			$totallab=$totallab+$amount; 
			
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left" colspan="2"><div align="center"><?php echo $description; ?></div></td>
		   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $units; ?></div></td>
		   <td class="bodytext31" valign="center"  align="right"><div align="center"><?php echo number_format($rate, 2, '.', ','); ?></div></td>
           <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount, 2, '.', ','); ?></div></td>
			
		
             </tr>
			
			  <?php 
		   }
			  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalampref+$totalhomref+$totalconref+$totalref+$totaldepartmentref+$dispensingfee)-$totalcopay;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop-$totalcopay;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$dispensingfee;
			   $netpay=number_format($netpay,2,'.','');
			   $totalamount=$overalltotal;
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
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total</strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo $overalltotal; ?></strong></td>
				 <td width="4%"  align="left" valign="center" 
               class="bodytext31" bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
             
			 </tr>
			  <input type="hidden" id="ref_count" name="ref_count" value="<?php echo $sno; ?>">
          </tbody>
        </table>		</td>
		</tr>
		
		<tr>
		<td>
		<table width="99%" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" bgcolor="#F3F3F3" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
            <tbody id="foo">
              <tr>
                <td width="1%" align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>	
				<?php
				$originalamount = $totalamount;
			  $totalamount = round($totalamount);
			  $totalamount = number_format($totalamount,2,'.','');
			  $roundoffamount = $originalamount - $totalamount;
			  $roundoffamount = number_format($roundoffamount,2,'.','');
			  $roundoffamount = -($roundoffamount);
			  //echo 'tot'.$totalamount;
			  ?>
                <td width="3%" rowspan="2" align="right" valign="top"  bgcolor="#F3F3F3" class="style1" id="tdShowTotal"><?php echo number_format($totalamount,2); ?></td>
                <td width="12%" align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Sub Total </strong></div></td>
                <td align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="top" bgcolor="#F3F3F3" width="15%"><span class="bodytext31">
                  <input name="subtotal" id="subtotal" value="<?php echo $originalamount; ?>" style="text-align:right" size="8"  readonly="readonly" />
                </span></td>
                <td align="left" valign="top" bgcolor="#F3F3F3" width="10%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="8%"><div align="right"><strong>Bill Amt </strong></div></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="9%"><span class="bodytext311">            
                <input name="totalamount" id="totalamount" value="<?php echo $totalamount; ?>" style="text-align:right" size="8"  readonly="readonly" />
                </span></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="23%">&nbsp;</td>
              </tr>
			  
              <tr>
                <td align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Round Off </strong></div></td>
                <td align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="top" bgcolor="#F3F3F3" width="15%"><span class="bodytext311">
				 <input name="roundoff" id="roundoff" value="<?php echo $roundoffamount; ?>" style="text-align:right"  readonly="readonly" size="8"/>
                  <input name="totalaftercombinediscount" id="totalaftercombinediscount" value="0.00" style="text-align:right" size="8"  readonly="readonly" type="hidden"/>
                </span></td>
                <td align="left" valign="top" bgcolor="#F3F3F3" width="10%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="8%"><div align="right"><strong>Nett Amt</strong></div></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="6%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="9%"><span class="bodytext31">
                   <input name="nettamount" id="nettamount" value="0.00" style="text-align:right" size="8" readonly />
                </span></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="23%">&nbsp;</td>
              </tr>
                  <input type="hidden" name="totalaftertax" id="totalaftertax" value="0.00"  onKeyDown="return disableEnterKey()" onBlur="return funcSubTotalCalc()" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly"/>
              <tr>
			  <td>&nbsp;</td>
			  </tr>
               
              <tr>
                <td align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"   bgcolor="#F3F3F3" class="bodytext31" colspan="2"><div align="right"><strong> Mode </strong></div></td>
               <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="15%"><select name="billtype" id="billtype" onChange="return paymentinfo()">
                  <option value="">SELECT BILL TYPE</option>
                  <?php
					$query1billtype = "select * from master_billtype where status = '' order by listorder";
					$exec1billtype = mysqli_query($GLOBALS["___mysqli_ston"], $query1billtype) or die ("Error in Query1billtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1billtype = mysqli_fetch_array($exec1billtype))
					{
					$billtype = $res1billtype["billtype"];
					?>
                  <option value="<?php echo $billtype; ?>"><?php echo $billtype; ?></option>
                  <?php
					}
					?>
                  <!--					
                    <option value="CASH">CASH</option>
                    <option value="CREDIT">CREDIT</option>
                    <option value="CHEQUE">CHEQUE</option>
                    <option value="CREDIT CARD">CREDIT CARD</option>
                    <option value="ONLINE">ONLINE</option>
                    <option value="SPLIT">SPLIT</option>
-->
                </select></td>
                <td align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31" width="10%">&nbsp;</td>
                <td align="left" valign="middle" bgcolor="#F3F3F3" class="bodytext31" width="8%"></td>        
                <td align="left" valign="middle" bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="middle" bgcolor="#F3F3F3" width="9%">&nbsp;</td>
              </tr>
			  <tr>
			   <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			  </tr>
              <tr>
                 <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="center" colspan="9"  id="insertrow" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
			 </tr>
			  <tr>
			   <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			  </tr>
               <tr class="cc">
                <td align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31"></td>
                     </tr>
					  <tr id="cashamounttr" class="cc">
					</tr>
                     
					 
					  <tr id="cashamounttr" class="cc offlinepaymentsinnnerclass" >
                        
                <td align="left" valign="center"  bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="right" valign="center" colspan="2"  bgcolor="#F3F3F3" class="bodytext31"><strong>Currency</strong></td>
					    <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="currencyid" id="currencyid" value="" >
				   <td ><select  name="currency1" id="currency"   onChange="return functioncurrencyfx(this.value)">
                   <option value="">Select Currency</option>
                                    
                    <?php
					$query1currency = "select * from master_currency where recordstatus = '' ";
					$exec1currency = mysqli_query($GLOBALS["___mysqli_ston"], $query1currency) or die ("Error in Query1currency".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1currency = mysqli_fetch_array($exec1currency))
					{
					$currency = $res1currency["currency"];
					$rate = $res1currency["rate"];
					$ledgername = $res1currency["ledgername"];
					$ledgercode = $res1currency["ledgercode"];
					$defaultstatus=$res1currency["defaultcurr"];
					?>
 <option value="<?php echo $rate.','.$currency.','.$ledgername.','.$ledgercode;  ?>" <?php if( $defaultstatus =='yes'){ echo 'selected="selected"';} ?>>
 <?php  echo $currency; ?></option>
                  <?php
					}
					?>
                    
                  
                   </select></td>
                   <td align="right" valign="center" class="bodytext3"><strong>FX Rate</strong></td>
				    <td width="52"><input name="fxamount[]" type="text" id="fxamount" size="8" readonly>
                    
                    <input name="ledgername[]" type="hidden" id="ledgername" size="8" readonly>
                    <input name="ledgercode[]" type="hidden" id="ledgercode" size="8" readonly>
                    <input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                    </td>
                   <td align="right" valign="center" class="bodytext3" colspan="2"><strong> Amount</strong></td>
				    <td width="83"><input name="currencyamt[]" type="text" id="currencyamt" size="8" onKeyUp="return funcamountcalc()"></td>
                     
                    <td align="right" valign="center" class="bodytext3"><strong>Total</strong></td>
					  <td width="109"><input name="amounttot[]" type="text" id="amounttot" readonly size="8"></td>
					   <td width="45"><label>
                       <input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitemcurrency()" class="button">
                       </label></td>
					   
			    </tr>
                <tr>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                </tr>
			
              <tr id="cashamounttr" class="cc offlinepaymentsinnnerclass" >
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="right" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash </strong></div></td>
                <td width="128" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cashamount" id="cashamount" onBlur="return funcbillamountcalc1()" tabindex="1" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('1')"/></td>
                <td width="142" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash Recd11 </strong></div></td>
                <td width="52" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input type="text" name="cashgivenbycustomer" id="cashgivenbycustomer"  tabindex="2" style="text-align:right" size="8" autocomplete="off" /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="136" colspan="2"><div align="right"><strong>Change   </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="83"><input name="cashgiventocustomer" id="cashgiventocustomer" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly  /></td>
               
                <td align="right" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="74"><strong>Balance Amt </strong></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="109"><input name="balanceamt" id="balanceamt"  value="0.00" style="text-align:right" size="8" readonly  /></td>
               <input name="totalamountadd" type="hidden" id="totalamountadd"  value="0.00" style="text-align:right" size="8" readonly  />
              </tr>
              
              

			
              <tr id="creditamounttr" class="offlinepaymentsinnnerclass">
              
              
              
              
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="creditamount" id="creditamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="getEncAmount(); return balancecalc('2');"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="52"><input name="mpesanumber" id="mpesanumber" value="" style="text-align:left; text-transform:uppercase" size="8" <?php if($mpesa_integration == 0){ echo "readonly"; } ?> /></td>
			<td>	
			<?php 
				$query = "select mobilenumber from master_customer where customercode = '$patientcode'";
				$execquery = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resquery = mysqli_fetch_array($execquery);
				$mobilenumber = $resquery['mobilenumber'];
			?>
            <!-- iPayments HTML/PHP Code Start -->
            <?php
            	$mpesa_amount = $billamount;
                $mpesa_secret_key = $mpesa_secret;
                $mpesa_result_field = "mpesanumber";
                $mpesa_amount_field = "creditamount";
                $mpesa_number = iPayment_mobileTrim($mobilenumber);
                $mpesa_user_id = $username; // Max 10 Char
            ?>    
            <input type="hidden" name="mpesa_url" id="mpesa_url" value="<?= $mpesa_url ?>" placeholder="Mpesa Amount Field">
            <input type="hidden" name="mpesa_amount_field" id="mpesa_amount_field" value="<?= $mpesa_amount_field ?>" placeholder="Mpesa Amount Field">
            <input type="hidden" name="mpesa_result_field" id="mpesa_result_field" value="<?= $mpesa_result_field ?>" placeholder="Mpesa Result Field">
            <input type="hidden" name="mpesa_amount" id="mpesa_amount" value="<?= iPayment_encrypt("$mpesa_amount","$mpesa_secret_key") ?>" placeholder="Amount">
            <input type="hidden" name="mpesa_secret_key" id="mpesa_secret_key" value="<?= $mpesa_secret_key ?>" placeholder="Secret Key">
            <input type="hidden" name="mpesa_number" id="mpesa_number" value="<?= iPayment_encrypt("$mpesa_number","$mpesa_secret_key") ?>" placeholder="Number">
            <input type="hidden" name="mpesa_user_id" id="mpesa_user_id" value="<?= $mpesa_user_id ?>" placeholder="User">
            <?php if($mpesa_integration == 1){ ?><span id="iPaymentsIcon" onClick="OpenMpesa()" style="padding: 3px;background-color: #fff;border-radius: 20px;border: 1px solid;cursor: pointer;" title="Lipa na MPESA - iPayments">⚡</span> <?php } ?>
            <!-- iPayments HTML/PHP Code End -->
			</td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="136"></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="83"></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="74"></td>
                
              </tr>
              <tr id="chequeamounttr" class="offlinepaymentsinnnerclass">
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cheque  </strong></div></td>
                <td width="128" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="chequeamount" id="chequeamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('3')"/></td>
                <td width="142" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Chq No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="52"><input name="chequenumber" id="chequenumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="136" colspan="2"><div align="right"><strong> Date </strong></div></td>
                <td width="83" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">  <input name="chequedate" id="chequedate" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td width="74" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Bank  </strong></div></td>
                <td width="109" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"> <input name="chequebank" id="chequebank" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                </tr>
			  
              <tr id="cardamounttr" class="offlinepaymentsinnnerclass">
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Card  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cardamount" id="cardamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="getBarclayAmount(); return balancecalc('4');"/></td>

                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Transaction No </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="52"><input name="cardnumber" id="cardnumber" value="" style="text-align:left; text-transform:uppercase" size="8"  <?php if($barclayscard_integration == 1){ echo "readonly"; } ?>/></td>
				
				<td>
	            <!-- iPayments HTML/PHP Code Start -->
	            <?php
	                $barclays_amount = $billamount;
	                $barclays_secret_key = $barclays_secret;
	                $barclays_result_field = "cardnumber";
	                $barclays_amount_field = "cardamount";
	                $barclays_user_id = "1"; // Must be an interger value
	            ?>
	            <input type="hidden" name="barclayscard_url" id="barclayscard_url" value="<?= $barclayscard_url ?>" placeholder="Barclays Card Url">
	            <input type="hidden" name="barclays_result_field" id="barclays_result_field" value="<?= $barclays_result_field ?>" placeholder="Mpesa Result">
	            <input type="hidden" name="barclays_amount" id="barclays_amount" value="<?= iPayment_encrypt('$barclays_amount','$barclays_secret_key') ?>" placeholder="Amount">
	            <input type="hidden" name="barclays_amount_field" id="barclays_amount_field" value="<?= $barclays_amount_field ?>">
	            <input type="hidden" name="barclays_secret_key" id="barclays_secret_key" value="<?= $barclays_secret_key ?>" placeholder="Secret Key">
	            <input type="hidden" name="barclays_user_id" id="barclays_user_id" value="<?= $barclays_user_id ?>" placeholder="User">
	            <?php if($barclayscard_integration == 1){ ?><span onClick="OpenBarclays()" style="padding: 3px;background-color: #fff;border-radius: 20px;border: 1px solid;cursor: pointer;" id="iPaymentsIconBarclays" title="Card Payments - iPayments">⚡</span><?php } ?>
	            <!-- iPayments HTML/PHP Code End -->
				</td>

                <!-- <td width="136" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Name  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="83"><input type="text" name="cardname" id="cardname" size="8" style="text-align:left;"> -->
                <!--<select name="cardname" id="cardname">
                  <option value="">SELECT CARD</option>
                  <?php
				$querycom="select * from master_creditcard where status <> 'deleted'";
				$execcom=mysqli_query($GLOBALS["___mysqli_ston"], $querycom) or die("Error in querycom".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($rescom=mysqli_fetch_array($execcom))
				{
				$creditcardname=$rescom["creditcardname"];
				?>
                  <option value="<?php echo $creditcardname;?>"><?php echo $creditcardname;?></option>
                  <?php
				}
				?>
                </select>--><!-- </td>
                <td align="left" valign="center" class="bodytext31" width="74"><div align="right"><strong> Bank  </strong></div></td>
                <td align="left" valign="center" class="bodytext31" width="109"><input name="bankname1" id="bankname" value="" style="text-align:left; text-transform:uppercase"  size="8"  /></td> -->
              </tr>
              <tr id="onlineamounttr" class="offlinepaymentsinnnerclass">
			  <td align="left" valign="center"
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			    <td colspan="2" align="left" valign="center" 
                bgcolor="#F3F3F3" class="bodytext31">
                 <div align="right"><strong>Online  </strong></div>                  </td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><input name="onlineamount" id="onlineamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly onKeyUp="return balancecalc('5')"/></td>
                 <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Online No </strong></div></td>
                <td align="left" valign="center"  
                 class="bodytext31" width="52"><input name="onlinenumber" id="onlinenumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
                 class="bodytext31" width="136">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="74">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="109">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
              </tr>
				
              
                 <!-- New adjust option -->
               <tr id="adjustamounttr" class="offlinepaymentsinnnerclass">
			  <td align="left" valign="center"
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			    <td colspan="2" align="left" valign="center" 
                bgcolor="#F3F3F3" class="bodytext31">
                 <div align="right"><strong>Adjust  </strong></div>                  </td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><input name="adjustamount" id="adjustamount" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly onKeyUp="return balancecalc('5')"/>
               </td>
                <td align="left" valign="center"  
                 class="bodytext31" width="136">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="136">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="74">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="109">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
              </tr>
              
              
              <tr>
                
                <td colspan="16" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                  <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">
                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">
				   <input name="form_flag" id="form_flag" type="hidden" value="paynow">
				 <?php if($totalamount!=0){?> <input name="Submit2223" id="Submit2223" type="submit"value="Save Bill(Alt+S)" accesskey="s" class="button"/><?php }?> 
                </font></font></font></font></font></div></td>
              </tr>
			  
			 
			 
            </tbody>
        </table>
		</td>
   </tr>
                   
    </table>
</form>
<script type="text/javascript">
$( document ).ready(function() {

setCurrenttype();
$('#billtypedata0').trigger('click');
$('#currencyamt').focus();


});

function getEncAmount(){
	var amount = document.getElementById('creditamount').value;
	$.ajax({
        type: "POST",
        url: 'mpesacalc.php',
        data : {mpesaamt: amount},
        success: function(data)
        {	
        	document.getElementById("mpesa_amount").value = data;
        }
    });
}
function OpenMpesa(){
  var mpesa_url = window.document.getElementById("mpesa_url").value;
  var mpesa_amount = window.document.getElementById("mpesa_amount").value;
  var mpesa_amount_field = window.document.getElementById("mpesa_amount_field").value;
  var mpesa_result_field = window.document.getElementById("mpesa_result_field").value;
  var mpesa_secret_key = window.document.getElementById("mpesa_secret_key").value;
  var mpesa_number = window.document.getElementById("mpesa_number").value;
  var mpesa_user_id = window.document.getElementById("mpesa_user_id").value;
  var url = mpesa_url+"?mpesa_amount="+mpesa_amount+"&mpesa_number="+mpesa_number+"&mpesa_result_field="+mpesa_result_field+"&mpesa_secret_key="+mpesa_secret_key+"&mpesa_user_id="+mpesa_user_id+"&mpesa_amount_field="+mpesa_amount_field;
   var strWindowFeatures = "directories=no,titlebar=no,toolbar=no,location=no,copyhistory=no,status=no,menubar=no,scrollbars=no,resizable=no,height=520,width=450,top=20,left=450";
   window.open(url,"LIPA NA MPESA",strWindowFeatures);
}
</script>
<!-- iPayments Javascript Code End -->
<!-- iPayments Javascript Code Start -->
<script type="text/javascript">
//***being called in sales1scripting_new.js***
function getBarclayAmount(){
var amount = document.getElementById('cardamount').value;
$.ajax({
    type: "POST",
    url: 'barclayscalc.php',
    data : {barclaysamt: amount},
    success: function(data)
    {	
    	document.getElementById("barclays_amount").value = data;
    }
});
}
function OpenBarclays(){
  var barclays_url = window.document.getElementById("barclayscard_url").value;
  var barclays_amount = window.document.getElementById("barclays_amount").value;
  var barclays_result_field = window.document.getElementById("barclays_result_field").value;
  var barclays_amount_field = window.document.getElementById("barclays_amount_field").value;
  var barclays_secret_key = window.document.getElementById("barclays_secret_key").value;
  var barclays_user_id = window.document.getElementById("barclays_user_id").value;

  var url = barclays_url+"?barclays_amount="+barclays_amount+"&barclays_result_field="+barclays_result_field+"&barclays_amount_field="+barclays_amount_field+"&barclays_secret_key="+barclays_secret_key+"&barclays_user_id="+barclays_user_id;
   var strWindowFeatures = "directories=no,titlebar=no,toolbar=no,location=no,copyhistory=no,status=no,menubar=no,scrollbars=no,resizable=no,height=520,width=450,top=20,left=450";
   window.open(url,"Barclays Card Payments",strWindowFeatures);
 }
</script>
<!-- iPayments Javascript Code End -->
<!-- iPayments Encryption Start -->
<?php function iPayment_encrypt($data, $key) {
    //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $secret_iv = 'ivkey';
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $encrypted =openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);return base64_encode($encrypted . '::' . $iv);} ?>
<!-- iPayments Encryption End -->
<!-- iPayments Mobile Start -->
<?php
    function iPayment_mobileTrim($data){
        return ($data!="")?"254".substr($data, -9):"";
    }
?>
<!-- iPayments Mobile End -->
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
