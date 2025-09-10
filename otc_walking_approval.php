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
$docno = $_SESSION['docno'];
/// Hardcoded for quick fix
$accountname='603';
$accname_full='Cash Patient';
$paymenttype=1;
$maintype=1;
$subtype=1;	
$departmentname ='WALK IN';
$department ='24';
$consultingdoctor_name='GENERAL PRACTITIONER';
$consultingdoctorcode='03-2000-170';
$consultationtype='4954';
$scheme_id='SHM-3585';
$billingtype = 'PAY NOW';
$planname = '3585';
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname limit 0,1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];
}
						
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
        $paynowbillprefix = 'EB-';
        $paynowbillprefix1=strlen($paynowbillprefix);
        $query2 = "select consultation_id from master_consultationpharm where consultation_id like 'EB-%' order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$billnumber = $res2["consultation_id"];
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
			$billnumbercode ='EB-'.'1'."-".date('y');
			$openingbalance = '0.00';
		}
		else
		{
			$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
			$billnumbercode = intval($billnumbercode);
			$billnumbercode = $billnumbercode + 1;
			$maxanum = $billnumbercode;
			$billnumbercode = 'EB-' .$maxanum."-".date('y');
			$openingbalance = '0.00';
		}
		//get locationcode and locationname here for insert
		$locationcodeget=$_REQUEST['locationcodeget'];
		$locationnameget=$_REQUEST['locationnameget'];
		//get locationcode ends here
		$billnumber=$billnumbercode;
		$consultationid=$billnumber;
		$billdate=$_REQUEST['billdate'];
		$patientfirstname = $_REQUEST["customername"];
		$patientfirstname = strtoupper($patientfirstname);
		$patientmiddlename = $_REQUEST['customermiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $_REQUEST["customerlastname"];
		$patientlastname = strtoupper($patientlastname);
		$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender']; 
		$visitcode=$_REQUEST['visitcode'];
		$dateofbirth=$_REQUEST['dateofbirth'];
		$timestamp=date('H:i:s');
		$totalamount=$_REQUEST['total'];
		$consultingdoctor=$username;
		$store=$_REQUEST['store'];
		$mobilenumber  = $_REQUEST["mobilenumber"];
		$ageduration  = $_REQUEST["duration"];
		$customercode  = $_REQUEST["customercode"];
		$searchpaymentcode  = $_REQUEST["searchpaymentcode"];    
	    $status='pending';
	    $approvalstatus = '';
        patientcreate:
		
		if($searchpaymentcode=='1'){
		 $query3 = "select * from master_location as ml LEFT JOIN login_locationdetails as ll ON ml.locationcode=ll.locationcode where ll.docno = '".$docno."' order by ml.locationname";
		 $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res3 = mysqli_fetch_array($exec3);
		 $patientcodeprefix = $res3['prefix'];
		 $suffix =  date('y');
		 $patientcodeprefix1=strlen($patientcodeprefix);
		 $query2 = "select * from master_customer order by auto_number desc limit 0, 1"; 
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		 $res2customercode = $res2["customercode"];
		if ($res2customercode == '')
		{
			$customercode = $patientcodeprefix.'-'.'1'.'-'.$suffix;
			$openingbalance = '0.00';
		}
		else
		{
			$res2customercode = $res2["customercode"];
			$customercode11 = explode("-",$res2customercode);
			$customercode=$customercode11[1];
			$customercode = $customercode + 1;
			$maxanum = $customercode;
			
			$maxanum;
			$customercode = $patientcodeprefix.'-'.$maxanum.'-'.$suffix;
			$openingbalance = '0.00';
		}
		$query1 = "insert into master_customer (customercode,customername,customermiddlename,customerlastname,customerfullname,gender,age,mobilenumber,dateofbirth,registrationdate,registrationtime,ageduration,paymenttype,billtype,accountname,maintype,subtype,locationname,locationcode,username,scheme_id,planname) values ('$customercode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$gender','$age','$mobilenumber','$dateofbirth','$dateonly','$timeonly','$ageduration','$paymenttype','$billingtype','$accountname','$maintype','$subtype','$locationname','$locationcode', '$username','$scheme_id','$planname')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) ;
		if( mysqli_errno($GLOBALS["___mysqli_ston"]) == 1062) {
		   goto patientcreate;
		}
		else if(mysqli_errno($GLOBALS["___mysqli_ston"]) > 0){
		   die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		}
        $patientcode= $customercode; 
		
		visitcreate:
		
		
			$query3 = "select visitcodeprefix from master_company where companystatus = 'Active'"; 
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$visitcodeprefix = $res3['visitcodeprefix'];
			$visitcodeprefix=chop($visitcodeprefix,"-");
			$query3s = "select * from master_location where status = '' and locationcode='$locationcodeget'";
			$exec3s = mysqli_query($GLOBALS["___mysqli_ston"], $query3s) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3s = mysqli_fetch_array($exec3s);
			$loc_anum = $res3s['auto_number'];
			
			$query2 = "select * from master_visitentry order by auto_number desc limit 0, 1";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num=mysqli_num_rows($exec2);
			$res2 = mysqli_fetch_array($exec2);
			$res2visitcode = $res2["visitcode"];
			if($num!='')
			{
			$res2visitnum=strlen($res2visitcode);
			$vvcode6=explode("-",$res2visitcode);
			$testvalue= $vvcode6[1];
			$value6=strlen($testvalue);
			$visitcodepre6=$res2visitnum-$value6;
			}
			if ($res2visitcode == '')
			{
			$visitcode =$visitcodeprefix.'-'.'1'.'-'.$loc_anum; 
			$openingbalance = '0.00';
			}
			else
			{
			$res2visitcode = $res2["visitcode"];
			$visitcode = substr($res2visitcode,$visitcodepre6,$res2visitnum);
			$visitcode = intval($visitcode);
			//$visitcode = $visitcode + 1;
			$visitcode = $testvalue + 1;
			$maxanum = $visitcode;
			$visitcode = $visitcodeprefix.'-'.$maxanum.'-'.$loc_anum; 
			$openingbalance = '0.00';
			}
			
			$query56="insert into master_visitentry(patientcode, visitcode,registrationdate, patientfirstname,patientmiddlename, patientlastname,patientfullname,paymenttype,subtype,billtype,accountname,consultingdoctor,consultingdoctorcode,department,departmentname,consultationdate,consultationtime,consultationfees,consultationremarks,complaint,visittype,paymentstatus,username,visitcount,doctorconsultation,consultationtype,consultationrefund,triagestatus,age,gender,accountfullname,locationcode,scheme_id,planname)values('$patientcode','$visitcode','$dateonly','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$paymenttype','$subtype','$billingtype','$accountname','$consultingdoctor_name','$consultingdoctorcode','$department','$departmentname','$dateonly','$timeonly','0','OTC WALKIN',		'1','hospital','completed','$username','1','completed','$consultationtype','torefund','completed','$age','$gender','$accname_full','$locationcodeget','$scheme_id','$planname')"; 
			$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) ;
			if( mysqli_errno($GLOBALS["___mysqli_ston"]) == 1062) {
			   goto visitcreate;
			}
			else if(mysqli_errno($GLOBALS["___mysqli_ston"]) > 0){
			   die ("Error in query56".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
	
		
		
		if(isset($_POST['dis']) && count($_POST['dis'])>1){
		foreach($_POST['dis'] as $key=>$value)
		{
	    $pairs111 = $_POST['dis'][$key];
		$pairvar111 = $pairs111;
		$pairs112 = $_POST['code'][$key];
		$pairvar112 = $pairs112;
		$pairs113 = $_POST['dis1'][$key];
		$pairs114 = $_POST['code1'][$key];
		
		$icdquery = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_icd where disease = '$pairvar111'"); 
		$execicd = mysqli_fetch_array($icdquery);
		$diseasecode = $execicd['icdcode'];
		
		if($pairvar111 != "")
		{
		
		$icdquery1 = "INSERT into consultation_icd(consultationid,patientcode,patientname,patientvisitcode,accountname,consultationdate,consultationtime,primarydiag,primaryicdcode,secondarydiag,secicdcode,locationname,locationcode)values('$consultationid','$patientcode','$patientfullname','$visitcode','$accname_full','$currentdate','$timestamp','$pairs111','$pairs112','$pairs113','$pairs114','$locationnameget','$locationcodeget')";
		$execicdquery = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery1) or die("Error in icdquery1". mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		}
		}
		}
		$billnumbercode='';
		for ($p=1;$p<=200;$p++)
		{	
		if(isset($_REQUEST['medicinename'.$p]))
		{
			//echo 'medicinename'.$p;
		    $medicinename = $_REQUEST['medicinename'.$p];
			$medicinename = addslashes($medicinename);
			
			$medicinecode = isset($_REQUEST['medicinecode'.$p])?trim($_REQUEST['medicinecode'.$p]):"";
			if($medicinecode==""){
				$query77="select * from master_medicine where itemname='$medicinename' and status <> 'deleted'";
			}
			else{
				$query77="select * from master_medicine where TRIM(itemcode)='$medicinecode' and status <> 'deleted'";
			}
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			if($subtypeano != '')
			{
				$rate=$res77['subtype_'.$subtypeano];
			}
			else{			
			$rate=$res77[$locationcodeget.'_rateperunit'];
			}
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
			$rate=$_REQUEST['rates'.$p];
			$rate=preg_replace('[,]','',$rate);
			$amount1 = $_REQUEST['amount'.$p];
			$amount=preg_replace('[,]','',$amount1);
			$exclude = $_REQUEST['exclude'.$p];
			$dosemeasure = $_REQUEST['dosemeasure'.$p];
			if ($medicinename != "" && $medicinecode!="")
			{
				
			$querytype = "select type from master_medicine where itemcode='$medicinecode' ";
			$exectype = mysqli_query($GLOBALS["___mysqli_ston"], $querytype);
			$restype = mysqli_fetch_array($exectype);
			$drugtype = $restype['type'];
			
			if($drugtype=='DRUGS'){
			$querytype = "select drugs_store from master_location where locationcode='$locationcodeget' ";
			$exectype = mysqli_query($GLOBALS["___mysqli_ston"], $querytype);
			$restype = mysqli_fetch_array($exectype);
			$default_storecode = $restype['drugs_store'];
			} elseif($drugtype=='NON DRUGS'){
			$querytype = "select nondrug_store from master_location where locationcode='$locationcodeget'";
			$exectype = mysqli_query($GLOBALS["___mysqli_ston"], $querytype);
			$restype = mysqli_fetch_array($exectype);
			$default_storecode = $restype['nondrug_store'];	
			}	
				
				
				
		        //echo '<br>'. 
			$query65 = "select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' and consultation_id='$consultationid' and consultationtime = '$timestamp' and medicinename='$medicinename'";
			$exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num65 = mysqli_num_rows($exec65);
			if($num65 == 0)
			{
				$query2 = "INSERT into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,consultationtime,source,route,excludestatus,locationname,locationcode,dosemeasure,approvalstatus,amendstatus,store,username) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','$consultingdoctor','$billingtype','$accname_full','$status','$medicinecode','$pharefcode','$status','pending','$timestamp','doctorconsultation','$route','$exclude','$locationnameget','$locationcodeget','$dosemeasure','$approvalstatus','2','$default_storecode','$username')";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$query29 = "INSERT into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,prescribed_quantity,source,route,excludestatus,locationname,locationcode,dosemeasure,approvalstatus,amendstatus,store,username) 
				values('$consultationid','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$currentdate','$ipaddress','$consultingdoctor','$billingtype','$accname_full','$status','$medicinecode','$pharefcode','$quantity','doctorconsultation','$route','$exclude','$locationnameget','$locationcodeget','$dosemeasure','$approvalstatus','2','$default_storecode','$username')";
				$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		
		}
	}
		
		header("location:otc_walking_approval.php");
        exit;
    
       }
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];

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
$paynowbillprefix = 'EB-';
        $paynowbillprefix1=strlen($paynowbillprefix);
        $query2 = "select consultation_id from master_consultationpharm where consultation_id like 'EB-%' order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$billnumber = $res2["consultation_id"];
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
			$billnumbercode ='EB-'.'1'."-".date('y');
			$openingbalance = '0.00';
		}
		else
		{
			 $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
			 $billnumbercode = intval($billnumbercode);
			$billnumbercode = $billnumbercode + 1;
			$maxanum = $billnumbercode;
			$billnumbercode = 'EB-' .$maxanum."-".date('y');
			$openingbalance = '0.00';
		}
$billnumber=$billnumbercode;
?>
<?php
include ("autocompletebuild_lab1.php");
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
	funcCustomerDropDownSearch10();
	funcCustomerDropDownSearch15();
	 //To handle ajax dropdown list.
	
	//funcPopupPrintFunctionCall();
	
	funcCustomerDropDownSearch4();
		
		//funcOnLoadBodyFunctionCall1();
	
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
<script type="text/javascript">
function dobcalc()
{
var age=document.getElementById("age").value;
var year1= new Date();
var yob=year1.getFullYear() - age;
var dob= yob+"-"+"0"+1+"-"+"0"+1;
document.getElementById("dateofbirth").value = dob;
console.log(dob);
}
</script>
<?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewmedicine1_selfwalkin.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch12_new.js"></script>
<script type="text/javascript" src="js/insertnewitem13.js"></script>
<script type="text/javascript" src="js/insertnewitem14.js"></script>
<?php include ("js/dropdownlist1icd.php"); ?>
<script type="text/javascript" src="js/autosuggestnewicdcode.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newicd.js"></script>
<?php include ("js/dropdownlist1icd1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewicdcode1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newicd1.js"></script>
<script type="text/javascript" src="js/insertnewitem11_new1.js"></script>
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
VarRate=VarRate.replace(/[^0-9\.]+/g,"");
var ResultAmount = parseFloat(VarRate * ResultFrequency);
//alert(ResultAmount);
//ResultAmount =Math.ceil(ResultAmount/5)*5;
  document.getElementById("amount").value = formatMoney(ResultAmount);
  
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
var varr=parseFloat(VarRate.replace(/[^0-9\.]+/g,""));
var ResultAmount = parseFloat(varr * ResultFrequency);
//alert(ResultAmount);
//ResultAmount =Math.ceil(ResultAmount/5)*5;
 document.getElementById("amount").value = formatMoney(ResultAmount);
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
</script>

<script>
function FuncPopup()
{
	window.scrollTo(0,0);
	document.body.style.overflow='auto';
	document.getElementById("imgloader").style.display = "";
	//return false;
}
function validatenumerics(key) {
           //getting key code of pressed key
           var keycode = (key.which) ? key.which : key.keyCode;
           //comparing pressed keycodes
           if (keycode > 31 && (keycode < 48 || keycode > 57)) {
               //alert(" You can enter only characters 0 to 9 ");
               return false;
           }
           else return true;
 
       }
function validcheck()
{
	var typepatient=$("#searchpaymentcode").val();
if(typepatient=='2' && document.getElementById("customercode").value==''){
	alert("Please select Patient Either from Existing Patient or Create New Patient.");
	return false;
}
	
if(document.getElementById("customername").value=='')
{
alert("Please select the patient First Name");
document.getElementById("customername").focus();
return false;
}
if(document.getElementById("customerlastname").value=='')
{
alert("Please select the patient Last Name");
document.getElementById("customerlastname").focus();
return false;
}
var alpha = /^[a-zA-Z ]*$/; 
if (isNaN(document.getElementById("age").value))
{
	alert ("Please Enter Number to Age");
	document.getElementById("age").focus();
	return false;
}
if(document.getElementById("age").value=='')
{
alert("Please select the patient Age");
document.getElementById("age").focus();
return false;
}
if (document.getElementById("total").value == '' || parseFloat(document.getElementById("total").value)<=0) 
{
	 alert("Please Select Medicine");
	// document.getElementById("customer").focus();
	 return false;
}	
/*if (document.getElementById("consultingdoctor").value == '') 
     {
	 alert("Please Enter the Consulting Doctor");
	 document.getElementById("consultingdoctor").focus();
	 return false;
	 }	*/
/*
var var2=document.getElementById("billtype").value;
if(var2=="PAY LATER")
{
	if(document.getElementById("insertrow13").childNodes.length < 2)
		{
		alert("Please Enter the primary disease");
		document.getElementById("dis").focus();
		return false;
		}
}
*/
	document.getElementById("Submit222").disabled=true;
	var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		document.getElementById("Submit222").disabled=false;
		return false;
	}
	else
	{
		FuncPopup();
		document.form1.submit();			
	}
}
function collapsethis(getid){
if (document.getElementById("customercode").value == '') 
     {
	 alert("Please Select Patient");
	 document.getElementById("customer").focus();
	 return false;
	 }	
	
$("#"+getid).toggle();
}
</script>
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
padding-left:800px;
text-align:right;
font-weight:bold;
}
-->
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
.ui-menu .ui-menu-item{ zoom:1 !important; }
.red-border{
        border: 1px solid red;
    }
.ui-menu .ui-menu-item{ zoom:1 !important; }
</style>
<script src="jquery/jquery-1.11.3.min.js"></script>
<script src="js/datetimepicker_css.js"></script>
<link href="autocomplete.css" rel="stylesheet">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
</head>
<script>
function printConsultationBill()
 {
  if (document.getElementById("nettamount").value != "0.00")
	{
var popWin; 
popWin = window.open("print_external_bill.php?billnumber=<?php echo $billnumbercode; ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
    }
 }
</script>
<script>
function functioncheckpatient()
{
return true;
}
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
function btnDeleteClick(delID,pharmamount)
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
	currenttot=Number(currenttotal4.replace(/[^0-9\.]+/g,""));
	//alert(currenttotal);
	newtotal4= currenttot-pharmamount;
	
	//alert(newtotal);
	
	document.getElementById('total').value=formatMoney(newtotal4);
	
	var currentgrandtotal4=document.getElementById('total4').value;
	
	if(document.getElementById('total1').value=='')
	{
	totalamount11=0;
	}
	else
	{
	total11=document.getElementById('total1').value;
	totalamount11=Number(total11.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount21=0;
	}
	else
	{
	total21=document.getElementById('total2').value;
	totalamount21=Number(total21.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	total31=document.getElementById('total3').value;
	totalamount31=Number(total31.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total5').value=='')
	{
	totalamount41=0;
	}
	else
	{
	total41=document.getElementById('total5').value;
	totalamount41=Number(total41.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountrr=0;
	}
	else
	{
	totalrr=document.getElementById('totalr').value;
	totalamountrr=Number(totalrr.replace(/[^0-9\.]+/g,""));
	}
	
	var newgrandtotal4=parseFloat(newtotal4)+parseFloat(totalamount11)+parseFloat(totalamount21)+parseFloat(totalamount31)+parseFloat(totalamount41)+parseFloat(totalamountrr);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal4.toFixed(2);
	
	
}
function cashentryonfocus1()
{
	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
	}
}
</script>
<script>
$(function() {
/*$('#customer').keyup(function(){
pid=$('#customer').val();
$.ajax({
		type: "POST",
		url: "ajaxexternalcustomernewsearch_lab.php",
		data:{'term':pid},
		success:function(data){
		alert(data);
		}
		});
});	*/
$('#customersearch').autocomplete({
		
	source:'ajaxselfcustomernewsearch.php', 
	//alert(source);
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var customercode = ui.item.customercode;
			var patientfirstname = ui.item.value;
			var customername = ui.item.customername;
			var patientmiddlename = ui.item.customermiddlename;
			var patientlastname = ui.item.customerlastname;
			var age = ui.item.age;
			var gender = ui.item.gender;
			var mobile = ui.item.mobile;
			
            
			$('#customercode').val(customercode);
			$('#customername').val(customername);
			$('#customermiddlename').val(patientmiddlename);
			$('#customerlastname').val(patientlastname);
			$('#age').val(age);
			$('#gender').val(gender);			
			$('#mobilenumber').val(mobile);			
			}
    });
});
</script>
<script>
$(document).ready(function() {
	$("input:radio[name=searchpaymenttype]").click(function () {	
		var val=this.value;	
		$("#searchpaymentcode").val(val);
		if(val =="1")
		{$("#oldsearch").hide();	
		}else{
		$("#oldsearch").show();
		}
	});
});
</script>
<style>
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
 
 
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<div align="center" class="imgloader" id="imgloader" style="display:none;">
<div align="center" class="imgloader" id="imgloader1" style="display:;">
<p style="text-align:center;"><strong>Saving <br><br> Please Wait...</strong></p>
<img src="images/ajaxloader.gif">
</div>
</div>
<form name="form1" id="frmsales" method="post" action="" onSubmit="return validcheck()"   >
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
<?php /* ?><tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<?php */ ?>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%"></td>
    <td width="99%" valign="top">
	<div class="wrapper d-flex align-items-stretch">
	<?php include ("includes/menu1.php"); ?>
	<table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="3" bgcolor="#CCCCCC" class="bodytext32"><strong>Patient Details</strong></td>
	          <td width="19%" align="left" colspan="3" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"> <strong>Location : </strong> <?php  echo $locationname; ?></td>
                <td width="24%" colspan="1" bgcolor="#CCCCCC" class="bodytext32"><strong>&nbsp;</strong>
           <input type="hidden" name="opdate" id="opdate" value="<?= date('Y-m-d') ?>">
            <input type="hidden" name="ipaddress" id="ipaddress" value="<?php echo $ipaddress; ?>">
                <input type="hidden" name="entrytime" id="entrytime" value="<?php echo $timeonly; ?>">   
            
                <input type="hidden" name="locationnameget" id="locationname" value="<?php echo $locationname;?>">
                <input type="hidden" name="locationcodeget" id="locationcode" value="<?php echo $locationcode;?>">
				
				  <input name="billtype" id="billtype" value = "<?php echo $billingtype;?>" type = "hidden">
				  <input name="paymenttype" id="paymenttype" value="<?php echo $paymenttype;?>" type="hidden">
				  <input name="subtypeano" id="subtypeano" value="<?php echo $subtype;?>" type="hidden">
				  <input name="subtype" id="subtype" value="<?php echo 'CASH';?>" type="hidden">
				  <input name="dateofbirth" id="dateofbirth" value="" type="hidden">
                </td>
                
			 </tr>
             <tr bgcolor="#CCCCCC">
             <td colspan="8" bgcolor="#CCCCCC"></td>
             </tr>
              
              <tr>
                <td colspan="11" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
               
              </tr>
              
                
			<tr>
			 <td></td>
            </tr>
		
            <tr>
                        
			<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
			<input type="radio" name="searchpaymenttype" id="searchpaymenttype11" value="1"> <label for="searchpaymenttype11"><strong>New Patient</strong></label>
			<input type="radio" name="searchpaymenttype" id="searchpaymenttype12" value="2"> <label for="searchpaymenttype12"><strong>Existing Patient</strong></label>
			<input type="hidden" name="searchpaymentcode" id="searchpaymentcode">
			</td>
			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong></strong> </td>
              <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Store</strong> </td>
			  <td>
			    <select name="store" id="store" >
				<?php if($storecode != '') { ?>
				<option value="<?php echo $storecode; ?>"><?php echo $store; ?></option>
				<?php } ?>
				<?php 
				$query9 = "select * from master_employeelocation where username = '$username' and locationcode = '$locationcode' and defaultstore='default'";
				$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res9 = mysqli_fetch_array($exec9))
				{
				$res9anum = $res9['storecode'];
				$res9default = $res9['defaultstore'];
				$query10 = "select * from master_store where auto_number = '$res9anum'";
				$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res10 = mysqli_fetch_array($exec10);
				$res10storecode = $res10['storecode'];
				$res10store = $res10['store'];
				$res10anum = $res10['auto_number'];
				?>
				<option value="<?php echo $res10storecode; ?>" selected><?php echo $res10store; ?></option>
				<?php } ?>
				</select>
			  </td>
              
            </tr>
			
			
			<tr id="oldsearch">
			<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32" style='color:red'> <strong>* Patient Search  </strong> </span></td>
			 <td align="left" valign="middle" colspan="2"  bgcolor="#ecf0f5"><input name="customersearch" id="customersearch" value="" style="text-transform:uppercase;" size="60" autocomplete="off"></td>
			</tr>
                        
        	<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32" style='color:red'> <strong>&nbsp;* First Name  </strong> </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> &nbsp;Middle Name   </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32" style='color:red'> <strong>&nbsp;* Last Name  </strong> </span></td>
				  </tr>
				<tr>
                <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="customername" id="customername" value="" style="text-transform:uppercase;" size="18" autocomplete="off">
				<input type="hidden" name="customercode" id="customercode" value="" style="text-transform:uppercase;" size="18" autocomplete="off">
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>"size="45"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input name="customermiddlename" id="customermiddlename" value="" style="text-transform:uppercase;" size="18" autocomplete="off"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="customerlastname" id="customerlastname" value="" style="text-transform:uppercase;" size="18" autocomplete="off"></td>
				</tr>       
               
			   <tr>
			    <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong style='color:red'> * Age </strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="text" name="age" id="age" value="" size="5"  onKeyUp="return dobcalc();" onKeyPress="return validatenumerics(event);" autocomplete="off"/>&nbsp;
				
				<select name="duration" id="duration" tabindex="6">
				  <option value="YEARS">YEARS</option>
				  <option value="MONTHS">MONTHS</option>
				  <option value="DAYS">DAYS</option>
				  </select>	</td>			
			   	  <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong style='color:red'>* Gender</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<select name="gender" id="gender" tabindex="6">
				  <option value="">Select</option>
				  <option value="Male">Male</option>
				  <option value="Female">Female</option>
				  </select>
               </td>	
                </tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong>Bill Date</strong></td>
				<td><input type="text" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" size="18" rsize="20" readonly/>				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Bill No</strong></td>
				<td><input type="text" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" size="18" rsize="20" readonly/></td>
				  </tr>
                  				
				  <tr>
				<td align="left" valign="middle" class="bodytext3"><strong>Mobile</strong></td>
				<td><input name="mobilenumber" id="mobilenumber" value="" type="text" autocomplete="off"></td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Bill Type</strong></td>
				 <td><input name="billtype" id="billtype" value="PAY NOW" type="text" readonly></td>
				  </tr>
				 <tr style="display: none;" id="paylater_show">
				   <td align="left" valign="middle" class="bodytext3"><strong></strong></td>
				 <td></td>
				<td align="left" valign="middle" class="bodytext3"><font color='red'><strong>Available limit</strong></font></td>
				<td><input type="text" name="availablelimit" id="availablelimit" value="" size="18" rsize="20" readonly/>				</td>	
                 
				  </tr>
				  <tr style="display: none;" id="current_icd_show">
		        <td colspan="7" class="bodytext31" valign="center"  align="left"><strong><font color='red'>Current ICD : </font></strong><span id='currenticd'></span>
		 
		          </td>
		    </tr>
	     <tr style="display: none;" id="past_icd_show">
		        <td colspan="7" class="bodytext31" valign="center"  align="left"><strong><font color='red'>Previous Visit ICD : </font></strong><span id='pasticd'></span>
		 
		          </td>
		</tr>
				  	<tr>
			                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
						 </tr>
				  <tr style="display: none;" id="iscapitation_show">
         				<td  colspan="4">
			        	 	<p style="color: red; text-align: justify; padding-bottom: 6px;"><b>Capitation Account, Please Inform client about no Refunds on the Medicine after Issue.</b></p>
						</td>
				  </tr>
				 
            </tbody>
        </table></td>
      </tr>
     
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="100%" 
            align="left" border="0">
          <tbody id="foo">
       
				  
				   <tr >
				   <td colspan="11" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>Pharmacy <img src="images/plus1.gif" width="13" height="13"> </strong></span></td>
			      </tr>
				  
				  <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="200" class="bodytext3">Medicine Name</td>
                       <td width="48" class="bodytext3">Stk</td>
                       <td width="48" class="bodytext3">Dose</td>
                       <td width="48" class="bodytext3">Dose.Measure</td>
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
						<input name="hiddenmedicinename" id="hiddenmedicinename" value="" type="hidden">
                       <td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off" >					   </td>
                       <td>
                      		<input name="toavlquantity" type="text" id="toavlquantity" size="8" readonly  > 
                      	</td>
                       <td><input name="dose" type="text" id="dose" size="8" onKeyUp="return Functionfrequency()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
					   <td>
					   	<!-- <select name="dosemeasure" id="dosemeasure">
					   <option value="">Select Measure</option>
					   <option value="suppositories">suppositories</option>
					   <option value="tabs">tabs</option>
					   <option value="caps">caps</option>
					   <option value="ml">ml</option>
					   <option value="vial">vial</option>
					   <option value="inj">inj</option>
					   <option value="amp">amp</option>
					    <option value="gel">Gel</option>
					   <option value="tube">tube</option>
					   <option value="mg">mg</option>
					   <option value="drops">drops</option>
					   <option value="pcs">pcs</option>
					   </select> -->
					   <select class="dose_measure" name="dosemeasure" id="dosemeasure" >
								 <option value="">Select Measure</option>
								 <?php
								 // $dose_measure='3';
								     $query_prod_type = "select * from dose_measure where status = '1' ";
								     $exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die ("Error in query_prod_type".mysqli_error($GLOBALS["___mysqli_ston"]));
								 while ($res_prod_type = mysqli_fetch_array($exec_prod_type))
								 {
								     $res_prod_id3 = $res_prod_type['id'];
								     $res_prod_name3 = $res_prod_type['name'];
								 ?>
		                          <option value="<?php echo $res_prod_name3; ?>"  ><?php echo $res_prod_name3; ?></option>
								 <?php
								     }
								 ?>
						    </select> 
						    <!-- <option value="<?php // echo $res_prod_name3; ?>" <?php // if($dose_measure == $res_prod_id3){ // echo 'selected="selected"';}?> ><?php // echo $res_prod_name3; ?></option> -->
					</td>
                       <td>
					   <select name="frequency" id="frequency" onChange="( Functionfrequency())">
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
                       <td><input name="days" type="text" id="days" size="8" onKeyUp="return Functionfrequency()" onFocus="return frequencyitem()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
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
                       <td width="48">
                       <input name="rates" type="text" id="rates"  size="8" onKeyUp="return Functionfrequency()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                       </td>
                       <td>
                         <input name="amount" type="text" id="amount" readonly size="8"></td>
						  <td>
						  <input name="exclude" type="hidden" id="exclude" readonly size="8">
						  <input type="hidden" name="drugallergy" class="bodytext32" id="drugallergy" value="">
					   <input type="hidden" name="genericname" class="bodytext32" id="genericname" value="">
                         <input name="formula" type="hidden" id="formula" readonly size="8"></td>
						 <td>
                         <input name="strength" type="hidden" id="strength" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="( insertitem(), fortreatment())" class="button" >
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
				   		  <tr id="disease">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="767" border="0" cellspacing="1" cellpadding="1">
                     <!--
					 <tr>
                     <td class="bodytext3">Priliminary Diseases</td>
				   <td width="423"> <input name="dis2[]" id="dis2" type="text" size="69" autocomplete="off"></td>
                   </tr> -->
                     
                     <tr>
					 <td width="72" class="bodytext3"></td>
                       <td width="423" class="bodytext3">Disease</td>
                       <td class="bodytext3">Code</td>
					   <td class="bodytext3"></td>
                     </tr>
					  <tr>
					 <div id="insertrow13">					 </div></tr>
                     					  <tr>
					  <input type="hidden" name="serialnumberdisease" id="serialnumberdisease" value="1">
					  <input type="hidden" name="diseas" id="diseas" value="">
					  <td class="bodytext3">Primary</td>
				   <td width="423"> <input name="dis[]" id="dis" type="text" size="69" autocomplete="off"></td>
				      <td width="101"><input name="code[]" type="text" id="code" readonly size="8">
				        <input name="autonum" type="hidden" id="autonum" readonly size="8">
					  <input name="searchdisease1hiddentextbox" type= "hidden" id = "searchdisease1hiddentextbox" >
					  <input name="chapter[]" type="hidden" id="chapter" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem13()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
				      </table>						</td>
		        </tr>
				
				 
				  <tr id="disease1">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="769" border="0" cellspacing="1" cellpadding="1">
                     <tr>
					 <td width="72" class="bodytext3"></td>
                       <td width="423" class="bodytext3">Disease</td>
                       <td class="bodytext3">Code</td>
					   <td class="bodytext3"></td>
                     </tr>
					  <tr>
					 <div id="insertrow14">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumberdisease1" id="serialnumberdisease1" value="1">
					  <input type="hidden" name="diseas1" id="diseas1" value="">
					  <td class="bodytext3">Secondary </td>
				   <td width="423"> <input name="dis1[]" id="dis1" type="text" size="69" autocomplete="off"></td>
				      <td width="101"><input name="code1[]" type="text" id="code1" readonly size="8">
					  <input name="autonum1" type="hidden" id="autonum1" readonly size="8">
					  <input name="searchdisease1hiddentextbox1" type= "hidden" id = "searchdisease1hiddentextbox1" >
					  <input name="chapter1[]" type="hidden" id="chapter1" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem14()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
				      </tr>
				      </table>						</td>
		        </tr>
				  
				   
				  <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Total</strong><input type="text" name="total" id="total" readonly size="7">  <input type="hidden" id="total2" readonly size="7"><input type="hidden" id="total3" readonly size="7"><input type="hidden" id="total4" readonly size="7"><input type="hidden" id="total1" readonly size="7"><input type="hidden" id="totalr" readonly size="7"><input type="hidden" id="total5" readonly size="7"></td>
				  </td>
				  </tr> 
		         
          </tbody>
        </table>		
		
		</td>
		<tr>
		 <td colspan="7" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
		
        
                      <tr>
                
                <td colspan="14" align="left" valign="center"  
                bgcolor="#CCCCCC" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                  <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">
                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">
				  <input name="Submit2223" id="Submit222" type="submit" onClick="return validcheck();"  value="Save Bill(ALT+S)" accesskey="s" class="button"/>
                </font></font></font></font></font></div></td>
              </tr>
			
	     
	
    </table>
</form>
</div>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
<script>
$(document).ready(function(e) {
    $("#searchpaymenttype12").trigger('click');
	$("#customersearch").focus();
});
$(document).ready(function(e) {
	//alert();
	$('#customersearch').focus();
   // $("#radid").toggle();
});
</script>
</body>
</html>