<?php
session_start();
error_reporting(0);
set_time_limit(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["customername"];
	$consultationdate = date("Y-m-d");
	$accountname = $_REQUEST["account"];
	$billtype = $_REQUEST['billtype'];
	if($billtype =='PAY NOW')
	{
	$status='pending';
	}
	else
	{
		$query173 = "select planpercentage from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec173 = mysqli_query($GLOBALS["___mysqli_ston"], $query173) or die ("Error in Query173".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res173 = mysqli_fetch_array($exec173);
		$planpercentage = $res173['planpercentage'];
		if($planpercentage == '0.00')
		{
			$status='completed';
		}
		else
		{
			$status='pending';
		}
	}
	$query2 = "select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$medrefnonumber = $res2["refno"];

foreach($_POST['aitemcode'] as $key => $value)
{
$aitemcode = $_POST['aitemcode'][$key];
$adays = $_POST['adays'][$key];
$adose = $_POST['adose'][$key];
$aquantity = $_POST['aquantity'][$key];
$aroute = $_POST['aroute'][$key];
$aamount =  $_POST['aamount'][$key];
$afrequency = $_POST['afrequency'][$key];
$ainstructions = $_POST['ainstructions'][$key];

$sele=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencycode='$afrequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$ress=mysqli_fetch_array($sele);
$frequencyautonumber=$ress['auto_number'];
$frequencycode=$ress['frequencycode'];

$query34 = "update master_consultationpharm set days='$adays',dose='$adose',quantity='$aquantity',route='$aroute',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency',instructions='$ainstructions' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode'";
$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

$query35 = "update master_consultationpharmissue set days='$adays',dose='$adose',prescribed_quantity='$aquantity',quantity='$aquantity',route='$aroute',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency',instructions='$ainstructions' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode'";
$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

}

	
		for ($p=1;$p<=20;$p++)
		{	
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_REQUEST['medicinename'.$p];
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$dose = $_REQUEST['dose'.$p];
		    $frequency = $_REQUEST['frequency'.$p];
			$sele=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_frequency where frequencycode='$frequency'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress=mysqli_fetch_array($sele);
			$frequencyautonumber=$ress['auto_number'];
			$frequencycode=$ress['frequencycode'];
			$frequencynumber=$ress['frequencynumber'];
			$days = $_REQUEST['days'.$p];
			$quantity = $_REQUEST['quantity'.$p];
			$route = $_REQUEST['route'.$p];
			$instructions = $_REQUEST['instructions'.$p];
			$rate = $_REQUEST['rates'.$p];
			$amount = $_REQUEST['amount'.$p];
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		        //echo '<br>'. 
		        $query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,source,route) 
				values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','$status','$medicinecode','$medrefnonumber','$status','pending','doctorconsultation','$route')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$query29 = "insert into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,prescribed_quantity,source,route) 
				values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','$status','$medicinecode','$medrefnonumber','$quantity','doctorconsultation','$route')";
				$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				}
				}
		header("location:amend_pending_pharmacy.php");
		exit;

}


//to redirect if there is no entry in masters category or item or customer or settings



//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$medicinename=$_REQUEST['delete'];
$viscode=$_REQUEST['visitcode'];
mysqli_query($GLOBALS["___mysqli_ston"], "delete from master_consultationpharm where auto_number='$medicinename' and patientvisitcode='$viscode'");
mysqli_query($GLOBALS["___mysqli_ston"], "delete from master_consultationpharmissue where auto_number='$medicinename' and patientvisitcode='$viscode'");

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
$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];
$subtypeanum = $res78['subtype'];
$patientname=$res78['patientfullname'];
$patientaccount=$res78['accountfullname'];

$query131 = "select * from master_subtype where auto_number = '$subtypeanum'";
$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
$res131 = mysqli_fetch_array($exec131);
$res131subtype = $res131['subtype'];
?>

<?php



$querylab7=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execlab7=mysqli_fetch_array($querylab7);
$billtype=$execlab7['billtype'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$labprefix = $res3['labprefix'];

$query2 = "select * from billing_lab order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
if ($billnumber == '')
{
	$billnumbercode =$labprefix.'00000001';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber, 3, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$billnumbercode = $labprefix .$maxanum1;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>

<script language="javascript">
function validcheck()
{
if(confirm("Do You Want To Save The Record? ")==false) {return false;}	
}

function frequencyitem()
{
if(document.form1.frequency.value=="select")
{
alert("please select a frequency");
document.form1.frequency.focus();
return false;
}
return true;
}

function Functionfrequency(i)
{
var i = i;

var formula = document.getElementById("aformula"+i+"").value;
formula = formula.replace(/\s/g, '');
//alert(formula);
if(formula == 'INCREMENT')
{
var ResultFrequency;
 var frequencyanum = document.getElementById("afrequency"+i+"").value;
var medicinedose=document.getElementById("adose"+i+"").value;
 var VarDays = document.getElementById("adays"+i+"").value; 

 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum * VarDays;
 }
 else
 {
 ResultFrequency =0;
 }
 document.getElementById("aquantity"+i+"").value = ResultFrequency;
var VarRate = document.getElementById("arate"+i+"").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("aamount"+i+"").value = ResultAmount.toFixed(2);
}

else if(formula == 'CONSTANT')
{
var ResultFrequency;
var strength = document.getElementById("astrength"+i+"").value;
 var frequencyanum = document.getElementById("afrequency"+i+"").value;
var medicinedose=document.getElementById("adose"+i+"").value;
 var VarDays = document.getElementById("adays"+i+"").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum*VarDays/strength;
 }
 else
 {
 ResultFrequency =0;
 }
 //ResultFrequency = parseInt(ResultFrequency);

 ResultFrequency = Math.ceil(ResultFrequency);
 //alert(ResultFrequency);
 document.getElementById("aquantity"+i+"").value = ResultFrequency;
 
 
var VarRate = document.getElementById("arate"+i+"").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("aamount"+i+"").value = ResultAmount.toFixed(2);
}
}

function Functionfrequency1()
{
var formula = document.getElementById("formula").value;
formula = formula.replace(/\s/g, '');
//alert(formula);
if(formula == 'INCREMENT')
{
var ResultFrequency;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum * VarDays;
 }
 else
 {
 ResultFrequency =0;
 }
 document.getElementById("quantity").value = ResultFrequency;
var VarRate = document.getElementById("rates").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}

else if(formula == 'CONSTANT')
{
var ResultFrequency;
var strength = document.getElementById("strength").value;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum*VarDays/strength;
 }
 else
 {
 ResultFrequency =0;
 }
 //ResultFrequency = parseInt(ResultFrequency);

 ResultFrequency = Math.ceil(ResultFrequency);
 //alert(ResultFrequency);
 document.getElementById("quantity").value = ResultFrequency;
 
 
var VarRate = document.getElementById("rates").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}
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
function btnDeleteClick10(delID,pharmamount)
{
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
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	var currenttotal4=document.getElementById('total').value;
	//alert(currenttotal);
	newtotal4= currenttotal4-pharmamount;
	
	//alert(newtotal);
	
	document.getElementById('total').value=newtotal4;
	

}

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


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch4();
	funcPopupPrintFunctionCall();
	
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
<?php include ("js/sales1scripting1.php"); ?>
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



</script>

<?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch2.js"></script>
<script type="text/javascript" src="js/insertnewitem10.js"></script>


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
text-align:right;
FONT-FAMILY: Tahoma;
FONT-SIZE: 11px;
}
</style>

<script src="js/datetimepicker_css.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="amendpharmacy.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
    <td width="99%" valign="top"><table width="1031" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              
			 
		
			  <tr>
			    <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient * </strong></td>
                <td width="36%" align="left" valign="middle" class="bodytext3">
				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
                  </td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
			   <tr>
			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input name="patientage" type="hidden" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
				<input type="hidden" name="address1" id="address1" value="<?php echo $res41address1; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="30" />
			      <span class="style4"><!--Area--> </span>
			      <input type="hidden" name="area" id="area" value="<?php echo $res41area; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="10" />
				  <input type="hidden" name="subtype" id="subtype" value="<?php echo $res131subtype; ?>">
				  </td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientaccount; ?>
				<input type="hidden" name="billtype" value="<?php echo $billtype; ?>">				  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3" >
				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
				
				  </tr>
            </tbody>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
              <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Medicine Name</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dose</strong></div></td>
			
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Freq</strong></div></td>
			
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days </strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Quantity </strong></div></td>
			<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Route </strong></div></td>
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Instructions </strong></div></td>

				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
                  </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			
			if($billtype == 'PAY NOW')
			{
			$status='pending';
			}
			else
			{
				$query173 = "select planpercentage from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec173 = mysqli_query($GLOBALS["___mysqli_ston"], $query173) or die ("Error in Query173".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res173 = mysqli_fetch_array($exec173);
				$planpercentage = $res173['planpercentage'];
				if($planpercentage == '0.00')
				{
					$status='completed';
				}
				else
				{
					$status='pending';
				}
			}
	
			
			$query17 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and pharmacybill='$status' and medicineissue='pending'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$nums=mysqli_num_rows($exec17);
			while ($res17 = mysqli_fetch_array($exec17))
			{
			
				$paharmitemname=$res17['medicinename'];
				$pharmitemcode=$res17['medicinecode'];
				$pharmdose=$res17['dose'];
				$pharmfrequency=$res17['frequencynumber'];
				$pharmdays=$res17['days'];
				$pharmquantity=$res17['quantity'];
			$pharmitemrate=$res17['rate'];
			$pharmamount=$res17['amount'];
			$route = $res17['route'];
			$instructions = $res17['instructions'];
			$medanum = $res17['auto_number'];
			
			$query77="select * from master_medicine where itemcode='$pharmitemcode'";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$formula = $res77['formula'];
			$strength = $res77['roq'];

		
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemcode; ?><input type="hidden" name="aitemcode[]" id="aitemcode<?php echo $sno; ?>" value="<?php echo $pharmitemcode; ?>"></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="adose[]" id="adose<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdose; ?>" size="8" style="text-align:center;"></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center">
				 <input type="hidden" name="aformula" id="aformula<?php echo $sno; ?>" value="<?php echo $formula; ?>">
				 <input type="hidden" name="astrength" id="astrength<?php echo $sno; ?>" value="<?php echo $strength; ?>">
				 <select name="afrequency[]" id="afrequency<?php echo $sno; ?>" onChange="return Functionfrequency('<?php echo $sno; ?>')">
				  <?php
				if ($pharmfrequency == '')
				{
					echo '<option value="select" selected="selected">Select frequency</option>';
				}
				else
				{
					$query51 = "select * from master_frequency where frequencynumber='$pharmfrequency' and recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51code = $res51["frequencycode"];
					$res51num = $res51['frequencynumber'];
					echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';
				}
				$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5num = $res5["frequencynumber"];
				$res5code = $res5["frequencycode"];
				?>
                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
				</select>
				 </div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="adays[]" id="adays<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdays; ?>" size="8" style="text-align:center;"></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aquantity[]" id="aquantity<?php echo $sno; ?>" value="<?php echo $pharmquantity; ?>" size="8" class="bal" readonly></div></td>
				<td class="bodytext31" valign="center"  align="left">
			<select name="aroute[]" id="aroute">
			  <?php
				if ($route == '')
				{
					echo '<option value="select" selected="selected">Select Route</option>';
				}
				else
				{
				
				echo '<option value="'.$route.'" selected="selected">'.$route.'</option>';
				}
				?>
					  
					   <option value="Oral">Oral</option>
					   <option value="Sublingual">Sublingual</option>
					   <option value="Rectal">Rectal</option>
					   <option value="Vaginal">Vaginal</option>
					   <option value="Topical">Topical</option>
					   <option value="Intravenous">Intravenous</option>
					   <option value="Intramuscular">Intramuscular</option>
					   <option value="Subcutaneous">Subcutaneous</option>
					   </select>	
				</td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="ainstructions[]" id="ainstructions<?php echo $sno; ?>" value="<?php echo $instructions; ?>" size="15"></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="arate[]" id="arate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>" size="8" class="bal" readonly></div></td>
				
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aamount[]" id="aamount<?php echo $sno; ?>" value="<?php echo $pharmamount; ?>" size="8" class="bal" readonly></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="amendpharmacy.php?delete=<?php echo $medanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Delete</a></div></td>
				
				</tr>
			<?php } ?>
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
        </table>		</td>
      </tr>
      <tr>
	   <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Prescribe Medicine</strong></td>
	 
	  </tr>
     <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="150" class="bodytext3">Medicine Name</td>
                       <td width="48" class="bodytext3">Dose</td>
                       <td width="41" class="bodytext3">Freq</td>
                       <td width="48" class="bodytext3">Days</td>
                       <td width="48" class="bodytext3">Quantity</td>
					    <td width="48" class="bodytext3">Route</td>
                       <td width="120" class="bodytext3">Instructions</td>
                       <td class="bodytext3">Rate</td>
                       <td width="48" class="bodytext3">Amount</td>
                       <td width="42" class="bodytext3">&nbsp;</td>
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
					  <input type="hidden" name="genericname" id="genericname">
					  <input type="hidden" name="drugallergy" id="drugallergy">
					     <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			           <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">

                       <td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()"></td>
                       <td><input name="dose" type="text" id="dose" size="8" onKeyUp="return Functionfrequency1()"></td>
                       <td>
					    <input name="formula" type="hidden" id="formula" readonly size="8">
						<input name="strength" type="hidden" id="strength" readonly size="8">
					   <select name="frequency" id="frequency" onChange="return Functionfrequency1()">
					     <?php
				if ($frequncy == '')
				{
					echo '<option value="select" selected="selected">Select frequency</option>';
				}
				else
				{
					$query51 = "select * from master_frequency where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51code = $res51["frequencycode"];
					$res51num = $res51['frequencynumber'];
					echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';
				}
				$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5num = $res5["frequencynumber"];
				$res5code = $res5["frequencycode"];
				?>
                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
               </select>				</td>	
                       <td><input name="days" type="text" id="days" size="8" onKeyUp="return Functionfrequency1()" onFocus="return frequencyitem()"></td>
                       <td><input name="quantity" type="text" id="quantity" size="8" readonly></td>
					    <td><select name="route" id="route">
					   <option value="">Select Route</option>
					   <option value="Oral">Oral</option>
					   <option value="Sublingual">Sublingual</option>
					   <option value="Rectal">Rectal</option>
					   <option value="Vaginal">Vaginal</option>
					   <option value="Topical">Topical</option>
					   <option value="Intravenous">Intravenous</option>
					   <option value="Intramuscular">Intramuscular</option>
					   <option value="Subcutaneous">Subcutaneous</option>
					   </select></td>
                       <td><input name="instructions" type="text" id="instructions" size="20"></td>
                       <td width="48"><input name="rates" type="text" id="rates" readonly size="8"></td>
                       <td>
                         <input name="amount" type="text" id="amount" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" >
                       </label></td>
				     </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
          </tr>
				    <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total</span><input type="text" id="total" readonly size="7"></td>
			      </tr>
      <tr>
        
		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
               <input name="Submit222" type="submit"  value="Save Request" class="button"/>
		 </td>
      </tr>
	  </table>
      </td>
      </tr>
    
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>