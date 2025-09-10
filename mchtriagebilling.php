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
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{

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

		
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$patientname = $_REQUEST['customername'];
		$accountname = $_REQUEST['accountname'];
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender'];
		$billingtype=$_REQUEST['billtype'];
			if($billingtype =='PAY NOW')
	{
	$status='pending';
	}
	else
	{
	$status='completed';
	}


				$query34 = "select * from master_company where companystatus = 'Active'";
		$exec34= mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res34 = mysqli_fetch_array($exec34);
		$pharefnoprefix = $res34['pharefnoprefix'];
		$pharefnoprefix1=strlen($pharefnoprefix);
		$query24 = "select * from master_consultationpharm order by auto_number desc limit 0, 1";
	    $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res24 = mysqli_fetch_array($exec24);
		$pharefnonumber = $res24["refno"];
		$billdigit4=strlen($pharefnonumber);
		if ($pharefnonumber == '')
		{
		$pharefcode =$pharefnoprefix.'1';
		$openingbalance = '0.00';
		}
		else
		{
		$pharefnonumber = $res24["refno"];
		$pharefcode = substr($pharefnonumber,$pharefnoprefix1, $billdigit4);
		$pharefcode = intval($pharefcode);
		$pharefcode = $pharefcode + 1;
		$maxanum = $pharefcode;
		$pharefcode = $pharefnoprefix.$maxanum;
		$openingbalance = '0.00';
		//echo $companycode;
		}	
         for ($p=1;$p<=20;$p++)
		  {	
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_REQUEST['medicinename'.$p];
			$medicinename = addslashes($medicinename);
			$query77="select * from master_medicine where itemname='$medicinename' and status <> 'deleted'";
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
			$instructions = $_REQUEST['instructions'.$p];
			$rate = $_REQUEST['rates'.$p];
			$amount = $_REQUEST['amount'.$p];
				//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
				if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
				{
					//echo '<br>'. 
					$query2 = "insert into master_consultationpharm(patientcode,patientname,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,store,location,billtype,accountname) 
					values('$patientcode','$patientname','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','$status','$medicinecode','$pharefcode','$status','pending','$store','$location','$billingtype','$accountname')";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$query29 = "insert into master_consultationpharmissue(patientcode,patientname,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,paymentstatus,medicinecode,refno,prescribed_quantity,store,location,billtype,accountname) 
					values('$patientcode','$patientname','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','$status','$medicinecode','$pharefcode','$quantity','$store','$location','$billingtype','$accountname')";
					$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
									
						
				}
		
		 }
		$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$labrefnoprefix = $res3['labrefnoprefix'];
$labrefnoprefix1=strlen($labrefnoprefix);
$query2 = "select * from consultation_lab order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$labrefnonumber = $res2["refno"];
$billdigit=strlen($labrefnonumber);
if ($labrefnonumber == '')
{
	$labrefcode =$labrefnoprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$labrefnonumber = $res2["refno"];
	$labrefcode = substr($labrefnonumber,$labrefnoprefix1, $billdigit);
	$labrefcode = intval($labrefcode);
	$labrefcode = $labrefcode + 1;
$maxanum = $labrefcode;
	$labrefcode = $labrefnoprefix.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

			foreach($_POST['categorylab'] as $key=>$value)
	{
	
	$categorylabname=$_POST['categorylab'][$key];
	$categorylabname;
	
	$categorylabrate=$_POST['categoryrate5'][$key];
	if($categorylabname != "")
	{
	$categorylabquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_lab(patientcode,patientname,patientvisitcode,labitemname,labitemrate,consultationdate,paymentstatus,labsamplecoll,resultentry,labrefund,refno)values('walkin','$patientfullname','walkinvis','$categorylabname','$categorylabrate','$currentdate','paid','pending','pending','norefund','$labrefcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}	
	}
	
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labname = addslashes($labname);
		$labquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_lab where itemname='$labname' and status <> 'deleted'");
		$execlab=mysqli_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		$labfree=$_POST['labfree'][$key];
		if($labfree=='Yes'){$mchstatus = 'completed'; }else{$mchstatus = $status;}
		if(($labname!="")&&($labrate!=''))
			{
			$query63 = "select * from consultation_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and labitemcode ='$labcode' and refno='$labrefcode'";
		$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num63 = mysqli_num_rows($exec63);
		if($num63 == 0)
		{
			$labquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_lab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,consultationdate,paymentstatus,labsamplecoll,resultentry,labrefund,refno,billtype,accountname,username,freestatus)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$currentdate','$mchstatus','pending','pending','norefund','$labrefcode','$billingtype','$accountname','$username','$labfree')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			}
		}
		
		$query31 = "select * from master_company where companystatus = 'Active'";
		$exec31= mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res31 = mysqli_fetch_array($exec31);
		$radrefnoprefix = $res31['radrefnoprefix'];
		$radrefnoprefix1=strlen($radrefnoprefix);
		$query21 = "select * from consultation_radiology order by auto_number desc limit 0, 1";
	    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res21 = mysqli_fetch_array($exec21);
		$radrefnonumber = $res21["refno"];
		$billdigit1=strlen($radrefnonumber);
		if ($radrefnonumber == '')
		{
		$radrefcode =$radrefnoprefix.'1';
		$openingbalance = '0.00';
		}
		else
		{
		$radrefnonumber = $res21["refno"];
		$radrefcode = substr($radrefnonumber,$radrefnoprefix1, $billdigit1);
		$radrefcode = intval($radrefcode);
		$radrefcode = $radrefcode + 1;
		$maxanum = $radrefcode;
		$radrefcode = $radrefnoprefix.$maxanum;
		$openingbalance = '0.00';
		//echo $companycode;
		}
		
		$rad= $_POST['radiology'];
		$rat=$_POST['rate8'];
		$items = array_combine($rad,$rat);
		$pairs = array();
		
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		 $pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		
		$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$pairvar' and status <> 'deleted'");
		$execradiology=mysqli_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		
		if(($pairvar!="")&&($pairvar1!=""))
		{
		$query61 = "select * from consultation_radiology where patientcode='$patientcode' and patientvisitcode='$visitcode' and radiologyitemname = '$pairvar' and refno='$radrefcode'";
		$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num61 = mysqli_num_rows($exec61);
		if($num61 == 0)
		{
		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_radiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,refno,resultentry,username)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairvar','$pairvar1','$billingtype','$accountname','$currentdate','$status','$radrefcode','pending','$username')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
		}
		
		
			$query32 = "select * from master_company where companystatus = 'Active'";
		$exec32= mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res32 = mysqli_fetch_array($exec32);
		$serrefnoprefix = $res32['serrefnoprefix'];
		$serrefnoprefix1=strlen($serrefnoprefix);
		$query22 = "select * from consultation_services order by auto_number desc limit 0, 1";
	    $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res22 = mysqli_fetch_array($exec22);
		$serrefnonumber = $res22["refno"];
		$billdigit2=strlen($serrefnonumber);
		if ($serrefnonumber == '')
		{
		$serrefcode =$serrefnoprefix.'1';
		$openingbalance = '0.00';
		}
		else
		{
		$serrefnonumber = $res22["refno"];
		$serrefcode = substr($serrefnonumber,$serrefnoprefix1, $billdigit2);
		$serrefcode = intval($serrefcode);
		$serrefcode = $serrefcode + 1;
		$maxanum = $serrefcode;
		$serrefcode = $serrefnoprefix.$maxanum;
		$openingbalance = '0.00';
		//echo $companycode;
		}		
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicequery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_services where itemname='$servicesname' and status <> 'deleted'");
		$execservice=mysqli_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		
		if(($servicesname!="")&&($servicesrate!=''))
		{
		
		$servicesquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into consultation_services(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,consultationdate,paymentstatus,process,refno,billtype,accountname,username)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$currentdate','$status','pending','$serrefcode','$billingtype','$accountname','$username')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		$newquery1=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set triageconsultation='completed' where visitcode='$visitcode'");
		
		
		$query93=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set overallpayment='' where visitcode='$visitcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
			
	   header("location:triagelist1.php");
       exit;
    
       }

if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}


?>

<?php
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];


?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];
$res111subtype = $execlab1['subtype'];	
$billtype = $execlab1['billtype'];

$query131 = "select * from master_subtype where auto_number = '$res111subtype'";
$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
$res131 = mysqli_fetch_array($exec131);
$res131subtype = $res131['subtype'];

$res111paymenttype = $execlab1['paymenttype'];
$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";
$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
$res121 = mysqli_fetch_array($exec121);
$res121paymenttype = $res121['paymenttype'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

$query765 = "select * from master_consultation where patientvisitcode='$visitcode'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num765 = mysqli_num_rows($exec765);

?>

<?php

include("autocompletebuild_medicine1.php");
include ("autocompletebuild_lab1.php");
include ("autocompletebuild_radiology1.php");
include ("autocompletebuild_services1.php");

?>
<script language="javascript">


function funcOnLoadBodyFunctionCall()
{


	
	funcCustomerDropDownSearch4(); 
	funcCustomerDropDownSearch3();
	funcCustomerDropDownSearch1();
	funcCustomerDropDownSearch2();
		
		funcOnLoadBodyFunctionCall1();
	
}
function funcOnLoadBodyFunctionCall1()
{
    
	funcpresHideView();
	funcLabHideView();
	funcRadHideView();
	funcSerHideView();
	
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
	 
}

function funcpresShowView()
{


  if (document.getElementById("pressid") != null) 
     {
	 document.getElementById("pressid").style.display = 'none';
	}
	if (document.getElementById("pressid") != null) 
	  {
	  document.getElementById("pressid").style.display = '';
	 }
	 return true;
	 
}
function funcpresHideView()
{	
	
 if (document.getElementById("pressid") != null) 
	{
	document.getElementById("pressid").style.display = 'none';
	}	
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
	 
}
	
function funcLabHideView()
{		
 if (document.getElementById("labid") != null) 
	{
	document.getElementById("labid").style.display = 'none';
	}		
	 
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
	
}
	
function funcRadHideView()
{		
 if (document.getElementById("radid") != null) 
	{
	document.getElementById("radid").style.display = 'none';
	}			
}


//Print() is at bottom of this page.

</script>



<?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch2.js"></script>


<?php include ("js/dropdownlist1scriptinglab1.php"); ?>
<script type="text/javascript" src="js/autocomplete_lab1.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/autolabcodesearch2.js"></script>


<?php include ("js/dropdownlist1scriptingradiology1.php"); ?>
<script type="text/javascript" src="js/autocomplete_radiology1.js"></script>
<script type="text/javascript" src="js/autosuggestradiology1.js"></script> 
<script type="text/javascript" src="js/autoradiologycodesearch2.js"></script>

<?php include ("js/dropdownlist1scriptingservices1.php"); ?>
<script type="text/javascript" src="js/autocomplete_services1.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
<script type="text/javascript" src="js/autoservicescodesearch2.js"></script>


<script type="text/javascript" src="js/insertnewitemtriage1.js"></script>
<script type="text/javascript" src="js/insertnewitemtriage2.js"></script>
<script type="text/javascript" src="js/insertnewitemmchlab.js"></script>
<script type="text/javascript" src="js/insertnewitemtriage3.js"></script>
<script type="text/javascript" src="js/insertnewitemtriage4.js"></script>
<script language="javascript">
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
var formula = document.getElementById("formula").value;
formula = formula.replace(/\s/g, '');
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
	
	
	document.getElementById("totalamount").value=newgrandtotal4.toFixed(2);
	document.getElementById("subtotal").value=newgrandtotal4.toFixed(2);
	document.getElementById("subtotal1").value=newgrandtotal4.toFixed(2);
}
function btnDeleteClick1(delID1,vrate1)
{
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
	
	var currenttotal3=document.getElementById('total1').value;
	//alert(currenttotal);
	newtotal3= currenttotal3-vrate1;
	newtotal3=newtotal3.toFixed(2);
	//alert(newtotal3);
	
	document.getElementById('total1').value=newtotal3;
	if(document.getElementById('total').value=='')
	{
	 totalamount11=0;
	//alert(totalamount11);
	}
	else
	{
	totalamount11=document.getElementById('total').value;
	}
	if(document.getElementById('total2').value=='')
	{
	 totalamount21=0;
	//alert(totalamount21);
	}
	else
	{
	totalamount2=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount31=0;
	//alert(totalamount31);
	}
	else
	{
	 totalamount31=document.getElementById('total3').value;
	}
	
		 newgrandtotal3=parseInt(totalamount11)+parseInt(newtotal3)+parseInt(totalamount21)+parseInt(totalamount31);
	//alert(newgrandtotal3);
	document.getElementById('total4').value=newgrandtotal3.toFixed(2);
	
	
	document.getElementById("totalamount").value=newgrandtotal3.toFixed(2);

	document.getElementById("subtotal").value=newgrandtotal3.toFixed(2);
	document.getElementById("subtotal1").value=newgrandtotal3.toFixed(2);

}

function btnDeleteClick5(delID5,radrate)
{
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
	
	var currenttotal2=document.getElementById('total2').value;
	//alert(currenttotal);
	newtotal2= currenttotal2-radrate;
	
	//alert(newtotal);
	
	document.getElementById('total2').value=newtotal2;
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total').value;
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total3').value;
	}
	
	
	
    var newgrandtotal2=parseInt(totalamount11)+parseInt(totalamount21)+parseInt(newtotal2)+parseInt(totalamount31);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal2.toFixed(2);
	
	
	
		document.getElementById("subtotal").value=newgrandtotal2.toFixed(2);
	document.getElementById("subtotal1").value=newgrandtotal2.toFixed(2);

	document.getElementById("totalamount").value=newgrandtotal2.toFixed(2);

	
}
function btnDeleteClick3(delID3,vrate3)
{
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
var currenttotal1=document.getElementById('total3').value;
	//alert(currenttotal);
	newtotal1= currenttotal1-vrate3;
	
	//alert(newtotal);
	
	document.getElementById('total3').value=newtotal1;
	if(document.getElementById('total').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total').value;
	}
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total2').value;
	}
	
	
	var newgrandtotal1=parseInt(totalamount11)+parseInt(totalamount21)+parseInt(totalamount31)+parseInt(newtotal1);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal1.toFixed(2);	
	document.getElementById("totalamount").value=newgrandtotal1.toFixed(2);
		document.getElementById("subtotal").value=newgrandtotal1.toFixed(2);
	document.getElementById("subtotal1").value=newgrandtotal1.toFixed(2);

}


function processcheck()
{
var consult = document.getElementById("consultation").value;
if(consult > 0)
{
alert("Patient is Already Consulted By Doctor . Please Use Review List to Add More Requests");
return false;
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
</style>

<script src="js/datetimepicker_css.js"></script>
</head>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="mchtriagebilling.php" onKeyDown="return disableEnterKey(event)" onSubmit="return processcheck()">
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
			
				<tr>
                <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td width="33%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientname; ?>
				<input type="hidden" name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18">
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" style="border: 1px solid #001E6A;" size="45"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<strong>Reg No</strong></td>
                <td width="34%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientcode; ?>
                  <input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18"></td>
				</tr>       
               <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong>Visit Code</strong></td>
				<td class="bodytext3"><?php echo $visitcode; ?><input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Account</strong></td>
				<td class="bodytext3"><?php echo $patientaccount1; ?><input type="hidden" name="accountname" id="accountname" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>								</td>
				  </tr>
			   <tr>
			    <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Age </strong></td>
                <td align="left" valign="top" class="bodytext3"><?php echo $patientage; ?>
				 <input type="hidden" name="paymenttype" id="payment" value="<?php echo $res121paymenttype; ?>" readonly   size="20" />
				<input type="hidden" name="age" id="age" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A" size="18" />	</td>			
			   	  <td width="16%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Gender</strong></td>
                <td align="left" valign="top" class="bodytext3"><?php echo $patientgender; ?>
				<input type="hidden" name="gender" id="gender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />		
				 <input type="hidden" name="subtype" id="subtype"  value="<?php echo $res131subtype; ?>" >   
				 <input type="hidden" name="billtype" id="billtype" value="<?php echo $billtype; ?>"> 
				 <input type="hidden" name="billtype" id="billtypes" value="<?php echo $billtype; ?>">
				  <input type="hidden" name="consultation" id="consultation" value="<?php echo $num765; ?>"></td>	
 </tr>
				  
                  		<tr>
		
		<?php if($num765 > '0') {?>
        <td bgcolor="#FA5858" class="bodytext311" align="left" colspan="3">Patient is Already Consulted By Doctor, Please Use Review List to Requests More</td>
		<?php }else {?>
		<td>&nbsp;</td>
		<?php } ?>
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
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Prescription</strong> <span class="bodytext32"> <img src="images/plus1.gif" width="13" height="13"   onDblClick="return funcpresHideView()" onClick="return funcpresShowView()"> </span></td>
			      </tr>
				 <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="200" class="bodytext3">Medicine Name</td>
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
					   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			           <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
			
                       <td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off">					   </td>
                       <td><input name="dose" type="text" id="dose" size="8" onKeyUp="return Functionfrequency()"></td>
                       <td>
					   <select name="frequency" id="frequency" onChange="return Functionfrequency()">
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
				$res5num = $res5["auto_number"];
				$res5code = $res5["frequencycode"];
				?>
                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
               </select>				</td>	
                       <td><input name="days" type="text" id="days" size="8" onKeyUp="return Functionfrequency()" onFocus="return frequencyitem()"></td>
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
					    <option value="Intranasal">Intranasal </option>
						<option value="Intraauditory">Intraauditory </option>
						 <option value="Eye">Eye</option>
					   </select></td>
                       <td><input name="instructions" type="text" id="instructions" onKeyUp="return shortcodes();" size="20"></td>
                       <td width="48"><input name="rates" type="text" id="rates" readonly size="8"></td>
                       <td>
                         <input name="amount" type="text" id="amount" readonly size="8"></td>
						  <td>
						  <input name="exclude" type="hidden" id="exclude" readonly size="8">
                         <input name="formula" type="hidden" id="formula" readonly size="8"></td>
						 <td>
                         <input name="strength" type="hidden" id="strength" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem()" class="button" >
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
				 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><span class="bodytext32">
				     <input name="text" type="text" id="total" size="7" readonly>
				   </span></td>
				 </tr>
				   <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Lab <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcLabHideView()"  onClick="return funcLabShowView()"> </strong></span></td>
			      </tr>
				  
				  <tr id="labid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				     <table width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Laboratory Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">Free</td>
                     </tr>
					  <tr>
					 <div id="insertrow1">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber1" id="serialnumber17" value="1">
					  <input type="hidden" name="labcode" id="labcode" value="">
				      <td width="30"><input name="lab[]" id="lab" type="text" size="69" autocomplete="off" ></td>
				      <td width="30"><input name="rate5[]" type="text" id="rate5" readonly size="8"></td>
					  <td><select name="labfree[]" id="labfree">
					  <option value="">Select</option>
					  <option value="0">No</option>
					  <option value="1">Yes</option>
					  </select>
					  </td>
					  <td><label>
                       <input type="button" name="Add1" id="Add1" value="Add" onClick="return insertitem20()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table>	  </td> 
				  </tr>
				  <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" id="total1" readonly size="7"></td>
				  </tr> 
		         <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><span class="bodytext32"><strong>Radiology <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcRadHideView()"  onClick="return funcRadShowView()"> </strong></span></span></td>
		        </tr>
				<tr id="radid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Radiology Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow2">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber2" id="serialnumber27" value="1">
					  <input type="hidden" name="radiologycode" id="radiologycode" value="">
				   <td width="30"><input name="radiology[]" id="radiology" type="text" size="69" autocomplete="off"></td>
				      <td width="30"><input name="rate8[]" type="text" id="rate8" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem3()" class="button">
                       </label></td>
				      </tr>
					    </table>						</td>
		        </tr>
				<tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" id="total2" readonly size="7"></td>
				   </tr>

		        <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Services <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcSerHideView()" onClick="return funcSerShowView()"> </strong></span></td>
		        </tr>
				<tr id="serid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Services</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow3">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber3" id="serialnumber3" value="1">
					  <input type="hidden" name="servicescode" id="servicescode" value="">
				   <td width="30"><input name="services[]" type="text" id="services" size="69"></td>
				    <td width="30"><input name="rate3[]" type="text" id="rate3" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add3" id="Add3" value="Add" onClick="return insertitem4()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table></td>
		       </tr>
			   <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" id="total3" readonly size="7"></td>
				
				   </tr>
				            
          </tbody>
        </table>		</td>
		</tr>
		<tr>
		 <td colspan="7" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
	
	<tr>
		 <td colspan="7" class="bodytext31" valign="center"  align="right" ><input name="Submit222" type="submit"  value="Save(Alt+S)" accesskey="s" class="button"/>
		  <input type="hidden" name="frm1submit1" value="frm1submit1" /></td>
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