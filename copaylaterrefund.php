<?php
session_start();
error_reporting(0);
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
$updatedate = date("Y-m-d");
$titlestr = 'SALES BILL';

$billnumberget=isset($_REQUEST['billnumber'])?$_REQUEST['billnumber']:'';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["patientname"];
	$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];

$query77 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res77 = mysqli_fetch_array($exec77);
		$doctor = $res77['consultingdoctor'];
		
		$query78 = "select * from master_doctor where auto_number='$doctor'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res78 = mysqli_fetch_array($exec78);
		$doctorname = $res78['doctorname'];
		
	$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paylaterbillprefix = 'Cr.N-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from refund_paylater order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='Cr.N-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'Cr.N-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$billno = $billnumbercode;
	$accountname= $_REQUEST['accountname'];
	$totalamount=$_REQUEST['grandtotalamount'];
	$totalamount=-$totalamount;
	$totalrefundamount = $_REQUEST['grandtotalamount'];
	$billdate=$_REQUEST['billdate'];
	$finalizedbillno=$_REQUEST['finalizedbillno'];
	$labcoa = $_REQUEST['labcoa'];
	$radiologycoa = $_REQUEST['radiologycoa'];
	$servicecoa = $_REQUEST['servicecoa'];
	$pharmacycoa = $_REQUEST['pharmacycoa'];
	$referalcoa = $_REQUEST['referalcoa'];
	
	$locationname = $_REQUEST['locationname'];
	$locationcode = $_REQUEST['locationcode'];
	
		 
		 foreach($_POST['lab'] as $key => $value)
		{
		$labname=$_POST['lab'][$key];
		$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname'");
		$execlab=mysqli_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
	    $labrate=$_POST['rate'][$key];
		foreach($_POST['ref'] as $check1)
		{
		$refund=$check1;
		if($refund == $labname)
	{
	$query45 = "insert into refund_paylaterlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,billnumber,username,labcoa,locationname,locationcode,billtype)values
	           ('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$updatedate','$billno','$username','$labcoa','".$locationname."','".$locationcode."','copay')";
	$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		   

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set labrefund='completed' where patientvisitcode='$visitcode' and labitemcode='$labcode'");
	}
	}
	}
	foreach($_POST['rad'] as $key => $value)
		{
		$radname=$_POST['rad'][$key];
		$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$radname'");
		$execradiology=mysqli_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		$radiologyrate=$_POST['radrate'][$key];
		foreach($_POST['ref'] as $check2)
		{
		$refund2=$check2;
			if($refund2 == $radname)
	{
	$query46 = "insert into refund_paylaterradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,billnumber,username,radiologycoa)values
	           ('$patientcode','$patientname','$visitcode','$radiologycode','$radname','$radiologyrate','$accountname','$updatedate','$billno','$username','$radiologycoa')";
	$exec46 = mysqli_query($GLOBALS["___mysqli_ston"], $query46) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		   

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_radiology set radiologyrefund='refund' where patientvisitcode='$visitcode' and radiologyitemname='$radname'");
	}
	}
	}
	foreach($_POST['ser'] as $key => $value)
		{
		$sername=$_POST['ser'][$key];
		$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$sername'");
		$execservice=mysqli_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		$servicesrate=$_POST['servicerate'][$key];
	
		foreach($_POST['ref'] as $check3)
		{
		$refund3=$check3;
			if($refund3 == $sername)
	{
	$query47 = "insert into refund_paylaterservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,username,servicecoa)values
	           ('$patientcode','$patientname','$visitcode','$servicescode','$sername','$servicesrate','$accountname','$updatedate','$billno','$username','$servicecoa')";
	$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		   

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_services set servicerefund='refund' where patientvisitcode='$visitcode' and servicesitemname='$sername'");
	}
	}
	}
	foreach($_POST['referalname'] as $key => $value)
		{
		$referalname=$_POST['referalname'][$key];
		$referalquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_doctor where doctorname='$referalname'");
		$execreferal=mysqli_fetch_array($referalquery);
		$referalcode=$execreferal['doctorcode'];
		$referalrate=$_POST['referalrate'][$key];

		foreach($_POST['ref'] as $check4)
		{
		$refund4=$check4;
			if($refund4 == $referalname)
	{
	$query47 = "insert into refund_paylaterreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,billnumber,username,referalcoa)values
	           ('$patientcode','$patientname','$visitcode','$referalcode','$referalname','$referalrate','$accountname','$updatedate','$billno','$username','$referalcoa')";
	$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		   

	mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_referal set referalrefund='refund' where patientvisitcode='$visitcode' and referalname='$referalname'");
	}
	}
	}
	
			mysqli_query($GLOBALS["___mysqli_ston"], "insert into refund_paylater(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,referalname,doctorstatus,finalizationbillno)values('$billno','$patientname','$patientcode','$visitcode','$totalamount','$billdate','$accountname','$referalname','unpaid','$finalizedbillno')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query83="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,docno,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,receivableamount,doctorname)values('$patientname',
	          '$patientcode','$visitcode','$dateonly','$accountname','$billno','$ipaddress','$companyanum','$companyname','$financialyear','paylatercredit','$patienttype1','$patientsubtype1','$totalrefundamount','$totalrefundamount','$doctorname')";
	$exec83=mysqli_query($GLOBALS["___mysqli_ston"], $query83) or die("error in query83".mysqli_error($GLOBALS["___mysqli_ston"]));		  

		header("location:paylaterrefundlist.php");
		exit();

}


//to redirect if there is no entry in masters category or item or customer or settings



//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$radiologyname=$_REQUEST['delete'];
mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_radiology where radiologyitemname='$radiologyname'");
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
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];

$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientplan=$execlab['planname'];
$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
$execplan=mysqli_fetch_array($queryplan);
$patientplan1=$execplan['planname'];

?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

$query76 = "select * from master_financialintegration where field='labpaylaterrefund'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologypaylaterrefund'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res761 = mysqli_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='servicepaylaterrefund'";
$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res762 = mysqli_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalpaylaterrefund'";
$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res763 = mysqli_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacypaylaterrefund'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res764 = mysqli_fetch_array($exec764);

$pharmacycoa = $res764['code'];

?>
<?php 
$query54="select * from billing_paylater where patientcode='$patientcode' and visitcode='$visitcode' and billno = '".$billnumberget."'";
$exec54=mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res54=mysqli_fetch_array($exec54);
$finalizedbillnumber=$res54['billno'];
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paylaterbillprefix = 'Cr.N-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from refund_paylater order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='Cr.N-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'Cr.N-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

	$queryloc = "select locationname,locationcode from master_visitentry where  patientcode='$patientcode' and visitcode='$visitcode'";
	$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc.".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resloc = mysqli_fetch_array($execloc);
	 $locationname = $resloc["locationname"];
	 $locationcode = $resloc["locationcode"];
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


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	
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

function updatebox(varSerialNumber,varrate,totalcount)
{

var varSerialNumber = varSerialNumber;
var varrate = varrate;
var totalcount = totalcount;

var grandtotal=0;
if(document.getElementById('reff1'+varSerialNumber).checked == true)
{
//alert(varSerialNumber);
for(i=1;i<=totalcount;i++)
{
if(document.getElementById("reff1"+i+"").checked == true)
{
var totalamount=document.getElementById("rate"+i+"").value;

if(totalamount == "")
{
totalamount=0;
}

grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);
}
}
document.getElementById("totalamtlab").value=grandtotal.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
}
else
{
grandtotal=0;
for(i=1;i<=totalcount;i++)
{

if(document.getElementById("reff1"+i+"").checked == false)
{
if(document.getElementById("reff1"+i+"").checked == true)
{
var totalamount=document.getElementById("rate"+i+"").value;
}
else
{
var totalamount=0;
}
if(totalamount == "")
{
totalamount=0;
}
//alert(totalamount);
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);

}
else
{
if(document.getElementById("reff"+i+"").checked == true)
{
var totalamount=document.getElementById("rate"+i+"").value;
}
else
{
var totalamount=0;
}
if(totalamount == "")
{
totalamount=0;
}
//alert(totalamount);
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);

}
}
document.getElementById("totalamtlab").value=grandtotal.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);


}
}

function updatebox1(varSerialNumber1,varrate1,totalcount1)
{

var varSerialNumber1 = varSerialNumber1;
var varrate1 = varrate1;
var totalcount1 = totalcount1;
//alert(totalcount1);
var grandtotal1=0;
if(document.getElementById("reff1"+varSerialNumber1+"").checked == true)
{
for(i=1;i<=totalcount1;i++)
{
if(document.getElementById("reff1"+i+"").checked == true)
{
//alert('h');
var totalamount1=document.getElementById("rate1"+i+"").value;

if(totalamount1 == "")
{
totalamount1=0;
}

grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);
}
}
document.getElementById("totalamtrad").value=grandtotal1.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
else
{
grandtotal1=0;
for(i=1;i<=totalcount1;i++)
{

if(document.getElementById("reff1"+i+"").checked == false)
{
if(document.getElementById("reff1"+i+"").checked == true)
{
var totalamount1=document.getElementById("rate1"+i+"").value;
}
else
{
var totalamount1=0;
}
if(totalamount1 == "")
{
totalamount1=0;
}
//alert(totalamount);
grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);

}
else
{
if(document.getElementById("reff1"+i+"").checked == true)
{
var totalamount1=document.getElementById("rate1"+i+"").value;
}
else
{
var totalamount1=0;
}
if(totalamount1 == "")
{
totalamount1=0;
}
//alert(totalamount);
grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);

}
}
document.getElementById("totalamtrad").value=grandtotal1.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
}
function updatebox3()
{
if(document.getElementById("reff3").checked == true)
{
var totalamount3=document.getElementById("rates").value;
//alert(totalamount3);
document.getElementById("totalamtconsultation").value=totalamount3;

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamount3)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref);
//alert(grandtotalamount);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);
}
else
{
var totalamount3=0;
document.getElementById("totalamtconsultation").value=totalamount3.toFixed(2);
var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);

var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamount3)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
}
function updatebox2(varSerialNumber2,varrate2,totalcount2)
{

var varSerialNumber2 = varSerialNumber2;
var varrate2 = varrate2;
var totalcount2 = totalcount2;
//alert(totalcount1);
var grandtotal2=0;
if(document.getElementById("reff2"+varSerialNumber2+"").checked == true)
{
for(i=1;i<=totalcount2;i++)
{
if(document.getElementById("reff2"+i+"").checked == true)
{
//alert('h');
var totalamount2=document.getElementById("rate2"+i+"").value;

if(totalamount2 == "")
{
totalamount2=0;
}

grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);
}
}
document.getElementById("totalamtser").value=grandtotal2.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
else
{
grandtotal2=0;
for(i=1;i<=totalcount2;i++)
{

if(document.getElementById("reff2"+i+"").checked == false)
{
if(document.getElementById("reff2"+i+"").checked == true)
{
var totalamount2=document.getElementById("rate2"+i+"").value;
}
else
{
var totalamount2=0;
}
if(totalamount2 == "")
{
totalamount2=0;
}
//alert(totalamount);
grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);

}
else
{
if(document.getElementById("reff2"+i+"").checked == true)
{
var totalamount2=document.getElementById("rate2"+i+"").value;
}
else
{
var totalamount2=0;
}
if(totalamount2 == "")
{
totalamount2=0;
}
//alert(totalamount);
grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);

}
}
document.getElementById("totalamtser").value=grandtotal2.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);


}
}
function updatebox4(varSerialNumber4,varrate4,totalcount4)
{

var varSerialNumber4 = varSerialNumber4;
var varrate4 = varrate4;
var totalcount4 = totalcount4;
//alert(totalcount1);
var grandtotal4=0;
if(document.getElementById("reff4"+varSerialNumber4+"").checked == true)
{
for(i=1;i<=totalcount4;i++)
{
if(document.getElementById("reff4"+i+"").checked == true)
{
//alert('h');
var totalamount4=document.getElementById("rate4"+i+"").value;

if(totalamount4 == "")
{
totalamount4=0;
}

grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);
}
}
document.getElementById("totalamtref").value=grandtotal4.toFixed(2);

var totalamountconsultation=document.getElementById("totalamtconsultation").value;
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
else
{
grandtotal4=0;
for(i=1;i<=totalcount4;i++)
{

if(document.getElementById("reff4"+i+"").checked == false)
{
if(document.getElementById("reff4"+i+"").checked == true)
{
var totalamount4=document.getElementById("rate4"+i+"").value;
}
else
{
var totalamount4=0;
}
if(totalamount4 == "")
{
totalamount4=0;
}
//alert(totalamount);
grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);

}
else
{
if(document.getElementById("reff4"+i+"").checked == true)
{
var totalamount4=document.getElementById("rate4"+i+"").value;
}
else
{
var totalamount4=0;
}
if(totalamount4 == "")
{
totalamount4=0;
}
//alert(totalamount);
grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);

}
}
document.getElementById("totalamtref").value=grandtotal4.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);


}
}
</script>
<script type="text/javascript" src="js/insertnewitem7.js"></script>
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
.bal
{
border-style:none;
background:none;
text-align:right;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>

<script src="js/datetimepicker_css.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="copaylaterrefund.php" onKeyDown="return disableEnterKey(event)">
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
                <tr bgcolor="#011E6A">
                <td colspan="7" bgcolor="#ecf0f5" class="bodytext32"><strong>Pay Later Patient Details</strong></td>
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			  <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientname; ?>
				<input type="hidden" name="patientname" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  </td>
                     	<input type="hidden" name="labcoa" value="<?php echo $labcoa; ?>">
				<input type="hidden" name="radiologycoa" value="<?php echo $radiologycoa; ?>">
				<input type="hidden" name="servicecoa" value="<?php echo $servicecoa; ?>">
				<input type="hidden" name="pharmacycoa" value="<?php echo $pharmacycoa; ?>">
				<input type="hidden" name="referalcoa" value="<?php echo $referalcoa; ?>">
		
             <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Type</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patienttype1; ?>
				<input type="hidden" name="account" id="account" value="<?php echo $patienttype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
		      </tr>
			   <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientcode; ?>
				<input type="hidden" name="customercode" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Sub Type</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientsubtype1; ?>
				<input type="hidden" name="account" id="account" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
			  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $visitcode; ?>
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientaccount1; ?>
				<input type="hidden" name="accountname" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $billnumbercode; ?>
				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Plan Name</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientplan1; ?>
				<input type="hidden" name="account" id="account" value="<?php echo $patientplan1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> Date</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $dateonly; ?>
				<input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $locationname; ?><input type="hidden" name="finalizedbillno" value="<?php echo $finalizedbillnumber; ?>">
                <input type="hidden" name="locationname" value="<?php echo $locationname; ?>" >
                <input type="hidden" name="locationcode" value="<?php echo $locationcode; ?>" >
				<input type="hidden" name="account" id="account" value="" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
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
           <tr bgcolor="#011E6A">
                <td colspan="8" bgcolor="#ecf0f5" class="bodytext32"><strong>Transaction Details</strong></td>
			 </tr>
          
            <tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
				<td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Refund</strong></div></td>
                  </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$sso3=0;
			$query17 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['consultationfees'];
			$consultationfee=number_format($consultationfee,2);
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			
			$planpercentage=$res17['planpercentage'];
			
			$planname=$res17['planname'];
			
			$queryplan = "select * from master_planname where auto_number='$planname'";
			$execplan = mysqli_query($GLOBALS["___mysqli_ston"], $queryplan) or die ("Error in Queryplan".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplan = mysqli_fetch_array($execplan);
		    $forall=$resplan['forall'];
			
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
			$totalop=$consultationfee;
			$sso3=$sso3+1;
			?>
			  <?php /*?><tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $viscode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'OP Consultation'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
				<input type="hidden" name="rate" id="rates" value="<?php echo $consultationfee; ?>">
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
				 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reff3" value="" onClick="updatebox3()"/></strong></div></td>
             
				</tr><?php */?>
			<?php 
				$query18 = "select * from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18 = mysqli_fetch_array($exec18);
			$billingdatetime=$res18['billingdatetime'];
			$billno=$res18['billnumber'];
			$copay=$res18['copayfixedamount'];
			if($copay != 0.00)
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
			$totalcopay=$copay;
			 ?>
			 <?php /*?><tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $itemcode; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $resquantity;?>','<?php echo $nno; ?>')"/></strong></div></td>
             
			  </tr><?php */?>
			  <?php } ?>
			  <?php 
			  $totallab=0;
			  $sso=0;
			  $query19 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labrefund = 'refund' and labitemname <> '' ";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb=mysqli_num_rows($exec19);
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['refno'];
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
			$totallab=$totallab+$labrate;
			$sso=$sso+1;
			
			if(($planpercentage!=0.00)&&($forall=='yes'))
			{
				$copaylab=($labrate/100)*$planpercentage;
			$totalcopay=$totalcopay+$copaylab;
				}
				else
				{
					$copaylab=$labrate;
			$totalcopay=$totalcopay+$copaylab;
					}
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <input type="hidden" name="lab[]" value="<?php echo $labname; ?>">
			 <input type="hidden" name="labrate[]" value="<?php echo $labrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copaylab; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copaylab; ?></div></td>
			  <input type="hidden" name="rate[]" id="rate<?php echo $sso; ?>" value="<?php echo $copaylab; ?>">
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reff1<?php echo $sso; ?>" value="<?php echo $labname; ?>" onClick="updatebox('<?php echo $sso; ?>','<?php echo $labrate;?>','<?php echo $numb; ?>')"/></strong></div></td>
             
			  
			  <?php }
			  ?>
			   <?php 
			   $totalpharm=0;
			  $query23 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res23 = mysqli_fetch_array($exec23))
			{
			$totqty = 0;
			$phadate=$res23['recorddate'];
			$phaname=$res23['medicinename'];
			$phaquantity=$res23['quantity'];
			
			$query66 = "select * from pharmacysalesreturn_details where visitcode = '$visitcode' and itemname = '$phaname'";
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res66 = mysqli_fetch_array($exec66))
			{
			$quantity1 = $res66['quantity'];
			$totqty = $totqty + $quantity1;
			}
			$phaquantity =$phaquantity - $totqty ;
			$pharate=$res23['rate'];
			$phaamount= $phaquantity * $pharate;
			$pharefno=$res23['refno'];
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
			$totalpharm=$totalpharm+$phaamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $pharate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount,2,'.',''); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $itemcode; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $resquantity;?>','<?php echo $nno; ?>')"/></strong></div></td>
             
			  
			  <?php }
			  ?>
			    <?php 
				$totalrad=0;
				$sso1=0;
			  $query20 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyrefund='' and radiologyitemname <> ''";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb1=mysqli_num_rows($exec20);
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['refno'];
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
			$totalrad=$totalrad+$radrate;
			$sso1=$sso1+1;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>
			 <input type="hidden" name="rad[]" value="<?php echo $radname; ?>">
			  <input type="hidden" name="radrate[]" value="<?php echo $radrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $radrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $radrate; ?></div></td>
			 	  <input type="hidden" name="rate[]" id="rate1<?php echo $sso1; ?>" value="<?php echo $radrate; ?>">
		
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reff1<?php echo $sso1; ?>" value="<?php echo $radname; ?>" onClick="updatebox1('<?php echo $sso1; ?>','<?php echo $radrate;?>','<?php echo $numb1; ?>')"/></strong></div></td>
             
			  
			  <?php }
			  ?>
			  	    <?php 
					
					$totalser=0;
					$sso2=0;
			  $query21 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicerefund='' and servicesitemname <> ''";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numb2=mysqli_num_rows($exec21);
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['refno'];
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
			$totalser=$totalser+$serrate;
			$sso2=$sso2+1;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input type="hidden" name="ser[]" value="<?php echo $sername; ?>">
			  <input type="hidden" name="servicerate[]" value="<?php echo $serrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $serrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $serrate; ?></div></td>
				  <input type="hidden" name="rate[]" id="rate2<?php echo $sso2; ?>" value="<?php echo $serrate; ?>">
		
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reff2<?php echo $sso2; ?>" value="<?php echo $sername; ?>" onClick="updatebox2('<?php echo $sso2; ?>','<?php echo $serrate;?>','<?php echo $numb2; ?>')"/></strong></div></td>
             
			  
			  <?php }
			  ?>
			   <?php 
			   $totalref=0;
			   $sso4=0;
			  $query22 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode' and referalrefund=''";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numbb=mysqli_num_rows($exec22);
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['referalname'];
			$refrate=$res22['referalrate'];
			$refref=$res22['refno'];
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
			$totalref=$totalref+$refrate;
			$sso4=$sso4+1;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname[]" value="<?php echo $refname; ?>">
			  <input type="hidden" name="referalrate[]" value="<?php echo $refrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <input type="hidden" name="rate[]" id="rate4<?php echo $sso4; ?>" value="<?php echo $refrate; ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reff4<?php echo $sso4; ?>" value="<?php echo $refname; ?>" onClick="updatebox4('<?php echo $sso4; ?>','<?php echo $refrate;?>','<?php echo $numbb; ?>')"/></strong></div></td>
             
			  
			  <?php }
			  ?>
			  <?php 
			  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref)-$totalcopay;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop-$totalcopay;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref;
			   $netpay=number_format($netpay,2,'.','');
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
                bgcolor="#ecf0f5"><strong><?php echo $totalcopay; ?></strong></td>
				 <td width="4%"  align="left" valign="center" 
               class="bodytext31" bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
             
			 </tr>
          </tbody>
        </table>		</td>
		<tr>
		 <td colspan="7" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
		<tr>
		<td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		 <tr bgcolor="#011E6A">
                <td colspan="7" bgcolor="#ecf0f5" class="bodytext32"><strong>Payable Details</strong></td>
			 </tr>
          <tr>
		    <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
              <td width="37%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">Total for Consultation</div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><input type="text" name="totalamtconsultation" id="totalamtconsultation" size="7" class="bal" readonly></div></td>
				 <td width="15%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
			</tr>
				
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
                <td width="37%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Laboratory</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><input type="text" name="totalamtlab" id="totalamtlab" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
					<td width="37%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Radiology </div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><input type="text" name="totalamtrad" id="totalamtrad" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Service	</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><input type="text" name="totalamtser" id="totalamtser" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Referral		</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><input type="text" name="totalamtref" id="totalamtref" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong>&nbsp;</strong></div></td>
			
              <td width="37%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Net Payable	</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><input type="text" name="grandtotalamount" id="grandtotalamount" value="" class="bal" size="7"></strong></div></td>
				
				  <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong>&nbsp;</strong></div></td>
			
            </tr>
				  </tbody>
				  </table>				  </td>
				    <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="left"><strong>User Name</strong> <span class="bodytext3">
                 <?php echo $_SESSION['username']; ?>
                </span></div></td>
                <td height="32" colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				    </tr>
				  
      </tr>
      
     
      <tr>
        
		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
               <input name="Submit222" type="submit"  value="Save Bill" class="button" style="border: 1px solid #001E6A"/>		 </td>
      </tr>
      </td>
      </tr>
    </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>