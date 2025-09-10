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
$docno = $_SESSION['docno'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';

$query23 = "select b.test_backdate from master_employee as a join master_role as b on a.role_id=b.role_id where a.username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res23 = mysqli_fetch_array($exec23);
$res_test_backdate = $res23['test_backdate'];

$queryip= "select b.limit from master_employee as a join master_role as b on a.role_id=b.role_id where a.username='$username'";
$execip = mysqli_query($GLOBALS["___mysqli_ston"], $queryip) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$resip = mysqli_fetch_array($execip);
$ser_rolelimit = $resip['limit'];
	
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	$paynowbillprefix = 'TP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from iptest_procedures order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='TP-'.'1';
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
	
	
	$billnumbercode = 'TP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

	$billdate=$_REQUEST['billdate'];
	
	$paymentmode = $_REQUEST['billtype'];
		$patientfullname = $_REQUEST['customername'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$billtype = $_REQUEST['billtypes'];
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender'];
		$account = $_REQUEST['account'];
		$locationcode=$_REQUEST['location'];
	    $rad= $_POST['radiology'];
		$rat=$_POST['rate8'];
		$items = array_combine($rad,$rat);
		$pairs = array();
		
		$subtypeano=$_REQUEST['subtypeano'];

		$query2 = "select sum(rows) as rows from (SELECT  count(auto_number) AS rows FROM billing_ipcreditapproved WHERE visitcode = '$visitcode'
			UNION ALL 
			SELECT  count(auto_number) AS rows FROM billing_ip WHERE visitcode = '$visitcode') as a";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			
			$rows = $res2['rows'];
			
			if($rows> 0 ){
                 echo "<script>alert('Bill Already Finalized');history.back();</script>";
		         exit;
			}
		
		
		foreach($_POST['radiology'] as $key=>$value)
		{	
			//echo '<br>'.
		
		$pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		$radiologyfree = $_POST['radiologyfree'][$key];
		$radiologycode=trim($_POST['radiologycode'][$key]);

		$query13r = "select radtemplate from master_subtype where auto_number = '$subtypeano' order by subtype";
		$exec13r = mysqli_query($GLOBALS["___mysqli_ston"], $query13r) or die ("Error in Query13r".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res13r = mysqli_fetch_array($exec13r);
		$tablenamer = $res13r['radtemplate'];
		if($tablenamer == '')
		{
		  $tablenamer = 'master_radiology';
		}
		
		$stringbuild1 = "";
/* 		$query1 = "select itemcode from $tablenamer where status = '' AND itemname = '$pairvar'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$execradiology=mysql_fetch_array($exec1);
		$radiologycode=$execradiology['itemcode'];	 */
		
		
		if(($pairvar!="")&&($pairvar1!=""))
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "INSERT into ipconsultation_radiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,consultationdate,resultentry,iptestdocno,accountname,billtype,consultationtime,freestatus,locationcode,username)values('$patientcode','$patientfullname','$visitcode','$radiologycode','$pairvar','$pairvar1','$billdate','pending','$billnumbercode','$account','$billtype','$timeonly','$radiologyfree','$locationcode','$username')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}
}
		
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labcode=trim($_POST['labcode'][$key]);
		$labrate=$_POST['rate5'][$key];
		$labfree=$_POST['labfree'][$key];
	
		$query13l = "select labtemplate from master_subtype where auto_number = '$subtypeano' and recordstatus<>'deleted' order by subtype";
		$exec13l = mysqli_query($GLOBALS["___mysqli_ston"], $query13l) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res13l = mysqli_fetch_array($exec13l);
		$tablenamel = $res13l['labtemplate'];
		if($tablenamel == '')
		{
		  $tablenamel = 'master_lab';
		}
		
		$stringbuild1 = "";
/* 		$query1 = "select itemcode from $tablenamel where status = '' AND itemname='$labname'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$numb=mysql_num_rows($exec1);
		$execlab = mysql_fetch_array($exec1);
		
		$labcode=$execlab['itemcode']; */
		
		
		
		if(($labname!="")&&($labrate!=''))
		{
			$labquery1_sql="INSERT into ipconsultation_lab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,consultationdate,paymentstatus,labsamplecoll,resultentry,labrefund,iptestdocno,accountname,billtype,consultationtime,freestatus,locationcode,username)values('$patientcode','$patientfullname','$visitcode','$labcode','$labname','$labrate','$billdate','paid','pending','pending','norefund','$billnumbercode','$account','$billtype','$timeonly','$labfree','$locationcode','$username')";
		$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], $labquery1_sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				}
		}
			foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;
		$ledgercode=$_POST["ledgercode"][$key];
 		$ledgername=$_POST["ledgername"][$key];
		$servicesname=addslashes($_POST["services"][$key]);


		$query13s = "select sertemplate from master_subtype where auto_number = '$subtypeano' order by subtype";
		$exec13s = mysqli_query($GLOBALS["___mysqli_ston"], $query13s) or die ("Error in Query13s".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res13s = mysqli_fetch_array($exec13s);
		$tablenames = $res13s['sertemplate'];
		if($tablenames == '')
		{
		  $tablenames = 'master_services';
		}
		
		$stringbuild1 = "";
/*  		$query1 = "select itemcode from $tablenames where status = '' AND itemname='".$servicesname."'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$execservice=mysql_fetch_array($exec1);
		$servicescode=$execservice['itemcode']; */
		
		$servicescode=$_POST["servicescode"][$key];
		$serdoct=$_POST["serdoct"][$key];
		$serdoctcode=$_POST["serdoctcode"][$key];
		$servicesrate=$_POST["rate3"][$key];
		$servicesfree = $_POST["servicesfree"][$key];
		$quantityser=$_POST['quantityser3'][$key];
		$seramount=$_POST['totalservice3'][$key];
		/*for($se=1;$se<=$quantityser;$se++)
		{*/	
		//exit;	
		if(($servicesname!="")&&($servicesrate!=''))
		{
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "INSERT into ipconsultation_services(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,consultationdate,paymentstatus,process,iptestdocno,accountname,billtype,consultationtime,freestatus,locationcode,serviceqty,amount,incomeledgercode,incomeledgername,username,doctorcode,doctorname)values('$patientcode','$patientfullname','$visitcode','$servicescode','$servicesname','$servicesrate','$billdate','paid','pending','$billnumbercode','$account','$billtype','$timeonly','$servicesfree','$locationcode','".$quantityser."','".$seramount."','$ledgercode','$ledgername','$username','$serdoctcode','$serdoct')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//$referalquery1=mysql_query("insert into ipprivate_doctor(docno,units,amount,patientcode,patientname,patientvisitcode,doctorname,rate,billtype,accountname,consultationdate,paymentstatus,consultationtime,username,ipaddress,remarks, servicecode, locationcode,doccoa)values('$billnumbercode','$quantityser','$seramount','$patientcode','$patientfullname','$visitcode','$serdoct','$servicesrate','$billtype','$account','$billdate','pending','$timeonly','$username','$ipaddress','$servicesname','$servicescode', '$locationcode','$serdoctcode')") or die(mysql_error());
		
		mysqli_query($GLOBALS["___mysqli_ston"], "insert into iptest_procedures(docno,patientname,patientcode,visitcode,account,recorddate,ipaddress,recordtime,username,billtype,locationcode,doctorcode,doctorname)values('$billnumbercode','$patientfullname','$patientcode','$visitcode','$account','$billdate','$ipaddress','$timeonly','$username','$billtype','$locationcode','$serdoctcode','$serdoct')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		/*}*/
		}		
		
	
	
	
	
		header("location:activeinpatientlist.php");
		exit;
		exit;
	   
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
$searchlocation=$_REQUEST["searchlocation"];

	$query12 = "select * from master_location where locationcode='$searchlocation'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res12 = mysqli_fetch_array($exec12);
	
	 $searchlocationname = $res12["locationname"];
	
}


//This include updatation takes too long to load for hunge items database.


//To populate the autocompetelist_services1.js


//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');

$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"],$query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
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
 $patientname = $execlab['customerfullname'];
 $billtype = $execlab['billtype'];
 
$Queryloc=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execloc=mysqli_fetch_array($Queryloc);
 $locationcode=$execloc['locationcode'];
 $locationname=$execloc['locationname'];
 $packcharge = $execloc['packchargeapply'];
 $patientaccount=$execloc['accountname'];
 $visitlimit=$execloc['visitlimit'];

$patienttype=$execlab['maintype'];
$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$res131subtype=$execsubtype['subtype'];
$patientplan=$execlab['planname'];
$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
$execplan=mysqli_fetch_array($queryplan);
$patientplan1=$execplan['planname'];
$res111subtype=$patientsubtype;

$query2 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$admissiondate = $res2['recorddate'];
?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];


$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'TP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from iptest_procedures order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='TP-'.'1';
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
	
	
	$billnumbercode = 'TP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php 
 $locationcode=$execloc['locationcode'];


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


 //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.

	funcPopupPrintFunctionCall();
		//funcCustomerDropDownSearch3();
	//funcCustomerDropDownSearch1();
	//funcCustomerDropDownSearch2();
		
		funcOnLoadBodyFunctionCall1();
	
}
function funcOnLoadBodyFunctionCall1()
{
    
	
	funcLabHideView();
	funcRadHideView();
	funcSerHideView();
	
}



function funcLabShowView()
{


 
  if (document.getElementById("labid") != null) 
     {
	 document.getElementById("labid").style.display = 'none';
	}
	if (document.getElementById("labid") != null) 
	  {
	  document.getElementById("labid").style.display = '';
	 }
	 
	return true;
	 return true;
}
	
function funcLabHideView()
{		
 if (document.getElementById("labid") != null) 
	{
	document.getElementById("labid").style.display = 'none';
	}		
	 
}

function funcRadShowView()
{


 
  if (document.getElementById("radid") != null) 
     {
	 document.getElementById("radid").style.display = 'none';
	}
	if (document.getElementById("radid") != null) 
	  {
	  document.getElementById("radid").style.display = '';
	 }
	 return true;
	 return true;
}
	
function funcSerHideView()
{		
 if (document.getElementById("serid") != null) 
	{
	document.getElementById("serid").style.display = 'none';
	}			
}
function funcSerShowView()
{

 
  if (document.getElementById("serid") != null) 
     {
	 document.getElementById("serid").style.display = 'none';
	}
	if (document.getElementById("serid") != null) 
	  {
	  document.getElementById("serid").style.display = '';
	 }
	 return true;
	 return true;
}
	
function funcRadHideView()
{		
 if (document.getElementById("radid") != null) 
	{
	document.getElementById("radid").style.display = 'none';
	}			
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
function formatMoney(number, places, thousand, decimal) {
	number = number || 0;
	places = !isNaN(places = Math.abs(places)) ? places : 2;
	
	thousand = thousand || ",";
	decimal = decimal || ".";
	var negative = number < 0 ? "-" : "",
	    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
	    j = (j = i.length) > 3 ? j % 3 : 0;
	return  negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");

}


</script>
<script type="text/javascript" src="js/autocomplete_lab1.js"></script>

<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/autolabcodesearch2.js"></script>
<script type="text/javascript" src="js/autosuggestradiology1.js"></script> 
<script type="text/javascript" src="js/autoradiologycodesearch2.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
<script type="text/javascript" src="js/autoservicescodesearch2.js"></script>
<script type="text/javascript" src="js/insertnewitem22iplab.js"></script>
<!-- <script type="text/javascript" src="js/insertnewitem22iplab1_new.js"></script> -->
<script type="text/javascript" src="js/insertnewitem33iprad.js"></script>
<script type="text/javascript" src="js/insertnewitem44ipser_new.js"></script>







<script language="javascript">

// var labcode=getElementById

var totalamount=0;
var totalamount1=0;
var totalamount2=0;
var totalamount3=0;
var totalamount4=0;
var totalamount11;
var totalamount21;
var totalamount31;
var totalamount41;
var grandtotal=0;
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

function Functionfrequency()
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
var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}
function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}

function processflowitem1()
{
}
function btnDeleteClick(delID,pharmamount)
{

	var pharmamount=pharmamount;
	//alert ("Inside btnDeleteClick.");
	var newtotal4;
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry lab?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
    // var LABcode = document.getElementById('labcode'); // tbody name.

    // labcode.pop(labcode);
// alert(LABcode);
//     // var array = [1,2,3,4]
// var item = LABcode;

// var index = array.indexOf(item);
// if (index !== -1) labcode.splice(index, 1);

// console.log(labcode);

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
	
	var currentgrandtotal4=document.getElementById('total4').value;
	if(currentgrandtotal4 == '')
	{
	currentgrandtotal4=0;
	}
	
	if(document.getElementById('total1').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total3').value;
	}
	
	
	var newgrandtotal4=parseInt(newtotal4)+parseInt(totalamount11)+parseInt(totalamount21)+parseInt(totalamount31);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal4.toFixed(2);
	document.getElementById('grand_total').value=newgrandtotal4.toFixed(2);
	
	// pop_delete_labcode();

	document.getElementById("totalamount").value=newgrandtotal4.toFixed(2);
	//document.getElementById("subtotal").value=newgrandtotal4.toFixed(2);
	document.getElementById("subtotal1").value=newgrandtotal4.toFixed(2);
}
function btnDeleteClick12(delID1)
{

	var newtotal3;
//alert(delID1.substr(4));
	var varDeleteID1 = delID1;
	//alert(varDeleteID1);
	rateid= 'rate5'+delID1.substr(4)+'';
	vrate1=parseFloat(document.getElementById(rateid).value.replace(/[^0-9\.]+/g,""));
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var child1 = document.getElementById(varDeleteID1); //tr name
    var parent1 = document.getElementById('insertrow1'); // tbody name.
	document.getElementById ('insertrow1').removeChild(child1);
	var currenttotal3=document.getElementById('total1').value;
	var current=Number(currenttotal3.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal3= current-vrate1;
	//newtotal3=newtotal3	//alert(newtotal3);
	document.getElementById('total1').value=parseFloat(newtotal3).toFixed(2);
	document.getElementById('grand_total').value=parseFloat(newtotal3).toFixed(2);
	// pop_delete_labcode();

}
function btnDeleteClick1(delID1,vrate1)
{
	
	// pop_delete_labcode();
	var vrate1 = vrate1;

	var newtotal3;
	//alert(vrate1);
	var varDeleteID1 = delID1;
	//alert(varDeleteID1);
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var child1 = document.getElementById('idTR'+varDeleteID1); //tr name
    var parent1 = document.getElementById('insertrow1'); // tbody name.
	document.getElementById ('insertrow1').removeChild(child1);
	
	var child1= document.getElementById('idTRaddtxt'+varDeleteID1);  //tr name
    var parent1= document.getElementById('insertrow1'); // tbody name.
	//alert (child);
	if (child1 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow1').removeChild(child1);
	}
	
	var currenttotal3=Number(document.getElementById("total1").value.replace(/[^0-9\.]+/g,""));
	
	//alert(currenttotal);
	newtotal3= parseFloat(currenttotal3)-vrate1;
	newtotal3=newtotal3;
	//alert(newtotal3);
	
	document.getElementById('total1').value=formatMoney(newtotal3);
	
	if(document.getElementById('total2').value=='')
	{
	 totalamount2=0;
	//alert(totalamount21);
	}
	else
	{
	totalamount2=Number(document.getElementById('total2').value.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount3=0;
	//alert(totalamount31);
	}
	else
	{
	 totalamount3=Number(document.getElementById('total3').value.replace(/[^0-9\.]+/g,""));
	}
	
	newgrandtotal3=parseFloat(newtotal3)+parseFloat(totalamount2)+parseFloat(totalamount3);
	
	var availableamount_org=Number(document.getElementById("availableamount_org").value.replace(/[^0-9\.]+/g,""));
	document.getElementById('availableamount_org').value=formatMoney(parseFloat(availableamount_org)+vrate1);	 

	document.getElementById('total4').value=formatMoney(newgrandtotal3);
	document.getElementById('grand_total').value=formatMoney(newgrandtotal3);
	
	pop_delete_labcode();
	
	
}

function btnDeleteClick5(delID5,radrate)
{
	
	// pop_delete_labcode();
var radrate=radrate;
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(radrate);
	//alert(delID5);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
	//alert(child2);
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert(parent2);
	document.getElementById ('insertrow2').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child2);
	}
	
	var currenttotal2=Number(document.getElementById("total2").value.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal2= parseFloat(currenttotal2)-parseFloat(radrate);
	
	//alert(newtotal);
	
	document.getElementById('total2').value=newtotal2;

	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=Number(document.getElementById("total1").value.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=Number(document.getElementById("total3").value.replace(/[^0-9\.]+/g,""));
	}
	
	pop_delete_radcode();
	
    var newgrandtotal2=parseFloat(totalamount21)+newtotal2+parseFloat(totalamount31);
	
	//alert(newgrandtotal4);
	
	var availableamount_org=Number(document.getElementById("availableamount_org").value.replace(/[^0-9\.]+/g,""));
	document.getElementById('availableamount_org').value=formatMoney(parseFloat(availableamount_org)+parseFloat(radrate));
	
	document.getElementById('total4').value=formatMoney(newgrandtotal2);
	
	document.getElementById('grand_total').value=formatMoney(newgrandtotal2);	
	
		//document.getElementById("subtotal").value=newgrandtotal2.toFixed(2);
	document.getElementById("subtotal1").value=formatMoney(newgrandtotal2);

	document.getElementById("totalamount").value=formatMoney(newgrandtotal2);

	
}
function btnDeleteClick3(delID3,vrate3)
{
	
	// pop_delete_labcode();
var vrate3=vrate3;
	//alert ("Inside btnDeleteClick.");
	var newtotal1;
	var varDeleteID3= delID3;
	//alert (varDeleteID3);
	//alert(vrate3);
	var fRet6; 
	fRet6 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet6 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child3 = document.getElementById('idTR'+varDeleteID3);  
	//alert (child3);//tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	document.getElementById ('insertrow3').removeChild(child3);
	
	var child3= document.getElementById('idTRaddtxt'+varDeleteID3);  //tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	
	if (child3 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow3').removeChild(child3);
	}
var currenttotal1=Number(document.getElementById("total3").value.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal1= parseFloat(currenttotal1)-parseFloat(vrate3);
	
	//alert(newtotal);
	
	document.getElementById('total3').value=newtotal1;
	
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=Number(document.getElementById("total1").value.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=Number(document.getElementById("total2").value.replace(/[^0-9\.]+/g,""));
	}
	
	
	var newgrandtotal1=parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(newtotal1);
	
	//alert(newgrandtotal4);
	
	var availableamount_org=Number(document.getElementById("availableamount_org").value.replace(/[^0-9\.]+/g,""));
	document.getElementById('availableamount_org').value=formatMoney(parseFloat(availableamount_org)+parseFloat(vrate3));
	
	document.getElementById('total4').value=formatMoney(newgrandtotal1);	
	document.getElementById('grand_total').value=formatMoney(newgrandtotal1);
	document.getElementById("totalamount").value=formatMoney(newgrandtotal1);
		//document.getElementById("subtotal").value=newgrandtotal1.toFixed(2);
	document.getElementById("subtotal1").value=formatMoney(newgrandtotal1);
	// pop_delete_labcode();
}
function sertotal()
{
	var varquantityser = document.getElementById("quantityser3").value;
	var varserRates = document.getElementById("rate3").value;
	var varserBaseunit = document.getElementById("baseunit").value;
	if(varserBaseunit==""){varserBaseunit=0;}
	var varserIncrqty = document.getElementById("incrqty").value;
	if(varserIncrqty==""){varserIncrqty=0;}
	var varserIncrrate = document.getElementById("incrrate").value;
	if(varserIncrrate==""){varserIncrrate=0;}
	var varserSlab = document.getElementById("slab").value;
	//alert(varquantityser+varserBaseunit);
	//alert(document.getElementById("slab").value);
	if(varserSlab=='')
	{
		if(parseInt(varquantityser)==0)
		{document.getElementById("totalservice3").value=0}
		if(parseInt(varquantityser)>0)
		{
		document.getElementById("totalservice3").value=(parseInt(varserRates)*parseInt(varquantityser)).toFixed(2);
		}
	}
		
	if(parseInt(varserSlab)==1)
	{
		if(parseInt(varquantityser)==0)
		{document.getElementById("totalservice3").value=0}
		if(parseInt(varquantityser)>0)
		{
		if(parseInt(varquantityser) <= parseInt(varserBaseunit))
		{ 
		document.getElementById("totalservice3").value=varserRates;			
		}
		//parseInt(varquantityser)+parseInt(varserIncrqty);
		if (parseInt(varquantityser) > parseInt(varserBaseunit))
		{
			var result11 = parseInt(varquantityser) - parseInt(varserBaseunit);
			//alert(result11);
			var rem = parseInt(result11)/parseInt(varserIncrqty);
			var rem= Math.ceil(rem);
			//alert(rem);
			var resultfinal =parseInt(rem)*parseInt(varserIncrrate);//alert(resultfinal);
			document.getElementById("totalservice3").value=(parseInt(varserRates)+parseInt(resultfinal)).toFixed(2);
		}
	}
	
	}
}
function labFunction() {
var subtype = document.getElementById("subtypeano").value;
var packcharge = document.getElementById("packcharge").value;

    var myWindow = window.open("addlabtest1.php?subtype="+subtype+"&&pkg="+packcharge, "MsgWindow" ,'width='+screen.availWidth+',height='+screen.availHeight+',toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=1,resizable=1,left=0,top=0','fullscreen');
    //myWindow.document.write("<p>This is 'MsgWindow'. I am 200px wide and 100px tall!</p>");
	if (myWindow) {
       myWindow.onclose = function () { alert("close window"); }
	}
}

</script>
<script>
function validcheck()
{
	document.getElementById("Submit2223").disabled=true;
	var finaltotal=document.getElementById("total3").value;
	var finaltotal1=document.getElementById("total2").value;
	var finaltotal12=document.getElementById("total1").value;
	var fintot=finaltotal+finaltotal1+finaltotal12;

	if(fintot=="" || fintot=="0.00" || fintot=="0")
{
	alert("Please select any test");
	document.getElementById("Submit2223").disabled=false;
	return false;
}


if(parseFloat(document.getElementById("userlimit").value) < parseFloat(document.getElementById("total3").value.replace(RegExp(',', 'g'),''))){
	alert("Service Total Amount is Higher, Please Contact Management");
	document.getElementById("Submit2223").disabled=false;
	return false;
}




	
var finalize=confirm("Are you want to Save Records");
if(finalize!=true)
{
	document.getElementById("Submit2223").disabled=false;
	return false;
}

}
function cleardatas(datas)
{
if(datas=='lab')
{
//document.getElementById("serialnumber17").value='1';
document.getElementById("labcode").value='';
document.getElementById("rate5").value='';
document.getElementById("pkg").value='';
document.getElementById("labfree").value='';
}
if(datas=='rad')
{
//document.getElementById("serialnumber27").value='1';
document.getElementById("radiologycode").value='';
document.getElementById("rate8").value='';
document.getElementById("pkg1").value='';
document.getElementById("radiologyfree").value='';

}
if(datas=='serv')
{
//document.getElementById("serialnumber3").value='';
document.getElementById("servicescode").value='';
document.getElementById("rate3").value='';
document.getElementById("ledgercode").value='';
document.getElementById("ledgername").value='';
document.getElementById("baseunit").value='';
document.getElementById("incrqty").value='';
document.getElementById("incrrate").value='';
document.getElementById("slab").value='';
document.getElementById("quantityser3").value='';
document.getElementById("totalservice3").value='';
document.getElementById("servicesfree").value='';
document.getElementById("pkg2").value='';


}


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
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {
	font-size: 30px;
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
font-size: 30px;
	font-weight: bold;
	FONT-FAMILY: Tahoma
}
.cumtotal{position:fixed}
</style>

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script src="js/datetimepicker_css.js"></script>
<script>

$(document).ready(function() {
    $('#service_chkbox').change(function() {
        if(this.checked) {
			var servicesname = "Use of Implants";
			var servicescode = "SER083";
			// checkbox is checked
			$('#servicescode').val(servicescode);   
			$('#services').val(servicesname);
			$('#hiddenservices').val(servicesname);
			$('#services').prop('readonly', true);
			$('.show_chkbox_status').show();

			//funcservicessearch7(); //autocustomercodesearch2.js
			
			var baseunit = $('#baseunit').val();
			
		  	if(baseunit == 0)
		  	{
		  		$('#baseunit').val(1);
		  	}

        }
        else
        {
        	//checkbox is un checked
        	$('.show_chkbox_status').hide();
        	$('#services').prop('readonly', false);
        	var datas = 'serv';
        	cleardatas(datas);
        	$('#services').val('');
        	$('#hiddenservices').val('');
        }         
    });

    $( "#percentage" ).change(function() {
		  
		  if($( this ).val() !=undefined && $( this ).val() !="")
		  {
		  	var percentval = $( this ).val();
		  	var costprice  = parseFloat($('#costprice').val());
		  	var newprice = (costprice/100)*percentval;
		  	var finalprice = (parseFloat(costprice) + parseFloat(newprice)).toFixed(2);
		  	$('#rate3').val(finalprice);
		  	var baseunit = $('#baseunit').val();
		  	if(baseunit == 0)
		  	{
		  		$('#baseunit').val(1);
		  	}
		  	$('#quantityser3').keyup();
		  	
		  }
	});

	$("#costprice").keyup(function(){
		var percentval = $('#percentage').val();
		var costprice  = $( this ).val();
		var newprice = (costprice/100)*percentval;
		var finalprice = (parseFloat(costprice) + parseFloat(newprice)).toFixed(2);
		$('#rate3').val(finalprice);
		$('#quantityser3').keyup();
    });

});
$(function() {
$('.show_chkbox_status').hide();
//alert("ajaxautocomplete_lab.php?subtype=<?php echo $patientsubtype;?>&&loc=<?php echo $locationcode; ?>");

$('#lab').autocomplete({
source:"ajaxautocomplete_lab.php?subtype=<?php echo $patientsubtype;?>&&loc=<?php echo $locationcode; ?>",
select:function(event,ui){
$('#lab').val(ui.item.value);
$('#labcode').val(ui.item.id);
$('#hiddenlab').val(ui.item.value);
funclabsearch5();
}
});
$('#radiology').autocomplete({
source:"ajaxautocomplete_radiology.php?subtype=<?php echo $patientsubtype;?>&&loc=<?php echo $locationcode; ?>",
select:function(event,ui){
$('#radiology').val(ui.item.value);
customernamelostfocus3();
}
});
$('#services').autocomplete({
source:"ajaxautocomplete_services.php?subtype=<?php echo $patientsubtype;?>&&loc=<?php echo $locationcode; ?>",
select:function(event,ui){
$('#services').val(ui.item.value);
customernamelostfocus2();
}
});
$('#serdoct').autocomplete({
source:"ajaxdoc.php",
select:function(event,ui){
$('#serdoct').val(ui.item.value);
$('#serdoctcode').val(ui.item.id);
}
});
});

$( function() {
	var admissiondt  = new Date(document.getElementById('admissiondate').value);
	if(document.getElementById('test_backdate').value==1){
    $( "#billdate" ).datepicker({
	 dateFormat: 'yy-mm-dd',
	 minDate: admissiondt,
	 maxDate: new Date() 
      

	});
	}
  } );
</script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="iptests.php" onSubmit="return validcheck()" >
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
                <td colspan="7" bgcolor="#ecf0f5" class="bodytext32"><strong>Patient Details</strong></td>
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
				<?php  include ('ipcreditaccountreport3_ipcredit.php'); ?>
				<tr>
                <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientname; ?>
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" style="border: 1px solid #001E6A;" size="45">
               <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">

                </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<strong>Patientcode</strong></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?></td>

				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >
				<strong>Visit Limit</strong></td>
                <td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >
				<input type="text" id="visitlimit" size="6" value="<?php echo number_format($visitlimit,2,'.',',');?>" readonly="readonly"></td>
				
				</tr>       
               
			   <tr>
			    <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visitcode</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />	<?php echo $visitcode; ?></td>			
			   	  <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="hidden" name="account" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />		
				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
				<input type="hidden" name="payment" id="payment" value="<?php echo $patienttype1; ?>">
				<input type="hidden" name="subtype" id="subtype"  value="<?php echo $res131subtype; ?>" >                  
                <input type="hidden" name="subtypeano" id="subtypeano"  value="<?php echo $patientsubtype; ?>" >                  
			<?php echo $patientaccount1; ?>	</td>	
			<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >
				<strong>Interm Amount</strong></td>
                <td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >
				<input type="text" size="6"  id="usedamount" value="<?php echo number_format($overalltotal,2,'.',','); ?>" readonly="readonly"></td>
			
			</tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong> Date</strong></td>
				<td class="bodytext3">
				<input name="billdate" id="billdate" value="<?php echo $dateonly; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" style="background-color:#ecf0f5;"/>
				<input type="hidden" name="admissiondate" id="admissiondate" value="<?php echo $admissiondate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="test_backdate" id="test_backdate" value="<?php echo $res_test_backdate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />
				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
				<td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	<?php echo $billnumbercode; ?></td>
				
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >
				<strong>Available Amount</strong></td>
                <td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >
				<input type="hidden" size="6" id="availableamount" value="<?php echo number_format($visitlimit-$overalltotal,2,'.',','); ?>" readonly="readonly">
				<input type="text" size="6" id="availableamount_org" value="<?php echo number_format($visitlimit-$overalltotal,2,'.',','); ?>" readonly="readonly"></td>
				  </tr>
                  <tr>
                    <td align="left" valign="middle" class="bodytext3"><strong>Location</strong></td>
				<td class="bodytext3"><input type="hidden" name="location" id="location" value="<?php echo $locationcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<?php echo $searchlocationname; ?></td>
				<td align="left" valign="middle" class="bodytext3"><strong>Package</strong></td>
				<td class="bodytext3"><input type="hidden" name="packcharge" id="packcharge" value="<?php echo $packcharge; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<?php if($packcharge == 1) { echo 'Yes'; } else { echo 'No'; } ?></td>
				
				
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >
				<strong>Grand Total</strong></td>
                <td align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >
				<input type="text" size="6"  id="grand_total" value="0" readonly="readonly" style="border: 1px solid red;"></td>
				
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
          
			           
				   
				   <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#cccccc" class="bodytext3"><span class="bodytext32"><strong>Lab <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcLabHideView()"  onClick="return funcLabShowView()"> </strong></span></td>
			      </tr>
				  
				  <tr id="labid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				     <table width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Laboratory Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">Pkg</td>
					   <td width="30" class="bodytext3"><button type="button" id="addlabtesta" onClick="labFunction()"><img src="images/addbutton.png" /></button></td>
                     </tr>
					  <tr>
					 <div id="insertrow1">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber1" id="serialnumber17" value="1">
					  <input type="hidden" name="labcode[]" id="labcode" value="">
					  <input type="hidden" name="hiddenlab" id="hiddenlab" value="">
				      <td width="30"><input name="lab[]" id="lab" type="text" size="69" onChange="return cleardatas('lab')" autocomplete="off" ></td>
				      <td width="30"><input name="rate5[]" type="text" id="rate5" readonly size="8"></td>
                      <input type="hidden" name="pkg" id="pkg">
					  <td><select name="labfree[]" id="labfree">
					  <option value="">Select</option>
					  <!--<option value="0">No</option>
					  <option value="1">Yes</option>-->
					  </select>
					  </td>
					  <td><label>
                       <input type="button" name="Add1" id="Add1" value="Add" onClick="return insertitem2()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   <?php
					   $endDate =date('Y-m-d');
					   $startDate = date('Y-m-d',strtotime ("-1 days")) ;
					   $sqlLab = "select a.labitemname as labitemname,a.consultationdate as consultationdate,a.consultationtime as consultationtime,b.employeename as employeename from ipconsultation_lab as a join master_employee as b on a.username=b.username where a.patientcode='".$patientcode."' and a.patientvisitcode='".$visitcode."' and a.consultationdate between '$startDate' and '$endDate' ";
					   $resLab=mysqli_query($GLOBALS["___mysqli_ston"], $sqlLab);
					   $numLab = mysqli_num_rows($resLab);
					   if($numLab>0){ ?>
					   <tr>
					   <td colspan='4' align='left'><strong>Previous Test Details</strong></td>
					   </tr>
					   <tr>
					   <td colspan='4'>
					    <table  cellspacing="0" cellpadding="2" width='100%' class='bodytext3' border='1' style="border: 1px solid red">
					   <?php
						   while($rsltLab = mysqli_fetch_array($resLab))
		                  {
					   ?>
						   <tr>
							 <td  style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><?php echo $rsltLab['labitemname'];?></td>
							 <td  style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><?php echo $rsltLab['consultationdate'].' '.$rsltLab['consultationtime'];?></td>
							 <td  style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><?php echo $rsltLab['employeename'];?></td>
						   </tr>
                       <?php }  ?>
                         </table>	  </td> 
				         </tr>
					   <?php
					   }
					   ?>
					   </tr>
					    </table>	  </td> 
				  </tr>
				  <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" id="total1" readonly size="7" ></td>
				  </tr> 
		         <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#cccccc" class="bodytext3"><span class="bodytext32"><strong>Radiology <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcRadHideView()"  onClick="return funcRadShowView()"> </strong></span></td>
		        </tr>
				<tr id="radid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Radiology Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">Pkg</td>
                     </tr>
					  <tr>
					 <div id="insertrow2">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber2" id="serialnumber27" value="1">
					  <input type="hidden" name="radiologycode[]" id="radiologycode" value="">
					  <input type="hidden" name="hiddenradiology" id="hiddenradiology" value="">
				   <td width="30"> <input name="radiology[]" id="radiology" type="text" onChange="return cleardatas('rad')" size="69" autocomplete="off"></td>
				      <td width="30"><input name="rate8[]" type="text" id="rate8" readonly size="8"></td>
                      <input type="hidden" name="pkg1" id="pkg1">
					   <td><select name="radiologyfree[]" id="radiologyfree">
					   <option value="">Select</option>
					 <!-- <option value="0">No</option>
					  <option value="1">Yes</option>-->
					  </select>
					  </td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem3()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					   <?php
					   $endDate =date('Y-m-d');
					   $startDate = date('Y-m-d',strtotime ("-1 days")) ;
					   $sqlLab = "select a.radiologyitemname as labitemname,a.consultationdate as consultationdate,a.consultationtime as consultationtime,b.employeename as employeename from ipconsultation_radiology as a join master_employee as b on a.username=b.username where a.patientcode='".$patientcode."' and a.patientvisitcode='".$visitcode."' and a.consultationdate between '$startDate' and '$endDate' ";
					   $resLab=mysqli_query($GLOBALS["___mysqli_ston"], $sqlLab);
					   $numLab = mysqli_num_rows($resLab);
					   if($numLab>0){ ?>
					   <tr>
					   <td colspan='4' align='left'><strong>Previous Test Details</strong></td>
					   </tr>
					   <tr>
					   <td colspan='4'>
					    <table  cellspacing="0" cellpadding="2" width='100%' class='bodytext3' border='1' style="border: 1px solid red">
					   <?php
						   while($rsltLab = mysqli_fetch_array($resLab))
		                  {
					   ?>
						   <tr>
							 <td  style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><?php echo $rsltLab['labitemname'];?></td>
							 <td  style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><?php echo $rsltLab['consultationdate'].' '.$rsltLab['consultationtime'];?></td>
							 <td  style="background-color: rgb(255, 255, 255); border: 0px solid rgb(0, 30, 106);"><?php echo $rsltLab['employeename'];?></td>
						   </tr>
                       <?php }  ?>
                         </table>	  </td> 
				         </tr>
					   <?php
					   }
					   ?>
					    </table>						</td>
		        </tr>
				
				 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" id="total2" readonly size="7"></td>
				   </tr>
		        <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#cccccc" class="bodytext3"><span class="bodytext32"><strong>Services <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcSerHideView()" onClick="return funcSerShowView()"> </strong></span></td>
		        </tr>
				<tr id="serid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                     	<td class="bodytext3"></td>
                       <td width="30" class="bodytext3">Services</td>
                        <td width="30" class="bodytext3 show_chkbox_status">Cost Price</td>
                        <td width="30" class="bodytext3 show_chkbox_status">%</td>
					   <td class="bodytext3">Doctor Name</td>
                       <td class="bodytext3">Base Rate</td>
                       <td class="bodytext3">Base Unit</td>
                       <td class="bodytext3">Incr Qty</td>
                       <td class="bodytext3">Incr Rate</td>
                        <td width="30" class="bodytext3">Qty</td>
                       <td width="30" class="bodytext3">Amount</td>
                     </tr>
					  <tr>
					 <div id="insertrow3">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber3" id="serialnumber3" value="1">
					  <input type="hidden" name="servicescode[]" id="servicescode" >
					  <input type="hidden" name="hiddenservices" id="hiddenservices" value="">
					  <td width="30"><input type="checkbox" name="service_chk" id="service_chkbox"></td>
				   <td width="30"><input name="services[]" type="text" id="services" onChange="return cleardatas('serv')" size="40"></td>
				   <td width="30" class="show_chkbox_status"><input name="costprice" type="text" id="costprice" onKeyUp="return changePrices()"></td>
				   <td class="show_chkbox_status"><select name="percentage" id="percentage">
                    
					 <option value="">Select</option>
					<option value="5">5</option>
					  <option value="10">10</option>
					  <option value="20">20</option>
					  
					  </select>
					  </td>
				   <td width="30"><input name="serdoct[]" type="text" id="serdoct" size="30">
				   <input name="serdoctcode[]" type="hidden" id="serdoctcode" size="30">
				   </td>
				    <td width="30"><input name="rate3[]" type="text" id="rate3" readonly size="8"></td>
                    <input type="hidden" name="ledgercode[]" id="ledgercode" value="">
                        <input type="hidden" name="ledgername[]" id="ledgername" value="">
                    
                    <td width="30"><input name="baseunit[]" type="text" id="baseunit" readonly size="8"></td>
                    <td width="30"><input name="incrqty[]" type="text" id="incrqty" readonly size="8"></td>
                    <td width="30"><input name="incrrate[]" type="text" id="incrrate" readonly size="8">
                    <input name="slab[]" type="hidden" id="slab" readonly size="8">
                    </td>
				   <td width="30"><input name="quantityser3[]" type="text" id="quantityser3" onKeyUp="return sertotal()" size="8"></td>
					<td width="30"><input name="totalservice3[]" type="text" id="totalservice3" readonly size="8"></td>
                      <input type="hidden" name="pkg2" id="pkg2">
					 <td style="display:none"><select name="servicesfree[]" id="servicesfree">
                    
					<!-- <option value="">Select</option>-->
					<option value="0">No</option>
					  <!--<option value="1">Yes</option>-->
					  </select>
					  </td>
					   <td><label>
                       <input type="button" name="Add3" id="Add3" value="Add" onClick="return insertitem4()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table></td>
		       </tr>
			   <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" id="total3" readonly size="7"></td>
				 <input type="hidden" id="total4" readonly size="7">
				   </tr>
				            
          </tbody>
        </table>		
		</td></tr>
		
		
		<tr>
		<td>&nbsp;
		</td>
		</tr>
             
               <tr>
	  <td colspan="7" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
	   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
	   <input name="userlimit" id="userlimit" type="hidden" size="10" value="<?php echo $ser_rolelimit; ?>">
	    <input name="Submit2223" type="submit" id="Submit2223" value="Save" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
		</td>
	  </tr>
              
            </tbody>
        </table>
		</td>
		</tr>
     
    </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>